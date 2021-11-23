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
        $factoryData = TaskStatus::factory()->make()->toArray();
        /** @var User $user */
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->post(route('task_statuses.store'), $factoryData);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseHas('task_statuses', $factoryData);
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
        $factoryData = $taskStatus->toArray();
        $factoryData = Arr::only($factoryData, ['id', 'name']);
        /** @var User $user */
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->patch(route('task_statuses.update', $taskStatus), $factoryData);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseHas('task_statuses', $factoryData);
    }

    public function testDestroy(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $taskStatus = TaskStatus::factory()->create();
        $taskStatusTest = $taskStatus->toArray();

        $response = $this->actingAs($user)
            ->delete(route('task_statuses.destroy', [$taskStatus]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseMissing('task_statuses', ['id' => $taskStatusTest['id']]);
    }
}
