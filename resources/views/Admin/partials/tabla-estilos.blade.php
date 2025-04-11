@foreach ($estilos as $estilo)
    <tr>
        <td>{{ $estilo->id_estilo }}</td>
        <td>{{ $estilo->nombre }}</td>
        <td>
            <a href="{{ route('admin.estilos.edit', $estilo->id_estilo) }}" class="edit-btn">✏️</a>
            <a class="delete-btn" onclick="confirmDelete({{ $estilo->id_estilo }})">🗑️</a>
            <form id="delete-form-{{ $estilo->id_estilo }}" action="{{ route('admin.estilos.destroy', $estilo->id_estilo) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </td>
    </tr>
@endforeach
