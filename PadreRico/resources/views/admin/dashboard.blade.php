@extends('layouts.app')
@section('content')
    <div class="container mb-4 text-black">
        <h1 class="text-center mb-4">Panel de Administración</h1>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Usuarios registrados: {{ $users->count() }}</h4>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createUserModal">Crear usuario</button>
        </div>

        {{-- Modal Crear Usuario --}}
        <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content shadow-lg rounded-4 border-0 bg-white" method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUserModalLabel">Crear Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nombre</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Contraseña</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Rol</label>
                            <select name="role" class="form-select" required>
                                <option value="1">Usuario</option>
                                <option value="2">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Crear</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <caption>Lista de usuarios</caption>
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->role == 1)
                                    Usuario
                                @elseif($user->role == 2)
                                    Admin
                                @else
                                    Desconocido
                                @endif
                            </td>
                            <td>
                                <!-- Botón Editar -->
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editUserModal{{ $user->id }}">Editar</button>
                                <!-- Botón Eliminar -->
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar a {{ $user->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- Agrega los enlaces de paginación aquí --}}
            <div class="d-flex justify-content-center">
                {{ $users->links() }}
            </div>
        </div>

        {{-- Modales de editar usuario --}}
        @foreach ($users as $user)
            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
                aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <form class="modal-content shadow-lg rounded-4 border-0 bg-white" method="POST" action="{{ route('users.update', $user->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">Editar Usuario
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Nombre</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ $user->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ $user->email }}" required>
                            </div>
                            <div class="mb-3">
                                <label>Rol</label>
                                <select name="role" class="form-select" required>
                                    <option value="1" @if ($user->role == 1) selected @endif>
                                        Usuario</option>
                                    <option value="2" @if ($user->role == 2) selected @endif>
                                        Admin</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Nueva contraseña (opcional)</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-warning">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection

