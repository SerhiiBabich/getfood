<?php
declare(strict_types=1);

namespace App\Http\Controllers\Email;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EditEmailController extends Controller
{
    public function index()
    {
        return view('email.edit_email');
    }

    public function edit()
    {
        //
    }
}
