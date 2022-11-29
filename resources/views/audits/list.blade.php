@extends('layouts.app', ['is_product' => true])

@section('content')
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-9 col-9">
                      <h1 class="text-white d-inline-block mb-0">SISTEMA INTEGRAL DE SEGUIMIENTO DE AUDITORÍAS (SISA)</h1>
                    </div>
                    <div class="col-lg-3 col-3 text-right">
                        <button class="btn btn-primary" onclick="openModal()">
                            <i class="fas fa-plus"></i> CREAR AUDITORÍA
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
    <!-- Modal Agregar Auditoria-->
    <div class="modal fade" id="addAudit" tabindex="-1" aria-labelledby="addAuditLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h2 class="modal-title" id="addAuditLabel">CREAR UNA NUEVA AUDITORÍA</h2>
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form action="{{url('/audits/create')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="user" class="form-label">Responsable</label>
                        <input type="text" class="form-control" id="user" value="{{Auth::user()->name}}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese el Nombre de la Auditoría">
                    </div>
                    <div class="mb-3">
                        <label for="code" class="form-label">Código</label>
                        <input type="text" class="form-control" id="code" name="code" placeholder="Ingrese el Código de la Auditoría">
                    </div>
                    <div class="mb-3">
                        <label for="expiration_date" class="form-label">Fecha de Vencimiento</label>
                        <input type="date" class="form-control" name="expiration_date" id="expiration_date">
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
                        <label for="editName" class="form-label">Nombre</label>
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

    <!-- Modal Ver Hallazgos-->
    <div class="modal fade" id="findsDetails" tabindex="-1" aria-labelledby="findsDetailsLabelHeader" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-primary bg-gradient">
                <div class="modal-header">
                <h2 class="modal-title text-secondary text-center" id="findsDetailsLabelHeader"></h2>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                        <!-- Dark table -->
                      <div class="row">
                        <div class="col">
                          <div class="card bg-default shadow">
                            <div class="card-header bg-transparent">
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
                                  </tr>
                                </thead>
                                <tbody class="list" id="tableFinds">
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </div>

    <!--Tabla Principal-->
    <div class="container-fluid mt--7 shadow">
        <!-- Dark table -->
      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-header shadow" style="background:black">
                <div>
                    <h4 class="text-left text-white mb-0 mt-0">AUDITORIAS ACTIVAS</h4>
                </div>
            </div>
            <div class="table-responsive shadow">
              <table class="table align-items-center table-dark table-flush shadow">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col" class="sort text-center" data-sort="budget">Nombre</th>
                    <th scope="col" class="sort text-center" data-sort="status">Código</th>
                    <th scope="col" class="sort text-center" data-sort="status">Fecha de Vencimiento</th>
                    <th scope="col" class="sort text-center" data-sort="status">Estatus</th>
                    <th class="text-center" scope="col" class="sort" data-sort="status">Hallazgos</th>
                    <th scope="col" class="sort text-center" data-sort="status">Detalle</th>
                    <th scope="col" class="sort text-center" data-sort="status">Acción</th>
                    <!--<th scope="col">Users</th>
                    <th scope="col" class="sort" data-sort="completion">Completion</th>
                    <th scope="col"></th>-->
                  </tr>
                </thead>
                <tbody class="list">
                @foreach($audits as $audit)
                  <tr>
                    <td class="text-center">
                        {{wordwrap($audit->name,10)}}
                    </td>
                    <td>
                        {{$audit->code}}
                    </td>
                    <td class="text-center">
                        {{$audit->expiration_date}}
                    </td>
                    <td class="text-center">
                        {{$audit->user->name}}
                    </td>
                    <td>
                        <span class="badge badge-dot mr-4">
                            @if($audit->status == 1)
                                <i class="bg-success"></i>
                            @else
                                <i class="bg-warning"></i>
                            @endif
                            <span class="status">{{$audit->status == 1 ? 'Activa' : 'Finalizada'}}</span>
                        </span>
                    </td>
                    @if(count($audit->find) == 0)
                    <td class="text-center">
                        No posee
                    </td>
                    @else
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-primary" onclick="findsDetails({{$audit}})">
                            <i class="ni ni-collection"></i>&nbsp; Ver Hallazgos
                        </button>
                    </td>
                    @endif
                    <td class="text-center">
                        <div class="dropdown">
                          <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a class="dropdown-item" href="#" onclick="editAuditoria({{$audit}})">Editar Auditoría</a>
                            <a class="dropdown-item" href="{{url('/audits/delete/'.$audit->id)}}">Borrar Auditoría</a>
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
    </div>
    <div>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor, voluptatum accusamus eligendi sapiente laudantium sed delectus, inventore iure consequuntur illum accusantium alias repudiandae ipsum incidunt numquam distinctio at ipsa. Deleniti.
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores facilis culpa consectetur iusto eveniet consequuntur dolor minus quos similique illum eligendi consequatur, quo beatae, sint rerum esse est reiciendis doloremque?
        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Laboriosam doloremque impedit quidem debitis ipsam inventore veniam facere! Itaque, reprehenderit repellat nulla iusto ipsum, totam amet non hic molestias aperiam numquam.
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta similique consectetur dolorem officia nisi porro omnis animi delectus possimus sint. Aperiam aspernatur perspiciatis illum hic quas maxime magni quibusdam consequuntur.
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut ab ratione possimus eligendi reprehenderit tempore at atque numquam, ducimus sequi vero repudiandae veniam aliquam mollitia! Earum dolor odit molestias tenetur.
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum natus similique nemo in earum tenetur autem id consectetur voluptatum at. Explicabo asperiores aliquam repellendus id sit soluta quidem eligendi error?
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Officiis qui incidunt dolores et aliquam? Aperiam delectus iusto iste dolorem ipsa odio. Consequatur laboriosam sit possimus itaque deleniti facere praesentium rerum.
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis, corrupti magnam. Doloremque dicta tempore, earum, officiis rerum ad impedit iste quod officia soluta enim. Beatae quisquam excepturi iusto incidunt natus
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

        const findsDetails = (audit,role) => {
            $("#findsDetailsLabelHeader").text(audit.code)
            $("#tableFinds").empty()

            audit.find.forEach((e,i) => {
                        $("#tableFinds").append(`
                        <tr>
                            <td class="text-center">
                                ${e.name}
                            </td>
                            <td class="text-center">
                                ${e.responsible}
                            </td>
                            <td class="text-center">
                                ${e.audit.name}
                            </td>
                            <td class="text-center">
                                ${e.end_date}
                            </td>
                            <td>
                                <span class="badge badge-dot mr-4">
                                    ${e.status == 1 ? '<i class="bg-success"></i>' : '<i class="bg-warning"></i>' }
                                    <span class="status">${e.status == 1 ? 'Activo' : 'Finalizado'}</span>
                                </span>
                            </td>
                        </tr>
                    `)
            });

            $("#findsDetails").modal("show")
        }

    </script>
@endpush
