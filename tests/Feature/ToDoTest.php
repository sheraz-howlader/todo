<?php

use App\Models\ToDo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

//uses(RefreshDatabase::class);

beforeEach(function () {
    $user = User::factory()->create();
    $this->actingAs($user, 'sanctum');
});

test('todo::all list', function () {
    ToDo::factory()->count(3)->create();

    $response = $this->getJson('/api/todo-list');

    $response->assertStatus(200)
        ->assertJsonStructure(['todos']);
});

test('todo::can create', function () {
    $data = [
        'task_name' => 'Test Task',
        'description' => 'Test Description',
    ];

    $response = $this->postJson('/api/todo-list', $data);

    $response->assertStatus(200)
        ->assertJsonFragment([
            'success' => true,
            'message' => 'You have successfully save task!',
        ]);

    $this->assertDatabaseHas('to_dos', ['name' => 'Test Task']);
});

test('fetch a todo for editing', function () {
    $todo = ToDo::factory()->create();

    $response = $this->getJson("/api/todo-list/{$todo->id}/edit");

    $response->assertStatus(200)
        ->assertJson($todo->toArray());
});

test('can update a todo', function () {
    $todo = ToDo::factory()->create();

    $data = [
        'task_name' => 'Updated Task',
        'description' => 'Updated description',
    ];

    $response = $this->putJson("/api/todo-list/{$todo->id}", $data);

    $response->assertStatus(200)
        ->assertJsonFragment([
            'success' => true,
            'message' => 'You have successfully update task!',
        ]);

    $this->assertDatabaseHas('to_dos', ['name' => 'Updated Task']);
});

test('can delete a todo', function () {
    $todo = ToDo::factory()->create();

    $response = $this->deleteJson("/api/todo-list/{$todo->id}");

    $response->assertStatus(200)
        ->assertJsonFragment([
            'success' => true,
            'message' => 'You have successfully deleted task!',
        ]);

    $this->assertDatabaseMissing('to_dos', ['id' => $todo->id]);
});

test('can mark as complete a todo', function () {
    $todo = ToDo::factory()->create(['is_complete' => false]);

    $response = $this->postJson('/api/complete-todo-list/', [
        'task_id' => $todo->id,
        'status' => true,
    ]);

    $response->assertStatus(200)
        ->assertJsonFragment([
            'success' => true,
            'message' => "You have successfully completed {$todo->name} task!",
        ]);

    $this->assertDatabaseHas('to_dos', [
        'id' => $todo->id,
        'is_complete' => true,
    ]);
});

test('can mark as incomplete a todo', function () {
    $todo = ToDo::factory()->create(['is_complete' => true]);

    $response = $this->postJson('/api/complete-todo-list/', [
        'task_id' => $todo->id,
        'status' => false,
    ]);

    $response->assertStatus(200)
        ->assertJsonFragment([
            'message' => 'Your task has been marked as incomplete!',
        ]);

    $this->assertDatabaseHas('to_dos', [
        'id' => $todo->id,
        'is_complete' => false,
    ]);
});

test('task creation will fail if the name field is empty', function () {
    $data = [
        'task_name' => '',
        'description' => 'desc'
    ];

    $response = $this->postJson('/api/todo-list', $data);

    $response->assertStatus(422)
        ->assertJsonValidationErrors('task_name');
});
