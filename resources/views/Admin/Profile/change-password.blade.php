@extends('Admin.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Change Password</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('Admin.profile.edit') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="old_password">Old Password</label>
                                            <input type="password" name="current_password" id="old_password"
                                                class="form-control" placeholder="Old Password"
                                                autocomplete="current-password">
                                            <x-input-error :messages="$errors->updatePassword->get('current_password')"
                                                class="mt-2" />
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="new_password">New Password</label>
                                            <input type="password" name="password" id="new_password"
                                                class="form-control" placeholder="New Password"
                                                autocomplete="new-password">
                                            <x-input-error :messages="$errors->updatePassword->get('password')"
                                                class="mt-2" />
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="confirm_password">Confirm Password</label>
                                            <input type="password" name="password_confirmation" id="confirm_password"
                                                class="form-control" placeholder="Confirm Password"
                                                autocomplete="new-password">
                                            <x-input-error
                                                :messages="$errors->updatePassword->get('password_confirmation')"
                                                class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (session('status') === 'password-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition
                            x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">
                            {{ __('Saved.') }}</p>
                        @endif
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </section>
</div>


@endsection