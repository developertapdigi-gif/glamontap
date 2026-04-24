<?php

namespace App\Http\Controllers\Tradie;

use App\Http\Controllers\Controller;
use App\Models\{Post, PostGallery, SkillCategory, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('gallery')->where('author_id', Auth::id())->latest()->paginate(10);
        return view('tradie.posts.index', compact('posts'));
    }

    public function create()
    {
        $skills = SkillCategory::where('status', 1)->get();
        return view('tradie.posts.create', compact('skills'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required',
            'description' => 'required',
            'media'       => 'required|file|mimes:jpeg,png,jpg,mp4|max:20480',
        ]);

        $post = Post::create([
            'title'             => $request->title,
            'short_description' => $request->description,
            'author_id'         => Auth::id(),
            'skill_id'          => $request->skill_category_id,
            'status'            => 1,
        ]);

        if ($request->hasFile('media')) {
            $file     = $request->file('media');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/uploads'), $filename);
            PostGallery::create([
                'post_id' => $post->id,
                'path'    => 'uploads/uploads/' . $filename,
                'type'    => in_array($file->getClientOriginalExtension(), ['mp4']) ? 2 : 1,
            ]);
        }

        return redirect()->route('tradie.posts.index')->with('success', 'Post created successfully.');
    }

    public function show($id)
    {
        $post = Post::with(['gallery', 'SkillCategory'])->where('id', $id)->where('author_id', Auth::id())->firstOrFail();
        return view('tradie.posts.show', compact('post'));
    }

    public function edit($id)
    {
        $post   = Post::where('id', $id)->where('author_id', Auth::id())->firstOrFail();
        $skills = SkillCategory::where('status', 1)->get();
        return view('tradie.posts.edit', compact('post', 'skills'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::where('id', $id)->where('author_id', Auth::id())->firstOrFail();

        // Only editable within 2 days
        if ($post->created_at->diffInDays(now()) > 2) {
            return redirect()->route('tradie.posts.index')->with('error', 'Post can only be edited within 2 days.');
        }

        $request->validate([
            'title'       => 'required',
            'description' => 'required',
        ]);

        $post->update([
            'title'             => $request->title,
            'short_description' => $request->description,
            'skill_id'          => $request->skill_category_id,
        ]);

        return redirect()->route('tradie.posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy($id)
    {
        Post::where('id', $id)->where('author_id', Auth::id())->firstOrFail()->delete();
        return redirect()->route('tradie.posts.index')->with('success', 'Post deleted successfully.');
    }

}
