<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Chatify\Traits\UUID;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ChMessage extends Model
{
    use UUID;
    protected $table = 'ch_messages';
    public function sender()
    {
        return $this->hasOne(User::class, 'id', 'from_id');
    }

    public function receiver()
    {
        return $this->hasOne(User::class, 'id', 'to_id');
    }
    /**
     * Scope to get latest messages for each conversation involving a user
     *
     * @param Builder $query
     * @param int $userId ID of the user to get conversations for
     * @return Builder
     */
    public function scopeLatestConversations(Builder $query, int $userId): Builder
    {
        return $query->select('t1.*')
            ->from("{$this->table} as t1")
                ->join(DB::raw(
                    "(
                        SELECT LEAST(from_id, to_id) AS user1, 
                            GREATEST(from_id, to_id) AS user2, 
                            MAX(created_at) AS created_at 
                        FROM apr_ch_messages 
                        GROUP BY user1, user2 
                        HAVING user1 = $userId OR user2 = $userId
                    ) AS t3"
                ),
                function ($join) {
                    $join->whereIn('t1.from_id', [\DB::raw('t3.user1'), \DB::raw('t3.user2')])
                        ->whereIn('t1.to_id', [\DB::raw('t3.user1'), \DB::raw('t3.user2')])
                        ->where('t1.created_at', '=', \DB::raw('t3.created_at'));
                }
            )
            ->orderByDesc('t1.created_at');
    }

    public function scopeUnReadConversations(Builder $query, int $userId): Builder
    {
        return $query->select('t1.*')
            ->from("{$this->table} as t1")
            ->where('t1.seen', 0)
            ->where('t1.from_id', '!=', $userId)
                ->join(DB::raw(
                    "(
                        SELECT LEAST(from_id, to_id) AS user1, 
                            GREATEST(from_id, to_id) AS user2, 
                            MAX(created_at) AS created_at 
                        FROM apr_ch_messages 
                        GROUP BY user1, user2 
                        HAVING user1 = $userId OR user2 = $userId
                    ) AS t3"
                ),
                function ($join) {
                    $join->whereIn('t1.from_id', [\DB::raw('t3.user1'), \DB::raw('t3.user2')])
                        ->whereIn('t1.to_id', [\DB::raw('t3.user1'), \DB::raw('t3.user2')])
                        ->where('t1.created_at', '=', \DB::raw('t3.created_at'));
                }
            )
            ->orderByDesc('t1.created_at');
    }
}
