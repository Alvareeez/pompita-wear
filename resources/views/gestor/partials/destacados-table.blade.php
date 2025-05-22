<div class="table-responsive">
  <table class="table table-hover align-middle">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Destacada</th>
        <th>Expira En</th>
        <th class="text-center">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @foreach($prendas as $prenda)
        <tr data-id="{{ $prenda->id_prenda }}">
          <td>{{ $prenda->id_prenda }}</td>
          <td>{{ $prenda->nombre }}</td>
          <td>
            @if($prenda->destacada)
              <span class="badge bg-success">Sí</span>
            @else
              <span class="badge bg-secondary">No</span>
            @endif
          </td>
          <td>{{ $prenda->destacado_hasta ?? '—' }}</td>
          <td class="text-center">
            <button class="btn btn-sm btn-outline-primary btn-toggle" 
                    data-destacada="{{ $prenda->destacada ? 0 : 1 }}">
              {{ $prenda->destacada ? 'Quitar' : 'Marcar' }}
            </button>
            <input type="date" class="form-control form-control-sm d-inline-block mx-2 inp-hasta"
                   value="{{ $prenda->destacado_hasta }}">
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="d-flex justify-content-center">
  {!! $prendas->links() !!}
</div>
