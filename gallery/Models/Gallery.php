<?php

namespace P3in\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use P3in\Models\User;

class Gallery extends Model
{

    protected $fillable = ['name', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // temp for demo/test purpose
    public function latestActivity($count)
    {
        return Gallery::take($count)
            ->orderBy('updated_at','desc')
            ->get()
            ->makeHidden('id')
            ->makeHidden('user_id');
    }

    public function mostUploads($count)
    {
        return Gallery::take($count)
            ->get()
            ->makeHidden('id')
            ->makeHidden('user_id');
    }
}