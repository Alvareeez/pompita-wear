@foreach($colores as $color)
<tr>
    <td>{{ $color->id_color }}</td>
    <td>{{ $color->nombre }}</td>
    <td>
        <a href="{{ route('admin.colores.edit', $color->id_color) }}" class="edit-btn">✏️</a>
        <a class="delete-btn" onclick="confirmDelete({{ $color->id_color }})">🗑️</a>
        <form id="delete-form-{{ $color->id_color }}" action="{{ route('admin.colores.destroy', $color->id_color) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </td>
</tr>
@endforeach