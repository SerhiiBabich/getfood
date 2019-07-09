<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class EditEmailControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $user     = factory(User::class)->create();
        $response = $this->actingAs($user)->post('/profile/edit/email', ['email' => 'mukola787898@gmail.com']);
        $response->assertRedirect('/profile/edit/email');
        $response->assertSessionHas('success', __('edit_email.sent'));

        $response = $this->actingAs($user)->post('/profile/edit/email', ['email' => $user->email]);
        $response->assertSessionHasErrors('email');

    }
}
