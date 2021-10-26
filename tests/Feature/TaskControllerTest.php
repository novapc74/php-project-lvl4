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

    /**
    * @param \Illuminate\Contracts\Auth\Authenticatable $user
    */
    public function testStore(): void
    {
        $data = Task::factory()->make()->toArray();
        $dataWithLabel = $data;
        $dataWithLabel['labels'] = [null];

        $user = User::orderBy('id', 'desc')->first();
        $this->actingAs($user);

        $response = $this->post(route('tasks.store'), $dataWithLabel);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', $data);
    }

    public function testShow(): void
    {
        $tasks = Task::factory()->create();
        $response = $this->get(route('tasks.show', [$tasks]));
        $response->assertOk();
    }

    public function testEdit(): void
    {
        $task = Task::factory()->create();
        $response = $this->get(route('tasks.edit', [$task]));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
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
        $task = Task::factory()->create();
        $response = $this->delete(route('tasks.destroy', [$task]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}