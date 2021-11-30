<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\User;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testIndex(): void
    {
        $response = $this->get(route('labels.index'));
        $response->assertOk();
    }

    public function testCreate(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->get(route('labels.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $label = Label::factory()->make()->toArray();
        /** @var User $user */
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->post(route('labels.store'), $label);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseHas('labels', $label);
    }

    public function testEdit(): void
    {
        $label = Label::factory()->create();
        /** @var User $user */
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->get(route('labels.edit', [$label]));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $label = Label::factory()->create();
        $newLabel = $label->only(['name', 'description']);
        /** @var User $user */
        $user = User::factory()->create();
        $response = $this->actingAs($user)
            ->patch(route('labels.update', $label), $newLabel);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseHas('labels', $newLabel);
    }

    public function testDestroy(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $factoryLabel = Label::factory()->create();
        $label = $factoryLabel->toArray();

        $response = $this->actingAs($user)
            ->delete(route('labels.destroy', [$factoryLabel]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseMissing('labels', ['id' => $label['id']]);
    }
}
