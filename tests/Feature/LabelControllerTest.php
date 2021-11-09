<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Arr;

class LabelControllerTest extends TestCase
{
    public User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
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
        $newLabel = Arr::only($factoryData, ['name', 'description']);

        $response = $this->actingAs($this->user)
            ->post(route('labels.store'), $newLabel);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseHas('labels', $newLabel);
    }

    public function testEdit(): void
    {
        $label = Label::factory()->create();
        $response = $this->actingAs($this->user)
            ->get(route('labels.edit', [$label]));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $label = Label::factory()->create();
        $factoryData = $label->toArray();
        $newLabel = Arr::only($factoryData, ['name', 'description']);
        $response = $this->actingAs($this->user)
            ->patch(route('labels.update', $label), $newLabel);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseHas('labels', $newLabel);
    }

    public function testDestroy(): void
    {
        $label = Label::factory()->create();
        if (isset($label['id'])) {
            $labelId = $label['id'];
        }
        $response = $this->actingAs($this->user)
            ->delete(route('labels.destroy', [$label]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));
        /** @var TYPE_NAME $labelId */
        $this->assertDatabaseMissing('labels', ['id' => $labelId]);
    }
}
