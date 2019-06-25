<?php
declare(strict_types=1);

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Models\EditEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ConfirmationEmailController extends Controller
{
    public function confirm(string $token): RedirectResponse
    {
        /** @var EditEmail $EditEmail */
        /** @var User $user */
        $EditEmail = EditEmail::where('token', $token)->first();
        //check if there is such a token
        if ($EditEmail === null) {
            abort(404);
        }
        // Check if the token is valid
        if ($EditEmail->used_token == 1 || $EditEmail->used_token == 2) {
            //redirect depending on token usage
            return $this->checksToken($EditEmail->used_token);
        } // check if the token expired
        elseif ($this->timeToken($EditEmail->token_created_at)) {
            //set the token in the time of the token has expired and redirect to the email editing page
            $EditEmail->usedToken(2);
            return $this->checksToken($EditEmail->used_token);
        }

        //update email
        $user     = Auth::user();
        $saveUser = $user->emailConfirm($EditEmail->email);

        if ($saveUser) {
            //use a token to not reuse
            $EditEmail->usedToken();
            return redirect()->route('home')
                ->with(['status' => trans('edit_email.mail_verified')]);
        } else {
            return redirect()->route('edit.email')->withErrors(['msg' => trans('edit_email.verification_error')]);
        }
    }

    //Check the duration of the token

    private function checksToken(int $int): RedirectResponse
    {
        //already used a token
        if ($int == 1) {
            return redirect()->route('edit.email')->withErrors(['msg' => trans('edit_email.link_used')]);
        } // the time of the token has expired
        elseif ($int == 2) {

            return redirect()->route('edit.email')->withErrors(['msg' => trans('edit_email.time_token')]);
        }
    }


    // redirect depending on token usage

    private function timeToken($time): bool
    {
        return $time->addMinutes(config('app.time_token'))->lt(Carbon::now());
    }
}
