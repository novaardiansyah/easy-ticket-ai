<?php

use App\Mail\RegisterLinkMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

test('registration email is queued and session cooldown is set', function () {
    Mail::fake();

    $response = $this->post('/register', [
        'email' => 'newuser@example.com',
    ]);

    $response->assertRedirect(route('register.success'));

    $this->assertDatabaseHas('users', [
        'email' => 'newuser@example.com',
    ]);

    Mail::assertQueued(RegisterLinkMail::class, function ($mail) {
        return $mail->email === 'newuser@example.com';
    });

    $this->assertTrue(session()->has('registration_cooldown'));
    $this->assertGreaterThan(now()->timestamp, session()->get('registration_cooldown'));
});

test('subsequent registration attempt within cooldown is blocked', function () {
    Mail::fake();

    $this->post('/register', [
        'email' => 'first@example.com',
    ]);

    Mail::assertQueued(RegisterLinkMail::class);
    Mail::fake();

    $response = $this->post('/register', [
        'email' => 'second@example.com',
    ]);

    $response->assertSessionHasErrors(['email']);

    $this->assertDatabaseMissing('users', [
        'email' => 'second@example.com',
    ]);

    Mail::assertNotQueued(RegisterLinkMail::class);
});
