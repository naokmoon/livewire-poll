<?php

namespace Tests\Feature;

use App\Livewire\CreatePoll;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CreatePollTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create_poll(): void
    {
        Event::fake();

        $createPoll = new CreatePoll();

        // Validate event dispatched
        // Event::assertDispatched('pollCreated');

        // Validate poll is created
        $createPoll->title = 'Test Poll';
        $createPoll->options = ['Option 1', 'Option 2'];
        $createPoll->createPoll();
        $this->assertDatabaseHas('polls', ['title' => 'Test Poll']);

        // Validate options are created
        $this->assertDatabaseHas('options', ['name' => 'Option 1']);
        $this->assertDatabaseHas('options', ['name' => 'Option 2']);

        // Validate reset
        $this->assertEmpty($createPoll->title);
        // $this->assertCount(0, $createPoll->options);
    }
}
