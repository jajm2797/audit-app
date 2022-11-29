@extends('layouts.app', ['is_product' => true])

@section('content')
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                      <h6 class="h2 text-white d-inline-block mb-0">APLICACIÓN DE SEGUIMIENTO DE AUDITORÍAS (ASA)</h6>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <button class="btn btn-primary" onclick="openModal()">
                            <i class="fas fa-plus"></i> CREAR HALLAZGO
                        </button>
                    </div>
                  </div>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Agregar Hallazgo-->
    <div class="modal fade" id="addAudit" tabindex="-1" aria-labelledby="addAuditLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h2 class="modal-title" id="addAuditLabel">CREAR UN NUEVO HALLAZGO</h2>
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form action="{{url('/finds/create')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="user" class="form-label">Auditor</label>
                        @if(Auth::user()->role->name == 'admin')
                        <select class="form-control" name="user" id="user">
                            <option value="">Seleccione un auditor responsable</option>
                            @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                        @else
                        <input type="text" class="form-control" id="user" value="{{Auth::user()->name}}" disabled>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="audit" class="form-label">Auditoría</label>
                        <select class="form-control" name="audit_id" id="audit">
                            <option value="">Seleccione</option>
                            @foreach($audits as $audit)
                            <option value="{{$audit->id}}">{{$audit->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese el Nombre del Hallazgo">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción</label>
                        <textarea class="form-control" placeholder="Ingrese una Descripción del Hallazgo" name="description" id="description" cols="30" rows="5"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="recommendation" class="form-label">Recomendación</label>
                        <textarea class="form-control" placeholder="Ingrese una Recomendación para el Hallazgo" name="recommendation" id="recommendation" cols="30" rows="5"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="responsible" class="form-label">Responsable</label>
                        <input type="text" class="form-control" id="responsible" name="responsible" placeholder="Ingrese el Nombre del Responsable">
                    </div>
                    <div class="mb-3">
                        <label for="responsible_comment" class="form-label">Comentario del Responsable</label>
                        <textarea class="form-control" placeholder="Ingrese el Comentario por parte del Responsable" name="responsible_comment" id="responsible_comment" cols="30" rows="5"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Fecha de Vencimiento</label>
                        <input type="date" class="form-control" name="end_date" id="end_date">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
        </div>
    </div>

    <!-- Modal Editar Auditoria-->
    <div class="modal fade" id="editAudit" tabindex="-1" aria-labelledby="editAuditLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h2 class="modal-title" id="editAuditLabel"></h2>
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form action="{{url('/audits/edit')}}" method="post">
                @csrf
                <div class="modal-body">
                    <input type="text" id="idEdit" name="idEdit" hidden/>
                    <div class="mb-3">
                        <label for="editUser" class="form-label">Responsable</label>
                        <input type="text" class="form-control" id="editUser" value="{{Auth::user()->name}}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="eta" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="editName" name="editName" placeholder="Ingrese el Nombre de la Auditoría">
                    </div>
                    <div class="mb-3">
                        <label for="editCode" class="form-label">Código</label>
                        <input type="text" class="form-control" id="editCode" name="editCode" placeholder="Ingrese el Código de la Auditoría">
                    </div>
                    <div class="mb-3">
                        <label for="editDate" class="form-label">Fecha de Vencimiento</label>
                        <input type="date" class="form-control" name="editDate" id="editDate">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
        </div>
    </div>

    <!-- Modal Detalles del Hallazgo-->
    <div class="modal fade" id="findDetail" tabindex="-1" aria-labelledby="findDetailLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h2 class="modal-title" id="findDetailLabel"></h2>
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <input type="text" id="idEdit" name="idEdit" hidden/>
                <div class="mb-3">
                    <label for="detailUser" class="form-label">Auditor</label>
                    <input type="text" class="form-control" id="detailUser" value="{{Auth::user()->name}}" disabled>
                </div>
                <div class="mb-3">
                    <label for="detailFind" class="form-label">Hallazgo</label>
                    <input type="text" class="form-control" id="detailFind" disabled>
                </div>
                <div class="mb-3">
                    <label for="detailDescription" class="form-label">Descripción</label>
                    <textarea class="form-control" id="detailDescription" cols="30" rows="3" disabled></textarea>
                </div>
                <div class="mb-3">
                    <label for="detailRecommendation" class="form-label">Recomendación</label>
                    <textarea class="form-control" id="detailRecommendation" cols="30" rows="3" disabled></textarea>
                </div>
                <div class="mb-3">
                    <label for="detailAudit" class="form-label">Auditoría</label>
                    <input type="text" class="form-control" id="detailAudit" disabled>
                </div>
                <div class="mb-3">
                    <label for="detailResponsible" class="form-label">Responsable</label>
                    <input type="text" class="form-control" id="detailResponsible" disabled>
                </div>
                <div class="mb-3">
                    <label for="detailResponsibleComment" class="form-label">Comentario del Responsable</label>
                    <textarea class="form-control" id="detailResponsibleComment" cols="30" rows="3" disabled></textarea>
                </div>
                <div class="mb-3">
                    <label for="detailDate" class="form-label">Fecha de Vencimiento</label>
                    <input type="date" class="form-control" id="detailDate" disabled>
                </div>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        </div>
    </div>

    <div class="container-fluid mt--7">
        <!-- Dark table -->
      <div class="row">
        <div class="col">
          <div class="card bg-default shadow">
            <div class="card-header bg-transparent border-0">
                <div>
                    <h4 class="text-left text-white mb-0 mt-0">HALLAZGOS ACTIVOS</h4>
                </div>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-dark table-flush">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col" class="sort text-center" data-sort="budget">Nombre</th>
                    <th scope="col" class="sort text-center" data-sort="status">Responsable</th>
                    <th scope="col" class="sort text-center" data-sort="status">Auditoría</th>
                    <th scope="col" class="sort text-center" data-sort="status">Fecha de Vencimiento</th>
                    @if(Auth::user()->role->name == 'admin')
                    <th scope="col" class="sort text-center" data-sort="status">Auditor</th>
                    @endif
                    <th scope="col" class="sort text-center" data-sort="status">Estatus</th>
                    <th scope="col" class="sort text-center" data-sort="status">Detalle</th>
                    <th scope="col" class="sort text-center" data-sort="status">Acción</th>
                    <!--<th scope="col">Users</th>
                    <th scope="col" class="sort" data-sort="completion">Completion</th>
                    <th scope="col"></th>-->
                  </tr>
                </thead>
                <tbody class="list">
                @foreach($finds as $find)
                  <tr>
                    <td class="text-center">
                        {{$find->name}}
                    </td>
                    <td class="text-center">
                        {{wordwrap($find->responsible,15)}}
                    </td>
                    <td class="text-center">
                        {{$find->audit->name}}
                    </td>
                    <td class="text-center">
                        {{$find->end_date}}
                    </td>
                    @if(Auth::user()->role->name == 'admin')
                    <td class="text-center">
                        {{$find->user->name}}
                    </td>
                    @endif
                    <td>
                        <span class="badge badge-dot mr-4">
                            @if($find->status == 1)
                                <i class="bg-success"></i>
                            @else
                                <i class="bg-warning"></i>
                            @endif
                            <span class="status">{{$find->status == 1 ? 'Activo' : 'Finalizado'}}</span>
                        </span>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary" title="Ver detalles" onclick="openDetailModal({{$find}})">
                            <i class="ni ni-ungroup"></i>
                        </button>
                    </td>
                    <td class="text-center">
                        <div class="dropdown">
                          <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a class="dropdown-item" href="#" onclick="editAuditoria({{$find}})">Editar Hallazgo</a>
                            <a class="dropdown-item" href="{{url('/audits/delete/'.$find->id)}}">Solucionar Hallazgo</a>
                          </div>
                        </div>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
        @include('layouts.footers.auth')
    </div>
@endsection
@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script>
        $(document).ready(function() {
            toastr.options.timeOut = 10000;
            @if (Session::has('error'))
                toastr.error('<br> {{ Session::get('error') }}','SISTEMA INTEGRAL DE SEGUIMIENTO DE AUDITORÍAS (SISA)');
            @elseif(Session::has('success'))
                toastr.success('<br> {{ Session::get('success') }}', 'SISTEMA INTEGRAL DE SEGUIMIENTO DE AUDITORÍAS (SISA)');
            @endif
        });

        const openModal = () => {
            $("#addAudit").modal("show")
        }

        const editAuditoria = (audit) => {
            $("#editAuditLabel").text(audit.id)
            $("#idEdit").val(audit.id)
            $("#editUser").val(audit.user.name)
            $("#editName").val(audit.name)
            $("#editCode").val(audit.code)
            $("#editDate").val(audit.expiration_date)
            $("#editAudit").modal("show")
        }


        const openDetailModal = (find) => {
            $("#findDetailLabel").text(find.id)
            $("#detailUser").val(find.user.name)
            $("#detailFind").val(find.name)
            $("#detailDescription").val(find.description)
            $("#detailRecommendation").val(find.recommendation)
            $("#detailAudit").val(find.audit.name)
            $("#detailResponsible").val(find.responsible)
            $("#detailResponsibleComment").val(find.responsible_comment)
            $("#detailDate").val(find.end_date)
            $("#findDetail").modal("show")
        }

    </script>
@endpush
