@foreach ($etiquetas as $etiqueta)
    <tr>
        <td>{{ $etiqueta->id_etiqueta }}</td>
        <td>{{ $etiqueta->nombre }}</td>
        <td>
            <a href="{{ route('admin.etiquetas.edit', $etiqueta->id_etiqueta) }}" class="edit-btn">✏️</a>
            <a class="delete-btn" onclick="confirmDelete({{ $etiqueta->id_etiqueta }})">🗑️</a>
            <form id="delete-form-{{ $etiqueta->id_etiqueta }}" action="{{ route('admin.etiquetas.destroy', $etiqueta->id_etiqueta) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </td>
    </tr>
@endforeach
