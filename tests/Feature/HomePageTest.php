<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{

    public function testHome(): void
    {
        $response = $this->get(route('home'));
        $response->assertOk();
    }
}
