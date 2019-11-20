<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Note;
use App\User;
use Facades\Tests\Setup\NoteFactory;

class NoteTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test **/
    public function a_note_has_an_author()
    {
        $note = factory(Note::class)->create();
        $this->assertInstanceOf(User::class, $note->author);
    }

    /** @test **/
    public function a_note_has_a_recipient()
    {
        $author = factory(User::class)->create();
        $recipient = factory(User::class)->create();
        $note = NoteFactory::writtenBy($author)
            ->writtenFor($recipient)
            ->create();
        $this->assertInstanceOf(User::class, $note->recipient());
    }
}
