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
        $this->user = User::factory()->create();
        $this->label = Label::factory()->create();
    }

    public function testIndex(): void
    {
        $response = $this->get(route('labels.index'));
        $response->assertOk();
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('labels.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $factoryData = Label::factory()->make()->toArray();
        $newLabel = \Arr::only($factoryData, ['name', 'description']);

        $response = $this->actingAs($this->user)
            ->post(route('labels.store'), $newLabel);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('labels', $newLabel);
    }

    public function testEdit(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('labels.edit', [$this->label]));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $newLabel = \Arr::only($this->label->toArray(), ['name', 'body']);
        $response = $this->actingAs($this->user)
            ->patch(route('labels.update', $this->label), $newLabel);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('labels', $newLabel);
    }

    public function testDestroy(): void
    {
        $response = $this->actingAs($this->user)
            ->delete(route('labels.destroy', [$this->label]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseMissing('labels', ['id' => $this->label->id]);
    }
}
