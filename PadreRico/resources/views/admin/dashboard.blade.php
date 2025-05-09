@extends('layouts.app')
@section('content')
    <div class="container mb-4 text-black">
        <h1 class="text-center">ADMIN</h1>
        <div class="d-flex justify-content-center">
            <table class="table table-bordered w-75">
                <thead class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role == 1 ? 'Usuario' : 'Admin' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
