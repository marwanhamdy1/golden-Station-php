<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_switches_language_to_arabic()
    {
        // ضبط اللغة في config مباشرة
        config(['app.locale' => 'ar']);
        $dashboard = $this->get('/dashboard');
        $dashboard->assertSee('لوحة التحكم'); // من ملف resources/lang/ar/dashboard.php
        $dashboard->assertSee('Current locale: ar'); // من resources/views/dashboard.blade.php
    }
}
