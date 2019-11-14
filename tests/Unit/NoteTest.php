<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Note;
use App\User;

class NoteTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test **/
    public function a_note_has_an_author()
    {
        $note = factory(Note::class)->create();
        $this->assertInstanceOf(User::class, $note->author);
    }
}
