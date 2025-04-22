<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Precio</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="prendas-table">
            @foreach ($prendas as $prenda)
                <tr>
                    <td>{{ $prenda->id_prenda }}</td>
                    <td>{{ $prenda->nombre }}</td>
                    <td>{{ $prenda->tipo->tipo }}</td>
                    <td>{{ $prenda->precio }} €</td>
                    <td>{{ $prenda->descripcion }}</td>
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
