<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\Task;
use App\Models\User;
use App\Models\Label;
use App\Models\TaskStatus;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Task::factory()->count(2)->make();
        User::factory()->count(2)->make();
    }

    public function testIndex(): void
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->get(route('tasks.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $user = User::factory()->create();

        $taskStatus = TaskStatus::factory()->create();
        $data = Task::factory()->make()->toArray();
        $dataWithLabel = $data;
        $dataWithLabel['labels'] = [null];

        $task = Task::factory()->create();
        $user = $task->createdBy;
        $response = $this->actingAs($user)
            ->post(route('tasks.store'), $dataWithLabel);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', $data);
    }

    public function testShow(): void
    {
        $user = User::factory()->create();
        $taskStatus = TaskStatus::factory()->create();
        $tasks = Task::factory()->create();

        $response = $this->get(route('tasks.show', [$tasks]));
        $response->assertOk();
    }

    public function testEdit(): void
    {
        $user = User::factory()->create();
        $taskStatus = TaskStatus::factory()->create();
        $task = Task::factory()->create();

        $response = $this->get(route('tasks.edit', [$task]));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $user = User::factory()->create();
        $taskStatus = TaskStatus::factory()->create();
        $task = Task::factory()->create();
        $factoryData = Task::factory()->make()->toArray();
        $data = \Arr::only($factoryData, ['name', 'description', 'status_id']);

        $response = $this->patch(route('tasks.update', $task), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('tasks', $data);
    }

    public function testDestroy(): void
    {
        $user = User::factory()->create();
        $taskStatus = TaskStatus::factory()->create();
        $task = Task::factory()->create();
        $response = $this->delete(route('tasks.destroy', [$task]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
