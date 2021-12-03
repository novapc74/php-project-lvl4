<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testIndex(): void
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertOk();
    }

    public function testCreate(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->get(route('task_statuses.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $taskStatus = TaskStatus::factory()->make()->toArray();
        /** @var User $user */
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->post(route('task_statuses.store'), $taskStatus);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseHas('task_statuses', $taskStatus);
    }

    public function testEdit(): void
    {
        $taskStatus = TaskStatus::factory()->create();
        /** @var User $user */
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->get(route('task_statuses.edit', [$taskStatus]));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $taskStatus = TaskStatus::factory()->create();
        $newTaskStatus = $taskStatus->only(['id', 'name']);
        /** @var User $user */
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->patch(route('task_statuses.update', $taskStatus), $newTaskStatus);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseHas('task_statuses', $newTaskStatus);
    }

    public function testDestroy(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $taskStatus = TaskStatus::factory()->create();

        $response = $this->actingAs($user)
            ->delete(route('task_statuses.destroy', [$taskStatus]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseMissing('task_statuses', ['id' => $taskStatus['id']]);
    }
}
