<?php

namespace Tests\Setup;

use App\Note;
use App\User;

class NoteFactory
{
    protected $user;

    public function ownedBy($user)
    {
        $this->user = $user;
        return $this;
    }

    public function create()
    {
        $note = factory(Note::class)->create([
            'user_id' => $this->user ?? factory(User::class)
        ]);

        return $note;
    }
}