@extends('layouts.dashboard')
@section("page_header","Roles")
@section("page_name")
    @parent
    <li class="breadcrumb-item active">Roles</li>
@endsection
@section('content')
    <div class="mb-5">
        @can('create','App\Models\Role')
        <a href="{{ route('dashboard.roles.create') }}" class="btn btn-primary mr-2">Create Role</a>
        @endcan
    </div>
    <x-alert type="success"/>
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th colspan="2"></th>

        </tr>
        </thead>
        <tbody>
        @forelse($roles as $role)
            <tr>
                <td></td>
                <td>{{ $role->id }}</td>
                <td><a href="{{ route('dashboard.roles.show',$role->id) }}">
                        {{ $role->name }}
                    </a></td>

                <td>
                    @can('update',$role))
                    <a href="{{ route('dashboard.roles.edit',$role->id) }}"
                       class="btn btn-sm btn-outline-success">Edit</a>
                    @endcan
                </td>
                <td>
                    @can('delete',$role))
                    <form action="{{ route('dashboard.roles.destroy',$role->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                    </form>
                    @endcan
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No roles defined.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    {{ $roles->withQueryString()->links() }}
@endsection
