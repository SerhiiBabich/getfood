<?php
declare(strict_types = 1);

namespace App\Http\Controllers\User;

use App\Constants\Messages;
use App\Http\Requests\PasswordRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Repositories\UserRepository;

class changePasswordController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function show(): View
    {
        return view('user.password');
    }

    /**
     * @param \App\Http\Requests\PasswordRequest
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(PasswordRequest $request): RedirectResponse
    {
        if (UserRepository::checkPassword($request->current_password)) {
            $userRepository = UserRepository::currentUser();
            $userRepository->update([
                'password' => $request->new_password,
            ]);
            return redirect()->back()->with(Messages::MESSAGE, trans('message.profile'));
        }

        return redirect()->back()->with(Messages::ALERT, trans('message.password'));

    }
}
