<?php

namespace App\Http\Controllers;

use App\Models\Pacient;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class PacientsController extends Controller
{
    public function index()
    {
        $pacients = Pacient::orderBy('nome')->get(); // ajustado para buscar "nome"
        return view('pacients', compact('pacients'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:11|unique:pacients',
            'data_nascimento' => 'required|date',
            'telefone' => 'nullable|string|max:20',
            'endereco' => 'nullable|string|max:255',
        ]);
    
        try {
            Pacient::create([
                'nome' => $request->nome,
                'cpf' => $request->cpf,
                'data_nascimento' => $request->data_nascimento,
                'telefone' => $request->telefone,
                'endereco' => $request->endereco,
            ]);
            session()->flash('mensagem-sucesso', 'Paciente cadastrado com sucesso.');
        } catch (QueryException $e) {
            session()->flash('mensagem-erro', 'Erro ao cadastrar o paciente: ' . $e->getMessage());
            return redirect()->back();
        }
    
        return redirect()->back();
    }
            
    public function destroy(Pacient $pacient)
    {
        try {
            $pacient->delete();
            session()->flash('mensagem-sucesso', 'Paciente excluído com sucesso.');
        } catch (QueryException $e) {
            session()->flash('mensagem-erro', 'Erro ao excluir o paciente.');
            return redirect()->back();
        }

        return redirect()->back();
    }

    public function update(Request $request, Pacient $pacient)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:11|unique:pacients,cpf,' . $pacient->id,
            'data_nascimento' => 'required|date',
            'telefone' => 'required|string|max:20',
            'endereco' => 'required|string|max:255',
        ]);

        try {
            $pacient->update($validatedData);
            session()->flash('mensagem-sucesso', 'Paciente atualizado com sucesso.');
        } catch (QueryException $e) {
            session()->flash('mensagem-erro', 'Erro ao atualizar o paciente.');
            return redirect()->back();
        }

        return redirect()->back();
    }
}
