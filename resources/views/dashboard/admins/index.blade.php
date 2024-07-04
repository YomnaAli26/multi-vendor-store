@extends('layouts.dashboard')
@section("page_header","Admins")
@section("page_name")
    @parent
    <li class="breadcrumb-item active">Admins</li>
@endsection
@section('content')
    <div class="mb-5">
        @can('create','App\Models\Admin')
        <a href="{{ route('dashboard.admins.create') }}" class="btn btn-primary mr-2">Create Admin</a>
        @endcan
    </div>
    <x-alert type="success"/>
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Roles</th>
            <th colspan="2"></th>

        </tr>
        </thead>
        <tbody>
        @forelse($admins as $admin)
            <tr>
                <td></td>
                <td>{{ $admin->id }}</td>
                <td>
                    <a href="{{ route('dashboard.admins.show',$admin->id) }}">
                        {{ $admin->name }}
                    </a>
                </td>
                <td>
                    {{$admin->email}}
                </td>

                <td>{{implode('-',$admin->roles()->pluck('name')->toArray())}}</td>

                <td>
                    @can('update',$admin)
                        <a href="{{ route('dashboard.admins.edit',$admin->id) }}"
                        class="btn btn-sm btn-outline-success">Edit</a>
                    @endcan
                </td>
                <td>
                    @can('delete',$admin)
                        <form action="{{ route('dashboard.admins.destroy',$admin->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                         </form>
                    @endcan
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No admins defined.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    {{ $admins->withQueryString()->links() }}
@endsection
