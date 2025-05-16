@foreach ($estilos as $estilo)
    @php
        // ¿Este estilo es el único de alguna prenda?
        $esUnico = \DB::table('prenda_estilos')
            ->where('id_estilo', $estilo->id_estilo)
            ->pluck('id_prenda')
            ->filter(function($prendaId) {
                return \DB::table('prenda_estilos')->where('id_prenda', $prendaId)->count() === 1;
            })->isNotEmpty();
    @endphp
    <tr>
        <td>{{ $estilo->id_estilo }}</td>
        <td>{{ $estilo->nombre }}</td>
        <td>
            <a href="{{ route('admin.estilos.edit', $estilo->id_estilo) }}" class="edit-btn">✏️</a>
            <a class="delete-btn" onclick="confirmDelete({{ $estilo->id_estilo }}, {{ $esUnico ? 'true' : 'false' }})">🗑️</a>
            <form id="delete-form-{{ $estilo->id_estilo }}" action="{{ route('admin.estilos.destroy', $estilo->id_estilo) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </td>
    </tr>
@endforeach
