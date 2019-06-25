<?php
declare(strict_types=1);

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmailRequest;
use App\Mail\ConfirmEditEmail;
use App\Models\EditEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EditEmailController extends Controller
{
    private $token;

    public function index()
    {
        return view('email.edit_email');
    }

    /**
     * @param  CreateEmailRequest  $request
     * @return \Illuminate\Http\Response
     *
     */
    public function create(CreateEmailRequest $request): RedirectResponse
    {
        $data = new EditEmail;
        // save token and email
        $save = $data->saveEmailAndToken($request->email, $this->setToken(30));

        if ($save) {
            // We send the link with the token to the mail
            $this->sendConfirmation($request->email, $this->token);

            return redirect()->route('edit.email')
                ->with(['success' => trans('edit_email.sent')]);
        } else {
            return back()->withErrors(['msg' => trans('edit_email.verification_error')])
                ->withInput();
        }
    }

    // creates a token
    private function setToken(int $int): string
    {
        return $this->token = Str::random($int);
    }


    protected function sendConfirmation(string $email, string $token): void
    {
        Mail::to($email)->send(new ConfirmEditEmail($token));
    }
}
