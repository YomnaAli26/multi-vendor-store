@extends('layouts.dashboard')
@section("page_header","Edit User")
@section("page_name")
    @parent
    <li class="breadcrumb-item active">Edit User</li>
@endsection
@section('content')
    <form action="{{ route('dashboard.users.update',$user->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        @include('dashboard.users._form',['button_label'=>'Update'])
    </form>

@endsection
