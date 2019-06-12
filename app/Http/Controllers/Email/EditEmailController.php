<?php
declare(strict_types=1);

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditEmailRequest;
use App\Models\EditEmail;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmEditEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class EditEmailController extends Controller
{
    public function index()
    {
        return view('email.edit_email');
    }

    /**
     * @param EditEmailRequest $request
     * @return \Illuminate\Http\Response
     *
     */
    public function edit(EditEmailRequest $request): RedirectResponse
    {
        $data = new EditEmail;
        $data->email = $request->email;
        $data->token = $this->setToken(30);

        // save token and email
        $save = $data->save();

        if($save){
            // We send the link with the token to the mail
            Mail::to($data->email)->send(new ConfirmEditEmail($data->token));
            return redirect()->route('edit.email')
                ->with(['success' => 'На вашу почту отправленно подтверджение']);
        }
        else{
            return back()->withErrors(['msg' => 'Ошибка подтверджения'])
                ->withInput();
        }
    }

    // creates a token
    private function setToken($int): string
    {
        return Str::random($int);
    }
}
