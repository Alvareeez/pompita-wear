<div class="table-container">
  <table class="custom-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Destacada</th>
        <th>Expira En</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach($prendas as $prenda)
        <tr data-id="{{ $prenda->id_prenda }}">
          <td>{{ $prenda->id_prenda }}</td>
          <td>{{ $prenda->nombre }}</td>
          <td>
            @if($prenda->destacada)
              <span class="badge-success">Sí</span>
            @else
              <span class="badge-secondary">No</span>
            @endif
          </td>
          <td>{{ $prenda->destacado_hasta ?? '—' }}</td>
          <td>
            <button class="btn-toggle" data-destacada="{{ $prenda->destacada ? 0 : 1 }}">
              {{ $prenda->destacada ? 'Quitar' : 'Marcar' }}
            </button>
            <input type="date" class="input-date" value="{{ $prenda->destacado_hasta }}">
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="d-flex justify-content-center">
  {!! $prendas->links() !!}
</div>
