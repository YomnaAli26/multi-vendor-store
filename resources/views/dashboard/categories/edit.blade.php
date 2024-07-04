@extends('layouts.dashboard')
@section("page_header","Edit Category")
@section("page_name")
    @parent
    <li class="breadcrumb-item active">Edit Category</li>
@endsection
@section('content')
    <form action="{{ route('dashboard.categories.update',$category->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('dashboard.categories._form',['button_label'=>'Update'])
    </form>

@endsection
