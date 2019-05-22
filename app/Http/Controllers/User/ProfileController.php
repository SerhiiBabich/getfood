<?php
declare(strict_types = 1);

namespace App\Http\Controllers\User;

use App\Constants\Messages;
use App\Http\Requests\ProfileRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Repositories\UserRepository;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function show(): View
    {
        return view('user.index');
    }

    /**
     * @param \App\Http\Requests\ProfileRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(ProfileRequest $request): RedirectResponse
    {
        $userRepository = UserRepository::currentUser();
        $userRepository->update([
            'name' => $request->name,
            'surname' => $request->surname
        ]);

        return redirect()->back()->with(Messages::MESSAGE, trans('message.profile'));
    }
}
