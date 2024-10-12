@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header ">
          <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4 text-center">Salas existentes do <strong>Hospital {{$hospital->nome}}</strong>
            </div>
            @if(Auth::user()->level == 0)
            <div class="col-md-4 text-right">
              <button type="button" class="btn-sm btn-success " data-bs-toggle="modal" data-bs-target="#modalcreate" style="text-decoration:none">Criar nova sala para o hospital {{$hospital->nome}} &nbsp<span class="fa fa-user-plus"></span>
            </div>
            @endif
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <br />
            <div class="col-md-12">
              @if (isset($salas) && $salas)
              <div class="table-responsive no-padding">
                <table class="table table-hover " id="tabela_itens">
                  <thead>
                    <tr>
                      <th class="col-md-3 bg-transparent text-center  ">Nome da sala</th>
                      <th class="col-md-3 bg-transparent text-center  ">Agendamentos</th>
                      @if(Auth::user()->level != 1)
                      <th class="col-md-2 bg-transparent  text-center">Restrições</th>
                      <th class="col-md-1  bg-transparent  text-center">Editar</th>
                      <th class="col-md-1  bg-transparent  text-center">Excluir</th>
                      @else<!-- SE FOR MEDICO EXIBE SÓ ESSA -->
                      <th class="col-md-6 bg-transparent  text-center">Quantidade Total de Salas</th>
                      @endif


                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($salas as $sala)

                    <tr>
                      <td class="col-md-3 text-center">{{$sala->sala_nome}}</td>
                      <td class="col-md-3 text-center"><button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCalendar{{ $sala->id }}">
                          Abrir Calendário
                        </button></td>
                      @if(Auth::user()->level != 1)

                      <td class="col-md-2 text-center">
                        @php
                        $qtdrestricoes = $sala->tipocirurgias()->count();
                        @endphp
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalListRestrictions{{$sala->id}}">
                          {{ $qtdrestricoes }} Restrições
                        </button>
                      </td>

                      <td class="col-md-1 text-center">
                        <button type="button" class="btn btn-info btn-sm " data-bs-toggle="modal" data-bs-target="#modalupdate{{$sala->id}}">
                          <span class="fa fa-pencil"></span></button>
                      </td>
                      <td class="col-md-1 text-center">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalExcluir{{$sala->id}}">
                          <span class="fa fa-trash excluir"></span></button>
                      </td>
                      @else<!-- SE FOR MEDICO EXIBE SÓ ESSA -->
                      <td class="col-md-6 text-center">

                        <button class="btn btn-info">
                          Salas nesse Hospital
                        </button>
                        <button class="btn btn-info">
                          Salas nesse Hospital
                        </button>
                        @endif
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




@if (isset($salas) && $salas)
@foreach ($salas as $sala)

<!-- Modal do calendário -->
<div class="modal fade" id="modalCalendar{{ $sala->id }}" tabindex="-1" aria-labelledby="modalCalendarLabel{{ $sala->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCalendarLabel{{ $sala->id }}">Calendário da Sala: {{ $sala->sala_nome }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <!-- Div onde o calendário será renderizado -->
        <div id="calendar{{ $sala->id }}" data-sala-id="{{ $sala->id }}" 
          data-cirurgias="{{ json_encode($cirurgias->map(function ($cirurgia) {
            return [
              'sala_id' => $cirurgia->sala_id,
              'tipo_cirurgia_id' => $cirurgia->tipo_cirurgia_id,
              'data' => $cirurgia->data,
              'data_inicio' => $cirurgia->data_inicio,
              'data_fim' => $cirurgia->data_fim
            ];
          })) }}"
          data-tipos-cirurgias="{{ json_encode($tipocirurgias->map(function ($tipo) {
            return [
              'id' => $tipo->id,
              'nome' => $tipo->nome
            ];
          })) }}">
        </div>
      </div>
    </div>
  </div>
</div>



<!-- Modal excluir -->
<div class="modal fade" id="modalExcluir{{$sala->id}}" tabindex="-1" aria-labelledby="modalExcluirLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 fw-bold" id="modalExcluir{{$hospital->id}}">Tem certeza que deseja excluir esta Sala?</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">Nome da Sala:</div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <input type="text" class="form-control" value="{{$sala->sala_nome}}" readonly>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12">Hospital Pertencente:</div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <input type="text" class="form-control" value="{{$sala->hospital_id}}" readonly>
          </div>
        </div>
        <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-defaut btn-block shadow-sm text-white" data-bs-dismiss="modal">Cancelar</button>
        <a href=" {{route('sala.destroy', $sala->id)}}" class="btn btn-danger btn-defaut btn-block shadow-sm text-white btnExcluir">Excluir</a>
      </div>
    </div>
  </div>
</div>
<!--Modal Excluir-->
<!-- Modal update -->
<div class="modal fade" id="modalupdate{{$sala->id}}" tabindex="-1" aria-labelledby="modalupdateLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 fw-bold" id="modalupdate{{$sala->id}}">Deseja Atualizar os dados desta Sala?</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form action="{{ route('sala.update', $sala) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-md-12">Nome da Sala:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input type="text" class="form-control" value="{{$sala->sala_nome}}" name="nome">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">Hospital:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input type="text" class="form-control" value="{{$sala->hospital_id}}" name="hospital">

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
<!-- Modal para gerenciar Restrições da Sala-->
<div class="modal fade" id="modalListRestrictions{{$sala->id}}" tabindex="-1" aria-labelledby="modalListRestrictionsLabel{{$sala->id}}" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Gerenciar Restrições da Sala: <strong>{{ $sala->sala_nome }}</strong></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <!-- Lista de restrições já pertencentes a Sala-->
        <ul class="list-group mb-3">
          @foreach ($sala->tipocirurgias as $tipocirurgia)
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ $tipocirurgia->nome }} - {{ $tipocirurgia->desc }}
            <form action="{{ route('sala.removeRestrictions', ['sala' => $sala->id, 'tipocirurgia' => $tipocirurgia->id]) }}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm">Remover</button>
            </form>
          </li>
          @endforeach
          @if ($sala->tipocirurgias->isEmpty())
          <li class="list-group-item text-center">Nenhuma restrição associada a esta Sala.</li>
          @endif
        </ul>

        <!-- Formulário para adicionar novos usuários -->
        <form action="{{ route('sala.addRestrictions', $sala->id) }}" method="POST">
          @csrf
          <div class="input-group">
            <select class="form-select" name="tipocirurgia_id" required>
              <option value="">Selecione um tipo de cirurgia para restringir...</option>
              @foreach ($tipocirurgias->diff($sala->tipocirurgias) as $tipocirurgia)
              <option value="{{ $tipocirurgia->id }}">{{ $tipocirurgia->nome }} - {{ $tipocirurgia->desc }}</option>
              @endforeach
            </select>
            <button class="btn btn-success" type="submit">Adicionar restrição</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
<!-- Fim do Modal -->




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
        <form action="{{ route('createsala') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-12">Nome da sala:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input type="text" class="form-control " id="nome" name="nome" minlength="3" maxlength="50" placeholder="Nome da Sala">
              <input type="hidden" id="hospital_id" name="hospital_id" value="{{$hospital->id}}">
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
<!-- Script de inicialização do calendário -->

@endsection