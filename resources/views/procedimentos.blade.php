@extends('layouts.app')

@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header ">
          <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4 text-center">Procedimentos
            </div>
            @if(Auth::user()->level == 0)
            <div class="col-md-4 text-right">
              <button type="button" class="btn-sm btn-success " data-bs-toggle="modal" data-bs-target="#modalcreate" style="text-decoration:none">Criar novo Procedimento<span class="fa fa-user-plus"></span>
            </div>
            @endif
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <br />
            <div class="col-md-12">
              @if (isset($procedimentos) && $procedimentos)
              <div class="table-responsive no-padding">
                <table class="table table-hover " id="tabela_itens">
                  <thead>
                    <tr>
                      <th class="col-md-5 bg-transparent text-center  ">Nome do procedimento</th>
                      <th class="col-md-5 bg-transparent text-center  ">Descrição</th>
                      <th class="col-md-1  bg-transparent  text-center">Editar</th>
                      <th class="col-md-1  bg-transparent  text-center">Excluir</th>
                    


                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($procedimentos as $procedimento)

                    <tr>
                      <td class="col-md-5 text-center">{{$procedimento->nome}}</td>
                      <td class="col-md-5 text-center">{{$procedimento->desc}}</td>
                   
                      <td class="col-md-1 text-center">
                        <button type="button" class="btn btn-info btn-sm " data-bs-toggle="modal" data-bs-target="#modalupdate{{$procedimento->id}}">
                          <span class="fa fa-pencil"></span></button>
                      </td>
                      <td class="col-md-1 text-center">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalExcluir{{$procedimento->id}}">
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



@if (isset($procedimentos) && $procedimentos)
@foreach ($procedimentos as $procedimento)
<!-- Modal excluir -->
<div class="modal fade" id="modalExcluir{{$procedimento->id}}" tabindex="-1" aria-labelledby="modalExcluirLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 fw-bold" id="modalExcluir{{$procedimento->id}}">Tem certeza que deseja excluir este Procedimento?</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">Nome do Procedimento:</div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <input type="text" class="form-control" value="{{$procedimento->nome}}" readonly>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-md-12">Descrição:</div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <input type="text" class="form-control" value="{{$procedimento->desc}}" readonly>
          </div>
        </div>
        <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-defaut btn-block shadow-sm text-white" data-bs-dismiss="modal">Cancelar</button>
        <a href=" {{route('procedimento.destroy', $procedimento->id)}}" class="btn btn-danger btn-defaut btn-block shadow-sm text-white btnExcluir">Excluir</a>
      </div>
    </div>
  </div>
</div>
<!--Modal Excluir-->
<!-- Modal update -->
<div class="modal fade" id="modalupdate{{$procedimento->id}}" tabindex="-1" aria-labelledby="modalupdateLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 fw-bold" id="modalupdate{{$procedimento->id}}">Deseja Atualizar os dados deste Procedimento?</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form action="{{ route('procedimento.update', $procedimento) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-md-12">Nome do Procedimento:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input type="text" class="form-control" value="{{$procedimento->nome}}" name="nome">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">Hospital:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input type="text" class="form-control" value="{{$procedimento->desc}}" name="desc">

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
        <form action="{{ route('createprocedimento') }}" method="POST">
          @csrf
          <div class="row">
            <div class="col-md-12">Nome do Procedimento:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input type="text" class="form-control " id="nome" name="nome" minlength="3" maxlength="50" placeholder="Nome do Procedimento">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">Descrição do Procedimento:</div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <input type="text" class="form-control " id="desc" name="desc" minlength="3" maxlength="50" placeholder="Descrição do Procedimento">
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