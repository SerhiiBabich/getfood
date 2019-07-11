<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Http\Controllers\Email\EditEmailController;
use App\Mail\ConfirmEditEmail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tests\TestCase;

class EditEmailControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        Mail::fake();
        $this->user = factory(User::class)->create();
    }

    public function testCreate()
    {
        $user     = $this->user;
        $email    = Str::random(5).'@gmail.com';
        $response = $this->actingAs($this->user)->post('/profile/edit/email', ['email' => $email]);
        // After successfully saving the redirect
        $response->assertRedirect('/profile/edit/email');
        // there is a successful save in session
        $response->assertSessionHas('success', __('edit_email.sent'));
        // and a record appeared in the database
        $this->assertDatabaseHas('edit_email', ['email' => $email]);


        $response = $this->actingAs($this->user)->post('/profile/edit/email', ['email' => $this->user->email]);
        // The email unicity check works and displays an error.
        $response->assertSessionHasErrors('email');

        // Record should not be added to the database
        $this->assertDatabaseMissing('edit_email', ['email' => $this->user->email]);
        Mail::assertNotQueued(ConfirmEditEmail::class, function ($mail) use ($user)
        {
            return $mail->hasTo($user->email);
        });

    }

    public function testSendConfirmation()
    {
        $user  = $this->user;
        $send  = new EditEmailController();
        $token = $send->setToken(30);
        $send->sendConfirmation($user->email, $token);
        Mail::assertQueued(ConfirmEditEmail::class, function ($mail) use ($user)
        {
            return $mail->hasTo($user->email);
        });
    }
}
