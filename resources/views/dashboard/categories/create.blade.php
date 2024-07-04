@extends('layouts.dashboard')
@section("page_header","Create Category")
@section("page_name")
    @parent
    <li class="breadcrumb-item active">Create Category</li>
@endsection
@section('content')
    <form action="{{ route('dashboard.categories.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('dashboard.categories._form',['button_label'=>'Create'])
    </form>

@endsection
