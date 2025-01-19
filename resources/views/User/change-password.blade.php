@extends('User.master')
@section('content')
<section class="section-11">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0 pt-2 pb-2 password-heading">Change Password</h2>
                    </div>
                    <div class="card-body p-4">
                        <form method="post" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')

                            <div class="row">
                                <div class="mb-3">
                                    <label class="password-label" for="old_password">Old Password</label>
                                    <input type="password" name="current_password" id="old_password"
                                        placeholder="Old Password" class="form-control password-input"
                                        autocomplete="current-password">
                                    <x-input-error :messages="$errors->updatePassword->get('current_password')"
                                        class="mt-2" />
                                </div>

                                <div class="mb-3">
                                    <label class="password-label" for="new_password">New Password</label>
                                    <input type="password" name="password" id="new_password" placeholder="New Password"
                                        class="form-control password-input" autocomplete="new-password">
                                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                                </div>

                                <div class="mb-3">
                                    <label class="password-label" for="confirm_password">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="confirm_password"
                                        placeholder="Confirm Password" class="form-control password-input"
                                        autocomplete="new-password">
                                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')"
                                        class="mt-2" />
                                </div>

                                <div class="d-flex password-button-container">
                                    <button type="submit" class="btn password-button">Save</button>
                                    <a href="{{ route('profile.edit') }}" class="btn password-button">Back</a>
                                </div>

                                @if (session('status') === 'password-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition
                                    x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">
                                    {{ __('Saved.') }}
                                </p>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection