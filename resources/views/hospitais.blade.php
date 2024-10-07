@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header ">
          <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 text-center">Hospitais
            </div>
            @if(Auth::user()->level == 0)
            <div class="col-md-2 text-right">
              <button type="button" class="btn-sm btn-success " data-bs-toggle="modal" data-bs-target="#modalcreate" style="text-decoration:none">Criar novo hospital &nbsp<span class="fa fa-user-plus"></span>
            </div>
            @endif
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <br />
            <div class="col-md-12">
              @if (isset($hospitais) && $hospitais)
              <div class="table-responsive no-padding">
                <table class="table table-hover " id="tabela_itens">
                  <thead>
                    <tr>
                      <th class="col-md-2 bg-transparent text-center  ">Nome do Hospital</th>
                      <th class="col-md-3 bg-transparent text-center  ">Endereço</th>
                      @if(Auth::user()->level != 1)
                      <th class="col-md-2 bg-transparent  text-center">Quantidade Total de Salas</th>
                      <th class="col-md-2 bg-transparent  text-center">Usuários por Hospital</th>
                      <th class="col-md-2 bg-transparent  text-center">Adicionar Usuarios</th>
                      <th class="col-md-1  bg-transparent  text-center">Editar</th>
                      <th class="col-md-1  bg-transparent  text-center">Excluir</th>
                      @else<!-- SE FOR MEDICO EXIBE SÓ ESSA -->
                      <th class="col-md-6 bg-transparent  text-center">Quantidade Total de Salas</th>
                      @endif
                     

                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($hospitais as $hospital)
        
                    <tr>
                      <td class="col-md-2 text-center">{{$hospital->nome}}</td>
                      <td class="col-md-3 text-center">{{$hospital->endereco}}</td>
                      @if(Auth::user()->level != 1)
                      <td class="col-md-2 text-center">
                        @php
                        $qtdSalas = $salas->where('hospital_id', $hospital->id)->count();
                        @endphp

                        @if ($qtdSalas > 0)
                        <button class="btn btn-info">
                        {{ $qtdSalas }} Salas nesse Hospital
                        </button>
                        @else
                        <button class="btn btn-info">
                          {{ $qtdSalas }} Salas nesse Hospital
                        </button>
                        @endif
                      </td>
                      <td class="col-md-2 text-center">
                      <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalListUsers{{$hospital->id}}">
                        {{ $qtdSalas }} Usuarios 
                        </button>
                      </td>
                      <td class="col-md-1 text-center">
                        <button type="button" class="btn btn-success btn-sm " data-bs-toggle="modal" data-bs-target="#modalAddUsers{{$hospital->id}}">
                          <span class="fa fa-plus"></span></button>
                      </td>
                      <td class="col-md-1 text-center">
                        <button type="button" class="btn btn-info btn-sm " data-bs-toggle="modal" data-bs-target="#modalupdate{{$hospital->id}}">
                          <span class="fa fa-pencil"></span></button>
                      </td>
                      <td class="col-md-1 text-center">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalExcluir{{$hospital->id}}">
                          <span class="fa fa-trash excluir"></span></button>
                      </td>
                      @else<!-- SE FOR MEDICO EXIBE SÓ ESSA -->
                      <td class="col-md-6 text-center">
                        @php
                        $qtdSalas = $salas->where('hospital_id', $hospital->id)->count();
                        @endphp

                        @if ($qtdSalas > 0)
                        <button class="btn btn-info">
                        {{ $qtdSalas }} Salas nesse Hospital
                        </button>
                        @else
                        <button class="btn btn-info">
                          {{ $qtdSalas }} Salas nesse Hospital
                        </button>
                        @endif
                      </td>
                      @endif
                 
                     
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              @else
              <br />
              <div class="col-md-12 text-center alert alert-warning"><strong>Não há registros para exibir.</strong></div>
              @endif

            </div>
          </div>
          <br>

        </div>
      </div>
    </div>
  </div>
</div>



@if (isset($hospitais) && $hospitais)
@foreach ($hospitais as $hospital)
<!-- Modal excluir -->
<div class="modal fade" id="modalExcluir{{$hospital->id}}" tabindex="-1" aria-labelledby="modalExcluirLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 fw-bold" id="modalExcluir{{$hospital->id}}">Tem certeza que deseja excluir este Hospital?</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">Nome do Hospital:</div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <input type="text" class="form-control" value="{{$hospital->nome}}" readonly>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12">endereco:</div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <input type="text" class="form-control" value="{{$hospital->endereco}}" readonly>
          </div>
        </div>
        <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-defaut btn-block shadow-sm text-white" data-bs-dismiss="modal">Cancelar</button>
        <a href=" {{route('hospital.destroy', $hospital->id)}}" class="btn btn-danger btn-defaut btn-block shadow-sm text-white btnExcluir">Excluir</a>
      </div>
    </div>
  </div>
</div>
<!--Modal Excluir-->
<!-- Modal update -->
<div class="modal fade" id="modalupdate{{$hospital->id}}" tabindex="-1" aria-labelledby="modalupdateLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 fw-bold" id="modalupdate{{$hospital->id}}">Tem certeza que deseja excluir este Hospital?</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form action="{{ route('hospital.update', $hospital) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-md-12">Nome do Hospital:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input type="text" class="form-control" value="{{$hospital->nome}}" name="nome">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">endereco:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input type="text" class="form-control" value="{{$hospital->endereco}}" name="endereco">

            </div>
          </div>
          <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-defaut btn-block shadow-sm text-white" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success btn-defaut btn-block shadow-sm text-white">Salvar</button>
      </div>
    </div>
    </form>
  </div>
</div>
<!--Modal update-->

<!-- Modal para listar e excluir usuários -->
<div class="modal fade" id="modalListUsers{{$hospital->id}}" tabindex="-1" aria-labelledby="modalListUsersLabel{{$hospital->id}}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Usuários no Hospital: <b>{{$hospital->nome}}</b></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <!-- Lista de usuários -->
        <ul class="list-group">
          @foreach ($hospital->users as $user)
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <strong>{{ $user->name }}</strong> - {{ $user->email }}
              <form  method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
              </form>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- Modal para adicionar usuários -->
<div class="modal fade" id="modalAddUsers{{$hospital->id}}" tabindex="-1" aria-labelledby="modalAddUsersLabel{{$hospital->id}}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Adicionar Usuários ao Hospital: <b>{{$hospital->nome}}</b></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <!-- Campo de pesquisa -->
        <input type="text" class="form-control mb-3" id="searchAllUsers{{$hospital->id}}" placeholder="Pesquisar usuários...">

        <!-- Lista de todos os usuários que ainda não pertencem ao hospital -->
        <ul class="list-group">
          @foreach ($users->diff($hospital->users) as $user) <!-- Exibir usuários não associados ao hospital -->
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <strong>{{ $user->name }}</strong> - {{ $user->email }}
              <form method="POST">
                @csrf
                <button type="submit" class="btn btn-success btn-sm">Adicionar</button>
              </form>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</div>

@endforeach
@endif

<!-- Modal create -->
<div class="modal fade" id="modalcreate" tabindex="-1" aria-labelledby="modalcreateLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 fw-bold" id="modalcreate">Cadastrar Novo Hospital:</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('createhospital') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-12">Nome do Hospital:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input type="text" class="form-control " id="nome" name="nome" minlength="3" maxlength="50" placeholder="Nome do Hospital">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">Endereço:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input type="text" class="form-control " id="endereco" name="endereco" minlength="3" maxlength="50" placeholder="Endereço do Hospital">
            </div>
          </div>
          <br>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-defaut btn-block shadow-sm text-white" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success btn-defaut btn-block shadow-sm text-white">Salvar</button>
      </div>
    </div>
    </form>
  </div>
</div>
</div>
<!--Modal create-->



@endsection
@section('scripts')
<script src="{{ asset('/js/all.js')}}"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    var hospitais = @json($hospitais);

    hospitais.forEach(function (hospital) {
        // Função de pesquisa dentro do modal
        document.getElementById('search-usuarios-' + hospital.id).addEventListener('input', function () {
            var searchValue = this.value.toLowerCase();
            var listItems = document.querySelectorAll('#usuarios-list-' + hospital.id + ' li');

            listItems.forEach(function (item) {
                var userName = item.textContent.toLowerCase();
                if (userName.includes(searchValue)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});

</script>
@endsection