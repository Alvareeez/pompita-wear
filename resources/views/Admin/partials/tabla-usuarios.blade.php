<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->nombre }}</td>
                <td>{{ $usuario->email }}</td>
                <td>{{ $usuario->rol ? $usuario->rol->nombre : 'Sin rol' }}</td>
                <td>
                    <select class="estado-select" data-id="{{ $usuario->id_usuario }}">
                        <option value="activo" {{ $usuario->estado === 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ $usuario->estado === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        <option value="baneado" {{ $usuario->estado === 'baneado' ? 'selected' : '' }}>Baneado</option>
                    </select>
                </td>
                <td>
                    <a href="{{ route('admin.usuarios.edit', $usuario->id_usuario) }}" class="edit-btn">✏️</a>
                    <a class="delete-btn" onclick="confirmDelete({{ $usuario->id_usuario }})">🗑️</a>
                    <form id="delete-form-{{ $usuario->id_usuario }}" action="{{ route('admin.usuarios.destroy', $usuario->id_usuario) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
        @empty
            <tr id="no-results">
                <td colspan="5" style="text-align:center;">No se encontraron resultados.</td>
            </tr>
        @endforelse
    </tbody>
</table>
