<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Arr;

class TaskStatusControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testIndex(): void
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertStatus(200);
    }

    public function testCreate(): void
    {
        $user = User::factory()->create();
        /** @var User $user */
        $response = $this->actingAs($user)
            ->get(route('task_statuses.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $factoryData = TaskStatus::factory()->make()->toArray();
        $newTaskStatus = Arr::only($factoryData, ['name', 'description']);
        $user = User::factory()->create();
        /** @var User $user */
        $response = $this->actingAs($user)
            ->post(route('task_statuses.store'), $newTaskStatus);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseHas('task_statuses', $newTaskStatus);
    }

    public function testEdit(): void
    {
        $taskStatus = TaskStatus::factory()->create();
        $user = User::factory()->create();
        /** @var User $user */
        $response = $this->actingAs($user)
            ->get(route('task_statuses.edit', [$taskStatus]));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $taskStatus = TaskStatus::factory()->create();
        $factoryData = $taskStatus->toArray();
        $newTaskStatus = Arr::only($factoryData, ['name', 'description']);
        $user = User::factory()->create();
        /** @var User $user */
        $response = $this->actingAs($user)
            ->patch(route('task_statuses.update', $taskStatus), $newTaskStatus);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseHas('task_statuses', $newTaskStatus);
    }

    public function testDestroy(): void
    {
        $taskStatus = TaskStatus::factory()->create();
        $taskStatusId = $taskStatus['id'];
        $user = User::factory()->create();
        /** @var User $user */
        $response = $this->actingAs($user)
            ->delete(route('task_statuses.destroy', [$taskStatus]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseMissing('task_statuses', ['id' => $taskStatusId]);
    }
}
