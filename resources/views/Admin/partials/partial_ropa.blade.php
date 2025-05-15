<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Descripción</th>
                <th>Etiquetas</th>
                <th>Colores</th>
                <th>Estilos</th>
                <th>Imágenes</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="prendas-table">
            @foreach ($prendas as $prenda)
                <tr>
                    <td>{{ $prenda->id_prenda }}</td>
                    <td>{{ $prenda->nombre }}</td>
                    <td>{{ $prenda->tipo->tipo }}</td>
                    <td>{{ $prenda->descripcion }}</td>
                    <td>
                        @foreach ($prenda->etiquetas as $etiqueta)
                            <span class="badge">{{ $etiqueta->nombre }}</span>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($prenda->colores as $color)
                            <span class="badge" style="background-color: {{ $color->hex }}; color: #fff;">{{ $color->nombre }}</span>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($prenda->estilos as $estilo)
                            <span class="badge">{{ $estilo->nombre }}</span>
                        @endforeach
                    </td>
                    <td>
                        <div class="image-container">
                            <img src="{{ asset('img/prendas/' . $prenda->img_frontal) }}" alt="Frontal de {{ $prenda->nombre }}" class="image-preview">
                            <img src="{{ asset('img/prendas/' . $prenda->img_trasera) }}" alt="Trasera de {{ $prenda->nombre }}" class="image-preview">
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('admin.ropa.edit', $prenda->id_prenda) }}" class="edit-btn">✏️</a>
                        <a class="delete-btn" onclick="confirmDelete({{ $prenda->id_prenda }})">🗑️</a>
                        <form id="delete-form-{{ $prenda->id_prenda }}" action="{{ route('admin.ropa.destroy', $prenda->id_prenda) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="pagination-container">
    {{ $prendas->links('pagination.custom') }}
</div>
