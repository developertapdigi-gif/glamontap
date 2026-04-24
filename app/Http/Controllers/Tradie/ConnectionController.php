<?php

namespace App\Http\Controllers\Tradie;

use App\Http\Controllers\Controller;
use App\Models\{UserConnection, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConnectionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $friends = UserConnection::with(['sender', 'receiver'])
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)->orWhere('connection_id', $user->id);
            })
            ->where('status', 1)
            ->get();

        $requests = UserConnection::with('sender')
            ->where('connection_id', $user->id)
            ->where('status', 0)
            ->get();

        $sentRequests = UserConnection::with('receiver')
            ->where('user_id', $user->id)
            ->where('status', 0)
            ->get();

        // Collect all connected/pending user IDs to exclude from search
        $excludeIds = UserConnection::where(function ($q) use ($user) {
                $q->where('user_id', $user->id)->orWhere('connection_id', $user->id);
            })
            ->get()
            ->flatMap(fn($c) => [$c->user_id, $c->connection_id])
            ->push($user->id)
            ->unique()
            ->toArray();

        $searchResults = collect();
        if ($request->filled('search')) {
            $term = $request->search;
            $searchResults = User::where('user_type', 3)
                ->whereNotIn('id', $excludeIds)
                ->where(function ($q) use ($term) {
                    $q->where('first_name', 'like', "%$term%")
                      ->orWhere('last_name', 'like', "%$term%")
                      ->orWhere('email', 'like', "%$term%");
                })
                ->get();
        }

        return view('tradie.connections.index', compact('friends', 'requests', 'sentRequests', 'searchResults'));
    }

    public function sendRequest(Request $request)
    {
        $request->validate(['connection_id' => 'required|exists:users,id']);

        $user = Auth::user();

        $exists = UserConnection::where(function ($q) use ($user, $request) {
            $q->where('user_id', $user->id)->where('connection_id', $request->connection_id);
        })->orWhere(function ($q) use ($user, $request) {
            $q->where('user_id', $request->connection_id)->where('connection_id', $user->id);
        })->exists();

        if (!$exists) {
            UserConnection::create([
                'user_id'       => $user->id,
                'connection_id' => $request->connection_id,
                'status'        => 0,
            ]);
        }

        return redirect()->route('tradie.connections.index', ['search' => $request->search_term])
            ->with('success', 'Friend request sent.');
    }

    public function action(Request $request)
    {
        $request->validate([
            'id'     => 'required|exists:user_connections,id',
            'action' => 'required|in:accept,reject,remove',
        ]);

        $connection = UserConnection::findOrFail($request->id);

        if ($request->action === 'accept') {
            $connection->update(['status' => 1]);
        } else {
            $connection->delete();
        }

        return redirect()->route('tradie.connections.index')->with('success', 'Done.');
    }
}
