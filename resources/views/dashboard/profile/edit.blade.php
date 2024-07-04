@extends('layouts.dashboard')
@section("page_header","Edit Profile")
@section("page_name")
    @parent
    <li class="breadcrumb-item active">Edit Profile</li>
@endsection
@section('content')
    <x-alert type="success"/>
    <form action="{{ route('dashboard.profile.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-row">
            <div class="col-md-6">
                <x-form.label id="first_name">First Name</x-form.label>
                <x-form.input name="first_name" :value="$user->profile->first_name"/>
            </div>

            <div class="col-md-6">
                <x-form.label id="last_name">Last Name</x-form.label>
                <x-form.input name="last_name" :value="$user->profile->last_name"/>
            </div>

        </div>

        <div class="form-row">
            <div class="col-md-6">
                <x-form.label id="birthday">Birthday</x-form.label>
                <x-form.input type="date" name="birthday" :value="$user->profile->birthday"/>
            </div>

            <div class="col-md-6">
                <x-form.label id="gender">Gender</x-form.label>
                <x-form.radio name="gender" :options="['male'=>'Male','female'=>'Female']"
                              :checked="$user->profile->gender"/>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-4">
                <x-form.label id="street_address">Street Address</x-form.label>
                <x-form.input name="street_address" :value="$user->profile->street_address"/>
            </div>

            <div class="col-md-4">
                <x-form.label id="city">City</x-form.label>
                <x-form.input name="city" :value="$user->profile->country"/>
            </div>

            <div class="col-md-4">
                <x-form.label id="postal_code">Postal Code</x-form.label>
                <x-form.input name="postal_code" :value="$user->profile->postal_code"/>
            </div>

        </div>

        <div class="form-row">
            <div class="col-md-4">
                <x-form.label id="state">State</x-form.label>
                <x-form.input name="state" :value="$user->profile->state"/>
            </div>

            <div class="col-md-4">
                <x-form.label id="country">Country</x-form.label>
                <x-form.select name="country" :options="$countries" :selected="$user->profile->country"/>
            </div>

            <div class="col-md-4">
                <x-form.label id="locale">Locale</x-form.label>
                <x-form.select name="locale" :options="$locales" :selected="$user->profile->locale"/>
            </div>

        </div>

        <input type="submit" class="btn btn-sm btn-primary mt-4 mb-4" value="Update"/>


    </form>

@endsection
