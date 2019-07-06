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
    public function a_user_can_visit_the_page_to_create_a_note()
    {
        $this->withoutExceptionHandling();
        $this->get('/notes/create')
            ->assertOk()
            ->assertViewIs('notes.create');
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

    /** @test **/
    public function a_user_can_view_a_note()
    {
        $this->withoutExceptionHandling();
        $note = factory(Note::class)->create();
        $this->get("/notes/{$note->id}")
            ->assertOk()
            ->assertSee($note->title);
    }

    /** @test **/
    public function a_user_can_visit_the_page_to_edit_a_note()
    {
        $note = factory(Note::class)->create();
        $this->get("/notes/{$note->id}/edit")->assertOk();
    }

    /** @test **/
    public function a_note_can_be_edited()
    {
        // Create our note and get it.
        $note = factory(Note::class)->raw();
        $this->post('/notes', $note);
        $note = Note::where($note)->first();

        // Update our note title
        $this->patch("/notes/{$note->id}", $attributes = [
            'title' => 'changed',
            'body' => $note['body']
        ])->assertRedirect("/notes/{$note->id}");

        // Make sure it's in the db, and that the new title shows
        $this->assertDatabaseHas('notes', $attributes);
        $this->get('/notes')->assertSee($attributes['title']);
    }

    /** @test **/
    public function a_note_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        $attributes = factory(Note::class)->raw();
        $note = Note::create($attributes);
        $this->assertDatabaseHas('notes', $attributes);
        $this->delete("/notes/{$note->id}")->assertRedirect('/notes');
        $this->assertDatabaseMissing('notes', $attributes);
    }
}
