@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header ">
          <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4 text-center">Pacientes
            </div>
            @if(Auth::user()->level == 0)
            <div class="col-md-4 text-right">
              <button type="button" class="btn-sm btn-success " data-bs-toggle="modal" data-bs-target="#modalcreate" style="text-decoration:none">Criar novo Paciente<span class="fa fa-user-plus"></span>
            </div>
            @endif
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <br />
            <div class="col-md-12">
              @if (isset($pacients) && $pacients)
              <div class="table-responsive no-padding">
                <table class="table table-hover " id="tabela_itens">
                  <thead>
                    <tr>
                      <th class="col-md-2 bg-transparent text-center  ">Nome do Paciente</th>
                      <th class="col-md-2 bg-transparent text-center  ">CPF</th>
                      <th class="col-md-2 bg-transparent text-center  ">Data de Nascimento</th>
                      <th class="col-md-2 bg-transparent text-center  ">Telefone</th>
                      <th class="col-md-2 bg-transparent text-center  ">Endereço</th>
                      <th class="col-md-1  bg-transparent  text-center">Editar</th>
                      <th class="col-md-1  bg-transparent  text-center">Excluir</th>



                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($pacients as $pacient)

                    <tr>
                      <td class="col-md-2 text-center">{{$pacient->nome}}</td>
                      <td class="col-md-2 text-center">{{$pacient->cpf}}</td>
                      <td class="col-md-2 text-center">{{ \Carbon\Carbon::parse($pacient->data_nascimento)->format('d/m/Y') }}</td>
                      <td class="col-md-2 text-center">{{$pacient->telefone}}</td>
                      <td class="col-md-2 text-center">{{$pacient->endereco}}</td>
                      <td class="col-md-1 text-center">
                        <button type="button" class="btn btn-info btn-sm " data-bs-toggle="modal" data-bs-target="#modalupdate{{$pacient->id}}">
                          <span class="fa fa-pencil"></span></button>
                      </td>
                      <td class="col-md-1 text-center">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalExcluir{{$pacient->id}}">
                          <span class="fa fa-trash excluir"></span></button>
                      </td>

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



@if (isset($pacients) && $pacients)
@foreach ($pacients as $pacient)
<!-- Modal excluir -->
<div class="modal fade" id="modalExcluir{{$pacient->id}}" tabindex="-1" aria-labelledby="modalExcluirLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 fw-bold" id="modalExcluir{{$pacient->id}}">Tem certeza que deseja excluir este Paciente?</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">Nome do Paciente:</div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <input type="text" class="form-control" value="{{$pacient->nome}}" readonly>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12">Cpf:</div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <input type="text" class="form-control" value="{{$pacient->cpf}}" readonly>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12">Data de Nascimento:</div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <input type="text" class="form-control" value="{{$pacient->data_nascimento}}" readonly>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12">Telefone:</div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <input type="text" class="form-control" value="{{$pacient->telefone}}" readonly>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12">Endereço:</div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <input type="text" class="form-control" value="{{$pacient->endereco}}" readonly>
          </div>
        </div>
        <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-defaut btn-block shadow-sm text-white" data-bs-dismiss="modal">Cancelar</button>
        <a href=" {{route('pacients.destroy', $pacient->id)}}" class="btn btn-danger btn-defaut btn-block shadow-sm text-white btnExcluir">Excluir</a>
      </div>
    </div>
  </div>
</div>
<!--Modal Excluir-->
<!-- Modal update -->
<div class="modal fade" id="modalupdate{{$pacient->id}}" tabindex="-1" aria-labelledby="modalupdateLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 fw-bold" id="modalupdate{{$pacient->id}}">Deseja Atualizar os dados deste Paciente?</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form action="{{route('pacients.update', $pacient) }}" method="POST">

          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-md-12">Nome do Paciente:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input type="text" class="form-control" value="{{$pacient->nome}}" name="nome">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">CPF:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input type="text" class="form-control" value="{{$pacient->cpf}}" name="cpf">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">Data de Nascimento:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input type="date" class="form-control" value="{{$pacient->data_nascimento}}" name="data_nascimento">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">Telefone:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input type="text" class="form-control" value="{{$pacient->telefone}}" name="telefone">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">Endereço:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input type="text" class="form-control" value="{{$pacient->endereco}}" name="endereco">
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


@endforeach
@endif

<!-- Modal create -->
<div class="modal fade" id="modalcreate" tabindex="-1" aria-labelledby="modalcreateLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 fw-bold" id="modalcreate">Cadastrar Nova Sala:</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('createpacientes') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-12">Nome do Paciente:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input type="text" class="form-control" name="nome">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">CPF:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input type="text" class="form-control" name="cpf">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">Data de Nascimento:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input type="date" class="form-control"name="data_nascimento">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">Telefone:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input type="text" class="form-control"name="telefone">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">Endereço:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input type="text" class="form-control" name="endereco">
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

@endsection