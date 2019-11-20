<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'body',
        'title'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Returns what should be the one recipient
    public function recipient()
    {
        return $this->recipients->first();
    }

    // Support for many though we will most like stick to 1
    public function recipients()
    {
        return $this->belongsToMany( User::class, 'note_user', 'note_id', 'user_id' );
    }
}
