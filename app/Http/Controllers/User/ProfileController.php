<?php
declare(strict_types = 1);

namespace App\Http\Controllers\User;

use App\Http\Requests\ProfileRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * @return View
     */
    public function showEditProfileForm(): View
    {
        return view('user.index');
    }

    /**
     * @param ProfileRequest $request
     *
     * @return RedirectResponse
     */
    public function editPrifile(ProfileRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $user->update(['name' => $request->name, 'surname' => $request->surname])

        return redirect()->back()->with('message', 'User data successfully updated');
    }
}
