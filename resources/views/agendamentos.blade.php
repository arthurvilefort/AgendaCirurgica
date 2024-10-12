@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Agendar Nova Cirurgia</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('agendamento.store') }}" method="POST">
                        @csrf

                        <!-- Selecionar o Hospital -->
                        <div class="form-group mb-3">
                            <label for="hospital_id">Selecione o Hospital:</label>
                            <select class="form-control" id="hospital_id" name="hospital_id" required>
                                <option value="">Selecione...</option>
                                @foreach ($hospitals as $hospital)
                                    <option value="{{ $hospital->id }}">{{ $hospital->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Selecionar a Sala -->
                        <div class="form-group mb-3">
                            <label for="sala_id">Selecione a Sala:</label>
                            <select class="form-control" id="sala_id" name="sala_id" required>
                                <!-- As opções serão carregadas via JavaScript -->
                            </select>
                        </div>

                        <!-- Selecionar o Paciente -->
                        <div class="form-group mb-3">
                            <label for="paciente_id">Selecione o Paciente:</label>
                            <select class="form-control" id="paciente_id" name="paciente_id" required>
                                <option value="">Selecione...</option>
                                @foreach ($pacients as $pacient)
                                    <option value="{{ $pacient->id }}">{{ $pacient->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Selecionar o Tipo de Cirurgia -->
                        <div class="form-group mb-3">
                            <label for="tipo_cirurgia_id">Selecione o Tipo de Cirurgia:</label>
                            <select class="form-control" id="tipo_cirurgia_id" name="tipo_cirurgia_id" required>
                                <option value="">Selecione...</option>
                                @foreach ($surgeryTypes as $surgeryType)
                                    <option value="{{ $surgeryType->id }}">{{ $surgeryType->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Data e Horário -->
                        <div class="form-group mb-3">
                            <label for="data">Data da Cirurgia:</label>
                            <input type="date" class="form-control" id="data" name="data" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="data_inicio">Horário de Início:</label>
                            <input type="time" class="form-control" id="data_inicio" name="data_inicio" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="data_fim">Horário de Fim:</label>
                            <input type="time" class="form-control" id="data_fim" name="data_fim" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Agendar Cirurgia</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Função para carregar as salas conforme o hospital selecionado
document.getElementById('hospital_id').addEventListener('change', function () {
    var hospitalId = this.value;

    // Fazer requisição via AJAX para obter as salas
    fetch(`/api/hospitals/${hospitalId}/salas`)
        .then(response => response.json())
        .then(data => {
            var salaSelect = document.getElementById('sala_id');
            salaSelect.innerHTML = '<option value="">Selecione...</option>';
            data.forEach(function(sala) {
                salaSelect.innerHTML += `<option value="${sala.id}">${sala.sala_nome}</option>`;
            });
        });
});
</script>
@endsection
