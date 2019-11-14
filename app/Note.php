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

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
