@extends('layouts.app')

@section('content')

    <div class="container">
        @include('email.includes.result_messages')

        <form method="POST" action="{{ route('edit.email') }}">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input name="email" value="{{ old('email') }}"
                                   id="email"
                                   type="email"
                                   class="form-control"
                                   required>
                        </div>
                    <button type="submit" class="btn btn-primary">{{ __('edit_email.submit') }}</button>
                </div>
            </div>
        </form>
    </div>
@stop
