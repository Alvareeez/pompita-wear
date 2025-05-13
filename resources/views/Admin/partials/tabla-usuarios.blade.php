<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Estado</th> <!-- Nueva columna -->
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->nombre }}</td>
                <td>{{ $usuario->email }}</td>
                <td>{{ $usuario->rol ? $usuario->rol->nombre : 'Sin rol' }}</td>
                <td>
                    @if ($usuario->estado === 'activo')
                        <span class="badge badge-success">Activo</span>
                    @elseif ($usuario->estado === 'inactivo')
                        <span class="badge badge-warning">Inactivo</span>
                    @elseif ($usuario->estado === 'baneado')
                        <span class="badge badge-danger">Baneado</span>
                    @endif
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
        @endforeach
    </tbody>
</table>
