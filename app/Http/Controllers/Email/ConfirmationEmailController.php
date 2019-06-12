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
        $email = EditEmail::where('token', $token)->first();
        //check if there is such a token
        if($email === null)
        {
            abort(404);
        }
        //update email
        $user = $request->user();
        $user->email = $email->email;
        $user->email_verified_at = time();
        $save = $user->save();

        if($save)
        {
            return redirect()->route('home')
                ->with(['status' => 'Почта успешно подтверджена']);
        }
        else{
            return redirect()->route('edit.email')->withErrors(['msg' => 'Ошибка подтверджения']);
        }
    }
}
