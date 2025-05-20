@forelse ($etiquetas as $etiqueta)
    @php
        // ¿Esta etiqueta es la única de alguna prenda?
        $esUnica = \DB::table('prenda_etiquetas')
            ->where('id_etiqueta', $etiqueta->id_etiqueta)
            ->pluck('id_prenda')
            ->filter(function($prendaId) {
                return \DB::table('prenda_etiquetas')->where('id_prenda', $prendaId)->count() === 1;
            })->isNotEmpty();
    @endphp
    <tr>
        <td>{{ $etiqueta->id_etiqueta }}</td>
        <td>{{ $etiqueta->nombre }}</td>
        <td>
            <a href="{{ route('admin.etiquetas.edit', $etiqueta->id_etiqueta) }}" class="edit-btn">✏️</a>
            <a class="delete-btn" onclick="confirmDelete({{ $etiqueta->id_etiqueta }}, {{ $esUnica ? 'true' : 'false' }})">🗑️</a>
            <form id="delete-form-{{ $etiqueta->id_etiqueta }}" action="{{ route('admin.etiquetas.destroy', $etiqueta->id_etiqueta) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </td>
    </tr>
@empty
    <tr id="no-results">
        <td colspan="3" style="text-align:center;">No se encontraron resultados.</td>
    </tr>
@endforelse
