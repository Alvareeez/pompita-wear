<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Slug</th>
            <th>Empresa</th>
            <th>Programador</th>
            <th>Enlace</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($plantillas as $plantilla)
            <tr>
                <td>{{ $plantilla->id }}</td>
                <td>{{ $plantilla->nombre }}</td>
                <td>{{ $plantilla->slug }}</td>
                <td>{{ $plantilla->empresa->razon_social ?? 'Sin asignar' }}</td>
                <td>{{ $plantilla->programador->nombre ?? 'Sin asignar' }}</td>
                <td>
                    @if ($plantilla->enlace)
                        <a href="{{ $plantilla->enlace }}" target="_blank" class="btn btn-primary">
                            Ver Página
                        </a>
                    @else
                        <span class="text-muted">No disponible</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.plantillas.edit', $plantilla->id) }}" class="edit-btn">
                        ✏️
                    </a>
                    <a class="delete-btn" onclick="confirmDelete({{ $plantilla->id }})">
                        🗑️
                    </a>
                    <form id="delete-form-{{ $plantilla->id }}" action="{{ route('admin.plantillas.destroy', $plantilla->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align:center;">No se encontraron resultados.</td>
            </tr>
        @endforelse
    </tbody>
</table>