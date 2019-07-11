<?php

namespace Tests\Feature;

use App\Http\Controllers\Email\ConfirmationEmailController;
use App\Models\EditEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Tests\TestCase;


class ConfirmationEmailControllerTest extends TestCase
{
    use RefreshDatabase;
    /** @var User $user */
    protected $user;
    /** @var ConfirmationEmailController $ConfirmationEmailController */
    protected $ConfirmationEmailController;
    protected $token;
    /** @var EditEmail $EditEmail */
    private $EditEmail;

    public function setUp(): void
    {
        parent::setUp();
        $this->user                        = factory(User::class)->create();
        $this->ConfirmationEmailController = new ConfirmationEmailController();
    }

    public function testConfirm()
    {
        $EditEmail = new EditEmail;
        $email     = Str::random(5).'@gmail.com';
        $token     = Str::random(30);
        $this->assertTrue($EditEmail->saveEmailAndToken($email, $token));
        // check on token usage
        $response = $this->actingAs($this->user)->get('/email/confirmation/'.$token);
        // if the token is the correct redirect to the home page
        $response->assertRedirect('home');
        // also in the session is that the mail has been successfully confirmed
        $response->assertSessionHas('status', trans('edit_email.mail_verified'));
        // in DB 'used_token' = 1
        $this->assertDatabaseHas('edit_email',
            [
                'token'      => $token,
                'email'      => $email,
                'used_token' => 1,
            ]);
        $this->assertDatabaseHas('users',
            [
                'name'  => $this->user->name,
                'email' => $email,
            ]);


        $EditEmail = EditEmail::whereToken($token);
        //'used_token' = 1 the token is already used, should display an error
        $response = $this->actingAs($this->user)->get('/email/confirmation/'.$token);
        $response->assertRedirect('profile/edit/email');
        $response->assertSessionHasErrors('msg', __('edit_email.link_used'));

        // change 'used_token' = 0 to check for a timeout error
        $EditEmail->usedToken(0);
        $EditEmail->token_created_at = Carbon::now()->addMinute(-Config::get('app.time_token') - 10);
        $this->assertTrue($EditEmail->save());
        // check whether everything has changed correctly
        $this->assertDatabaseHas('edit_email',
            [
                'token'            => $token,
                'email'            => $email,
                'used_token'       => 0,
                'token_created_at' => $EditEmail->token_created_at,
            ]);
        // the token has expired, should display an error
        $response = $this->actingAs($this->user)->get('/email/confirmation/'.$token);
        $response->assertRedirect('/profile/edit/email');
        $response->assertSessionHasErrors('msg', __('edit_email.time_token'));

        // used_token = 2 means the token has expired, should display an error
        $response = $this->actingAs($this->user)->get('/email/confirmation/'.$token);
        $response->assertRedirect('profile/edit/email');
        $response->assertSessionHasErrors('msg', __('edit_email.time_token'));
    }

    public function testisTokenValid()
    {
        $EditEmail = new EditEmail;
        $email     = Str::random(5).'@gmail.com';
        $token     = Str::random(30);
        $this->assertTrue($EditEmail->saveEmailAndToken($email, $token));
        $this->EditEmail = EditEmail::whereToken($token);
        $this->assertFalse($this->ConfirmationEmailController->isTokenValid(4));
        $this->assertFalse($this->ConfirmationEmailController->isTokenValid(0));
        $this->assertFalse($this->ConfirmationEmailController->isTokenValid(3));

        $this->assertNotFalse($this->ConfirmationEmailController->isTokenValid(1));
        $this->assertNotFalse($this->ConfirmationEmailController->isTokenValid(2));
        $this->assertFalse($this->ConfirmationEmailController->isTokenValid(0, Carbon::now()));
    }

    public function testTimeToken()
    {
        $time = Carbon::now();
        $this->assertFalse($this->ConfirmationEmailController->timeToken(null));
        $this->assertFalse($this->ConfirmationEmailController->timeToken(''));
        $this->assertTrue($this->ConfirmationEmailController->timeToken($time->addMinute(-Config::get('app.time_token') -
                                                                                         10)));
        $this->assertFalse($this->ConfirmationEmailController->timeToken($time));
    }
}
