@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header ">
          <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8 text-center">Usuários</div>
            @if(Auth::user()->level != 1)
            <div class="col-md-2 text-right">
              <a class="btn-sm btn-success " href="{{ url('/register') }}" style="text-decoration:none">Criar novo usuário &nbsp<span class="fa fa-user-plus"></span></button></a>
            </div>
            @endif
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <br />
            <div class="col-md-12">
              @if (isset($users) && $users)
              <div class="table-responsive no-padding">
                <table class="table table-hover " id="tabela_itens">
                  <thead>
                    <tr>
                      <th class="col-md-2 bg-transparent text-center  ">Nome do Usuário</th>
                      <th class="col-md-2 bg-transparent text-center  ">E-mail</th>
                      <th class="col-md-2 bg-transparent  text-center">CPF/CRM</th>
                      <th class="col-md-2 bg-transparent  text-center">Contato</th>
                      <th class="col-md-2 bg-transparent text-center ">Level</th>
                      <th class="col-md-1  bg-transparent  text-center">Detalhes</th>
                      <th class="col-md-1  bg-transparent  text-center">Excluir</th>

                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $user)
                    @if(Auth::user()->level == 0 || (Auth::user()->level == 1 && $user->level == 1) || (Auth::user()->level == 2 && $user->level != 0))
                    <tr>
                      <td class="col-md-2 text-center">{{$user->name}}</td>
                      <td class="col-md-2 text-center">{{$user->email}}</td>
                      <td class="col-md-2 text-center">{{$user->crmv_cpf}}</td>
                      <td class="col-md-2 text-center">{{$user->contato}}</td>
                      <td class="col-md-2 text-center">@if($user->level == 0)
                        Administrador
                        @endif
                        @if($user->level == 1)
                        Médico
                        @endif
                        @if($user->level == 2)
                        Funcionário
                        @endif
                      </td>
                      <td class="col-md-1 text-center">
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalupdate{{$user->id}}">
                          <span class="fa fa-eye"></span></button>
                      </td>
                      <td class="col-md-1 text-center">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalExcluir{{$user->id}}">
                          <span class="fa fa-trash excluir"></span></button>
                      </td>
                      </button>

                      </td>
                      </td>


                    </tr>
                    @endif
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



@if (isset($users) && $users)
@foreach ($users as $user)
<!-- Modal excluir -->
<div class="modal fade" id="modalExcluir{{$user->id}}" tabindex="-1" aria-labelledby="modalExcluirLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 fw-bold" id="modalExcluir{{$user->id}}">Tem certeza que deseja excluir este usuário?</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">Nome do Usuário:</div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <input type="text" class="form-control" value="{{$user->name}}" readonly>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12">Email:</div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <input type="text" class="form-control" value="{{$user->email}}" readonly>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12">Level:</div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <input type="text" class="form-control"
              value="@switch($user->level)
               @case(0)Administrador
                   @break
               @case(1)Médico
                   @break
               @case(2)Funcionário
                   @break
           @endswitch"
              readonly>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12">Contato:</div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <input type="text" class="form-control" value="{{$user->contato}}" readonly>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12">CPF/CRM:</div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <input type="text" class="form-control" value="{{$user->crmv_cpf}}" readonly>
          </div>
        </div>
        <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-defaut btn-block shadow-sm text-white" data-bs-dismiss="modal">Cancelar</button>
        <a href=" {{route('user.destroy', $user)}}" class="btn btn-danger btn-defaut btn-block shadow-sm text-white btnExcluir">Excluir</a>
      </div>
    </div>
  </div>
</div>
<!--Modal Excluir-->
<!-- Modal update -->
<div class="modal fade" id="modalupdate{{$user->id}}" tabindex="-1" aria-labelledby="modalupdateLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 fw-bold" id="modalupdate{{$user->id}}">Editar Informações deste usuário:</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('user.update', $user) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-md-12">Nome do Usuário:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input type="text" name="name" class="form-control" value="{{$user->name}}">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">Email:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input type="text" name="email" class="form-control" value="{{$user->email}}">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">Level:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <select class="form-control" name="level" id="level">
                <option value="">Selecione uma opção</option>

                @if(Auth::user()->id == 1)
                <option value="0" {{ $user->level == 0 ? 'selected' : '' }}>Administrador</option>
                @endif

                <option value="1" {{ $user->level == 1 ? 'selected' : '' }}>Médico</option>
                <option value="2" {{ $user->level == 2 ? 'selected' : '' }}>Funcionário</option>
              </select>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">Contato:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input type="text" name="contato" class="form-control" value="{{$user->contato}}">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">CPF/CRM:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input type="text" name="crm_cpf" class="form-control" value="{{$user->crmv_cpf}}">
            </div>
          </div>
          <br>

          <div class="row">
            <div class="col-md-12">
              <button type="button" id="show-password-fields-{{$user->id}}" class="btn btn-warning">Atualizar Senha</button>
            </div>
          </div>
          <div id="password-fields-{{$user->id}}" style="display: none;">
            <div class="row">
              <div class="col-md-12">Nova Senha:</div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">Confirmar Nova Senha:</div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <input type="password" name="password_confirmation" class="form-control">
              </div>
            </div>
            <br>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-defaut btn-block shadow-sm text-white" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success btn-defaut btn-block shadow-sm text-white">Salvar</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!--Modal update-->

@endforeach
@endif


@endsection
@section('scripts')
<script src="{{ asset('/js/all.js')}}"></script>
<script>
  document.querySelectorAll('[id^="show-password-fields-"]').forEach(function(button) {
    button.addEventListener('click', function() {
      var userId = this.id.split('-').pop(); // Extrai o ID do usuário do botão
      var passwordFields = document.getElementById('password-fields-' + userId);

      // Alternar a visibilidade dos campos de senha
      if (passwordFields.style.display === 'none') {
        passwordFields.style.display = 'block'; // Mostrar os campos de senha
      } else {
        passwordFields.style.display = 'none'; // Esconder os campos de senha
      }
    });
  });
</script>

@endsection