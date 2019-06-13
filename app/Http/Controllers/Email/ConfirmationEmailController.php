<?php
declare(strict_types=1);

namespace App\Http\Controllers\Email;

use App\Models\EditEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfirmationEmailController extends Controller
{
    public function confirm(Request $request, $token): RedirectResponse
    {
        $EditEmail = EditEmail::where('token', $token)->first();
        //check if there is such a token
        if($EditEmail === null)
        {
            abort(404);
        }
        if($EditEmail->used_token == 1)
        {
            return redirect()->route('edit.email')->withErrors(['msg' => trans('edit_email.link_used')]);
        }
        
        //update email
        $user = $request->user();
        $saveUser = $user->emailConfirm($EditEmail->email);

        if($saveUser)
        {
            //use token to not reuse
            $EditEmail->usedToken();
            return redirect()->route('home')
                ->with(['status' => trans('edit_email.mail_verified')]);
        }
        else{
            return redirect()->route('edit.email')->withErrors(['msg' => trans('edit_email.verification_error')]);
        }
    }
}
