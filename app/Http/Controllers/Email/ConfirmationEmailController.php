<?php
declare(strict_types=1);

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Models\EditEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

/**
 * @mixin Carbon
 */
class ConfirmationEmailController extends Controller
{
    /** @var EditEmail $EditEmail */
    private $EditEmail;

    public function confirm(string $token): RedirectResponse
    {
        $this->EditEmail = EditEmail::whereToken($token);
        // Check if the token is valid
        if ($isValidToken = $this->isTokenValid($this->EditEmail->used_token, $this->EditEmail->token_created_at)) {
            return $isValidToken;
        }

        // Update user email and time confirmation
        if ($this->confirmEmail($this->EditEmail->email)) {
            //use a token to not reuse
            $this->EditEmail->usedToken();
            return redirect()->route('home')
                ->with(['status' => trans('edit_email.mail_verified')]);
        } else {
            return redirect()->route('edit.email')
                ->withErrors(['msg' => trans('edit_email.verification_error')]);
        }
    }

    /** Check if the token is valid
     * @param  int  $used_token
     * @param  Carbon|null  $token_created_at
     * @return bool|RedirectResponse
     */
    public function isTokenValid(int $used_token, Carbon $token_created_at = null)
    {
        if ($used_token == 1 || $used_token == 2) {
            //redirect depending on token usage
            return $this->isUsedToken($used_token);
        }// check if the token expired
        elseif ($this->timeToken($token_created_at)) {
            //set the token in the time of the token has expired and redirect to the email editing page
            $this->EditEmail->usedToken(2);
            return $this->isUsedToken($this->EditEmail->used_token);
        }
        return false;
    }

    /** Сhecks token usage
     * @param  int  used_token
     * @return RedirectResponse
     */
    protected function isUsedToken(int $used_token): RedirectResponse
    {
        $message = '';
        //already used a token
        if ((int)$used_token == 1) {
            $message = __('edit_email.link_used');
        } // the time of the token has expired
        elseif ((int)$used_token == 2) {
            $message = __('edit_email.time_token');
        }
        return redirect()->route('edit.email')->withErrors(['msg' => $message]);
    }

    /** Сhecks the time of the token
     * @param  Carbon|string  $time
     * @return bool
     */
    public function timeToken($time): bool
    {
        if (empty($time)) {
            return false;
        }
        if ($time instanceof Carbon) {
            return $time->addMinutes(Config::get('app.time_token'))->lt(Carbon::now());
        } else {
            return Carbon::parse($time)->addMinutes(Config::get('app.time_token'))->lt(Carbon::now());
        }
    }

    /** Updates user email and confirmation time
     * @param  string  $email
     * @param  User  $user
     * @return bool
     */
    public function confirmEmail(string $email, User $user = null): bool
    {
        /** @var User $user */
        if (empty($user)) {
            $user = Auth::user();
        }

        return $user->emailConfirm($email);
    }
}
