<?php

namespace Tests\Feature;

use Tests\TestCase;
use Facades\Tests\Setup\NoteFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Note;
use App\User;

class ManageNotesTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function a_note_by_the_user_can_be_viewed_on_the_index_view()
    {
        $note = factory(Note::class)->create();
        $this->actingAs($note->author)
            ->get('/notes')
            ->assertSee($note->title);
    }

    /** @test **/
    public function a_logged_out_user_cannot_view_any_notes()
    {
        $this->get('/notes')
            ->assertRedirect('/login');
    }

    /** @test **/
    public function a_logged_out_user_cannot_create_a_note()
    {
        $this->get('/notes/create')
            ->assertRedirect('/login');
    }

    /** @test **/
    public function another_user_cannot_access_a_note_they_did_not_author() {
        $tom = factory(User::class)->create();
        $sally = factory(User::class)->create();
        $note = NoteFactory::writtenBy($sally)->create();
        $this->actingAs($tom)
            ->get('/notes')
            ->assertDontSee($note->title);
    }

    /** @test **/
    public function a_logged_in_user_can_visit_the_page_to_create_a_note()
    {
        $tom = factory(User::class)->create();
        $this->actingAs($tom)
            ->get('/notes/create')
            ->assertOk()
            ->assertViewIs('notes.create');
    }

    /** @test **/
    public function a_note_can_be_created()
    {
        $tom = factory(User::class)->create();
        $sally = factory(User::class)->create();
        $noteContent = [
            'title' => 'Hey',
            'body' => 'Checking to see how you are doing',
        ];
        $noteRecipient = [
            'recipient' => $sally->id
        ];

        $this->actingAs($tom)
            ->post('/notes', array_merge($noteContent, $noteRecipient))
            ->assertRedirect( '/notes' );

        $this->assertDatabaseHas('notes', $noteContent);
        $note = Note::where('title', $noteContent['title'])->first();
        $this->assertEquals( $note->recipient()->id, $sally->id );
    }

    /** @test **/
    public function a_note_without_a_title_is_not_allowed()
    {
        $note = [
            'body' => 'Where is the title?',
            'recipient' => 1
        ];

        $tom = factory(User::class)->create();
        $this->actingAs($tom)
            ->post('/notes', $note)
            ->assertSessionHasErrors('title');

        $this->assertDatabaseMissing('notes', $note);
    }

    /** @test **/
    public function a_note_without_a_body_is_not_allowed()
    {
        $note = [
            'title' => 'No body?',
            'recipient' => 1
        ];
        $tom = factory(User::class)->create();

        $this->actingAs($tom)
            ->post('/notes', $note)
            ->assertSessionHasErrors('body');

        $this->assertDatabaseMissing('notes', $note);
    }

    /** @test **/
    public function a_note_without_a_recipient_is_not_allowed()
    {
        $note = [
            'title' => 'Happy',
            'body' => 'Glad you are doing well!'
        ];
        $sally = factory(User::class)->create();
        $this->actingAs($sally)
            ->post('/notes', $note)
            ->assertSessionHasErrors('recipient');
        $this->assertDatabaseMissing('notes', $note);
    }

    /** @test **/
    public function an_author_and_recipient_can_view_a_note()
    {
        $sally = factory(User::class)->create();
        $tom = factory(User::class)->create();
        $note = NoteFactory::writtenBy($sally)
            ->writtenFor($tom)
            ->create();

        // author
        $this->actingAs($sally)
            ->get("/notes/{$note->id}")
            ->assertOk()
            ->assertSee($note->title);

        // recipient
        $this->actingAs($tom)
            ->get("/notes/{$note->id}")
            ->assertOk()
            ->assertSee($note->title);
    }

    /** @test **/
    public function any_other_user_cannot_see_the_note()
    {
        $tom = factory(User::class)->create();
        $sally = factory(User::class)->create();
        $note = NoteFactory::writtenBy($sally)->create();
        $this->actingAs($tom)
            ->get("/notes/{$note->id}")
            ->assertForbidden();
    }

    /** @test **/
    public function an_author_can_visit_the_page_to_edit_a_note()
    {
        $sally = factory(User::class)->create();
        $note = NoteFactory::writtenBy($sally)->create();
        $this->actingAs($sally)
            ->get("/notes/{$note->id}/edit")
            ->assertOk();
    }

    /** @test **/
    public function any_other_user_cannot_visit_the_page_to_edit_a_note()
    {
        $sally = factory(User::class)->create();
        $tom = factory(User::class)->create();
        $sara = factory(User::class)->create();
        $note = NoteFactory::writtenBy($sally)
            ->writtenFor($tom)
            ->create();

        // recipient
        $this->actingAs($tom)
            ->get("/notes/{$note->id}/edit")
            ->assertForbidden();

        // not an author or recipient
        $this->actingAs($sara)
            ->get("/notes/{$note->id}/edit")
            ->assertForbidden();
    }

    /** @test **/
    public function a_note_can_be_edited()
    {
        // Create our note and get it.
        $sally = factory(User::class)->create();
        $note = NoteFactory::writtenBy($sally)->create();

        // Update our note title
        $this->actingAs($sally)
            ->patch("/notes/{$note->id}", $attributes = [
                'title' => 'changed',
                'body' => $note->body
            ])
            ->assertRedirect("/notes/{$note->id}");

        // Make sure it's in the db, and that the new title shows
        $this->assertDatabaseHas('notes', $attributes);
        $this->actingAs($sally)
            ->get('/notes')
            ->assertSee($attributes['title']);
    }

    /** @test **/
    public function a_note_cannot_be_edited_by_another_user()
    {
        // Create our note and get it.
        $sally = factory(User::class)->create();
        $tom = factory(User::class)->create();
        $note = NoteFactory::writtenBy($sally)->create();

        // Update our note title
        $this->actingAs($tom)
            ->patch("/notes/{$note->id}", $attributes = [
                'title' => 'changed',
                'body' => $note->body
            ])
            ->assertForbidden();

        // Make sure it's in the db, and that no changes were made
        $this->assertDatabaseHas('notes', $note->toArray());
    }

    /** @test **/
    public function a_note_can_be_deleted_by_the_author()
    {
        $sally = factory(User::class)->create();
        $note = NoteFactory::writtenBy($sally)->create();
        $this->assertDatabaseHas('notes', $note->toArray());
        $this->actingAs($sally)
            ->delete("/notes/{$note->id}")
            ->assertRedirect('/notes');
        $this->assertDatabaseMissing('notes', $note->toArray());
    }

    /** @test **/
    public function a_note_cannot_be_deleted_by_any_other_user()
    {
        $sally = factory(User::class)->create();
        $tom = factory(User::class)->create();
        $note = NoteFactory::writtenBy($sally)->create();
        $this->assertDatabaseHas('notes', $note->toArray());
        $this->actingAs($tom)
            ->delete("/notes/{$note->id}")
            ->assertForbidden();
        $this->assertDatabaseHas('notes', $note->toArray());
    }
}
