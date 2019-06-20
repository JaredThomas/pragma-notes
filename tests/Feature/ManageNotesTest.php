<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Note;

class ManageNotesTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function a_note_can_be_viewed_on_the_index_view()
    {
        $this->withoutExceptionHandling();
        $note = factory(Note::class)->create();
        $this->get('/notes')->assertSee($note->title);
    }

    /** @test **/
    public function a_note_can_be_created()
    {
        
        $note = factory(Note::class)->raw();

        $this->post('/notes', $note);

        // and should exist in the database
        $this->assertDatabaseHas('notes', $note);
    }

    /** @test **/
    public function a_note_without_a_title_is_not_allowed()
    {
        $note = [
            'body' => 'Where is the title?'
        ];

        $this->post('/notes', $note)
            ->assertSessionHasErrors('title');

        $this->assertDatabaseMissing('notes', $note);
    }

    /** @test **/
    public function a_note_without_a_body_is_not_allowed()
    {
        $note = [
            'title' => 'No body?'
        ];

        $this->post('/notes', $note)
            ->assertSessionHasErrors('body');

        $this->assertDatabaseMissing('notes', $note);
    }
}
