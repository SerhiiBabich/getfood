@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input
                                    id="password"
                                    type="password"
                                    class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    name="password"
                                    required
                                    data-bind="on.blur: passwordCompare, textInput: password.original"
                                >

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">Password generator</div>
                <div class="card-body">
                    <div class="card-header-tabs col-md-12">
                        <h3 class="d-flex">{{ $password }}</h3>
                    </div>
                    <form method="POST" action="{{ route('password-generator') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Password Lenth</label>

                            <div class="col-md-2">
                                <input id="password_length" type="text" class="form-control" name="password_length" value="{{
                                $passwordLength ? $passwordLength : 6
                                }}">

                                @if ($errors->has('password_length'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password_length') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" id="capital" name="uppercase" checked>
                                <label class="form-check-label" for="materialInline1">A-Z</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" id="letters" name="lowercase" checked>
                                <label class="form-check-label" for="materialInline2">a-z</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" id="numbers" name="numbers" checked>
                                <label class="form-check-label" for="materialInline3">0-9</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" id="special" name="symbols" checked>
                                <label class="form-check-label" for="materialInline3">#$*@!</label>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn badge-dark">
                                    {{ __('Generate') }}
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
