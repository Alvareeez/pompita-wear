@foreach($colores as $color)
    @php
        // ¿Este color es el único de alguna prenda?
        $esUnico = \DB::table('prenda_colores')
            ->where('id_color', $color->id_color)
            ->pluck('id_prenda')
            ->filter(function($prendaId) {
                return \DB::table('prenda_colores')->where('id_prenda', $prendaId)->count() === 1;
            })->isNotEmpty();
    @endphp
<tr>
    <td>{{ $color->id_color }}</td>
    <td>{{ $color->nombre }}</td>
    <td>
        <a href="{{ route('admin.colores.edit', $color->id_color) }}" class="edit-btn">✏️</a>
        <a class="delete-btn" onclick="confirmDelete({{ $color->id_color }}, {{ $esUnico ? 'true' : 'false' }})">🗑️</a>
        <form id="delete-form-{{ $color->id_color }}" action="{{ route('admin.colores.destroy', $color->id_color) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </td>
</tr>
@endforeach