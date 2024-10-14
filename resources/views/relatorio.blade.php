@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Relatórios
                </div>

                <div class="card-body">
                    <h5 class="card-title">Extrair Relatório Geral de Cirurgias</h5>
                    <p class="card-text">
                        Clique no botão abaixo para baixar o relatório de todas as cirurgias cadastradas no sistema em formato Excel.
                    </p>

                    <!-- Botão para Extrair o Relatório -->
                    <a href="{{ url('export-cirurgias') }}" class="btn btn-primary">
                        <i class="fa fa-file-excel"></i> Exportar Relatório
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
