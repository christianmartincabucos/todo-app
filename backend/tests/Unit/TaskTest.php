<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use MakesGraphQLRequests;
    // use RefreshDatabase;
    
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Create a user for authentication
        $this->user = User::factory()->create();
    }

    /** @test */
    public function it_creates_a_task_with_valid_inputs()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->graphQL('
            mutation createTask($description: String!, $status: String!) {
                createTask(description: $description, status: $status) {
                    id
                    description
                    status
                }
            }
        ', [
            'description' => 'New Task Description',
            'status' => 'todo',
        ]);

        $this->assertTrue(auth()->check());

        $response->assertJson([
            'data' => [
                'createTask' => [
                    'description' => 'New Task Description',
                    'status' => 'todo',
                ],
            ],
        ]);

        $this->assertDatabaseHas('tasks', [
            'description' => 'New Task Description',
            'status' => 'todo',
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function testUpdateTaskMutation()
    {
        $this->actingAs($this->user);
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->graphQL('
            mutation ($id: ID!, $status: String!) {
                updateTask(id: $id, status: $status) {
                    id
                    status
                }
            }
        ', [
            'id' => $task->id,
            'status' => 'done',
        ]);

        $response->assertJson([
            'data' => [
                'updateTask' => [
                    'id' => $task->id,
                    'status' => 'done',
                ],
            ],
        ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'done',
        ]);
    }

    /** @test */
    public function testDeleteTaskMutation()
    {
        $this->actingAs($this->user);
        $task = Task::factory()->create(['user_id' => $this->user->id]);

        $response = $this->graphQL('
            mutation ($id: ID!) {
                deleteTask(id: $id) {
                    id
                }
            }
        ', [
            'id' => $task->id,
        ]);

        $response->assertJson([
            'data' => [
                'deleteTask' => [
                    'id' => $task->id,
                ],
            ],
        ]);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
}
