@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="contato" class="col-md-4 col-form-label text-md-end">{{ __('Contato') }}</label>

                            <div class="col-md-6">
                                <input id="contato" type="contato" class="form-control" name="contato">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="area" class="col-md-4 col-form-label text-md-right">{{ __('Nível') }}</label>
                            <div class="col-md-6">
                                <select class="form-control" name="level" id="level">
                                    <option value="">Selecione uma opção</option>
                                    @if(Auth::user()->id == 1)
                                    <option value="0">Administrador</option>
                                    @endif
                                    <option value="1">Medico</option>
                                    <option value="2">Funcionário</option>

                                </select>
                                @error('level')
                                <span class="help-block" id="span_area">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                         <!-- Input CRM/CPF (exibido dinamicamente) -->
                         <div class="row mb-3" id="crm_cpf_row" style="display: none;">
                            <label for="crm_cpf" class="col-md-4 col-form-label text-md-end" id="crm_cpf_label">CRM/CPF</label>

                            <div class="col-md-6">
                                <input id="crm_cpf" type="text" class="form-control @error('crm_cpf') is-invalid @enderror" name="crm_cpf" value="{{ old('crm_cpf') }}" placeholder="Informe o CRM ou CPF" autocomplete="crm_cpf">
                                @error('crm_cpf')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Senha') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var levelSelect = document.getElementById('level');
        var crmCpfRow = document.getElementById('crm_cpf_row');
        var crmCpfLabel = document.getElementById('crm_cpf_label');
        var crmCpfInput = document.getElementById('crm_cpf');

        // Listener para o select de nível
        levelSelect.addEventListener('change', function () {
            var selectedLevel = levelSelect.value;

            if (selectedLevel == 1) {  // Médico
                crmCpfRow.style.display = 'flex';
                crmCpfLabel.textContent = 'CRM';
                crmCpfInput.placeholder = 'Informe o CRM';
            } else if (selectedLevel != 1) {  // Funcionário ou qualquer outro
                crmCpfRow.style.display = 'flex';
                crmCpfLabel.textContent = 'CPF';
                crmCpfInput.placeholder = 'Informe o CPF';
            } else {
                crmCpfRow.style.display = 'none';
                crmCpfInput.value = '';  // Limpa o campo quando não está visível
            }
        });
    });
</script>

@endsection