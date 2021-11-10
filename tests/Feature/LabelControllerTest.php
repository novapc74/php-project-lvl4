<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Arr;

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
        $user = User::factory()->create();
        /** @var User $user */
        $response = $this->actingAs($user)
            ->get(route('labels.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $factoryData = Label::factory()->make()->toArray();
        $newLabel = Arr::only($factoryData, ['name', 'description']);
        $user = User::factory()->create();
        /** @var User $user */
        $response = $this->actingAs($user)
            ->post(route('labels.store'), $newLabel);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseHas('labels', $newLabel);
    }

    public function testEdit(): void
    {
        $label = Label::factory()->create();
        $user = User::factory()->create();
        /** @var User $user */
        $response = $this->actingAs($user)
            ->get(route('labels.edit', [$label]));
        $response->assertOk();
    }

    public function testUpdate(): void
    {
        $label = Label::factory()->create();
        $factoryData = $label->toArray();
        $newLabel = Arr::only($factoryData, ['name', 'description']);
        $user = User::factory()->create();
        /** @var User $user */
        $response = $this->actingAs($user)
            ->patch(route('labels.update', $label), $newLabel);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseHas('labels', $newLabel);
    }

    public function testDestroy(): void
    {
        $user = User::factory()->create();
        $label = Label::factory()->create();
        $testLabel = $label->toArray();

        /** @var User $user */
        $response = $this->actingAs($user)
            ->delete(route('labels.destroy', [$label]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseMissing('labels', ['id' => $testLabel['id']]);
    }
}
