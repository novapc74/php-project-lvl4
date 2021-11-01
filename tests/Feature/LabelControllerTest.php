<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\User;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    public User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Label::factory()->create();
        // $this->label = Label::factory()->create();
    }

    public function testIndex(): void
    {
        $response = $this->get(route('labels.index'));
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->get(route('labels.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $factoryData = Label::factory()->make()->toArray();
        $newLabel = \Arr::only($factoryData, ['name', 'description']);

        $response = $this->actingAs($this->user)
            ->post(route('labels.store'), $newLabel);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseHas('labels', $newLabel);
    }

    public function testEdit(): void
    {
        $response = $this->get(route('labels.edit', [Label::first()]));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $label = Label::first();
        $newLabel = \Arr::only($label->toArray(), ['name', 'body']);
        $response = $this->actingAs($this->user)
            ->patch(route('labels.update', $label), $newLabel);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseHas('labels', $newLabel);
    }

    public function testDestroy(): void
    {
        $label = Label::first();
        $response = $this->actingAs($this->user)
            ->delete(route('labels.destroy', [$label]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseMissing('labels', ['id' => $label->id]);
    }
}
