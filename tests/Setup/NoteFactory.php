<?php

namespace Tests\Setup;

use App\Note;
use App\User;

class NoteFactory
{
    protected $author;
    protected $recipient;

    public function writtenBy($author)
    {
        $this->author = $author;
        return $this;
    }

    public function writtenFor($recipient)
    {
        $this->recipient = $recipient;
        return $this;
    }

    public function create()
    {
        $note = factory(Note::class)->create([
            'user_id' => $this->author ?? factory(User::class)
        ]);

        $note->recipients()
            ->attach($this->recipient ?? factory(User::class)->create());

        return $note;
    }
}