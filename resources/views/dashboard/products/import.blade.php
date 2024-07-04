@extends('layouts.dashboard')
@section("page_header","Import Products")
@section("page_name")
    @parent
    <li class="breadcrumb-item active">Import Products</li>
@endsection
@section('content')
    <form action="{{ route('dashboard.products.import') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div  class="form-group">
            <x-form.label id="name">Number of Products</x-form.label>
            <x-form.input type="text" name="count" class="mb-3" />
            <button type="submit" class="btn btn-secondary">Start Import</button>
        </div>
    </form>

@endsection
