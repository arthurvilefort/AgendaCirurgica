<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;
use App\Models\User;
use App\Models\Room;
use Illuminate\Database\QueryException;

class HospitalController extends Controller
{
    /**
     * Exibe a lista de hospitais.
     */
    public function index()
    {
        //$hospitais = Hospital::orderBy('nome')->get();
        $hospitais = Hospital::with('users')->orderBy('nome')->get();
        $salas = Room::orderBy('id')->get();
        $users = User::orderBy('name')->get();

        return view('hospitais', compact('hospitais','salas','users'));
    }

    /**
     * Armazena um novo hospital no banco de dados.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|max:255',
            'endereco' => 'required|max:255',
        ]);

        try {
            Hospital::create($validatedData);
            session()->flash('mensagem-sucesso', 'Hospital cadastrado com sucesso!');
        } catch (QueryException $e) {
            session()->flash('mensagem-erro', 'Erro ao salvar o hospital.');
            return redirect()->back();
        }

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Hospital $hospital)
    {
      
        $messages = [
            'nome.required' => 'O campo nome é obrigatório.',
            'endereco.required' => 'O campo endereço é obrigatório.',
        ];
    
        $this->validate(request(), [
            'nome' => 'required',
            'endereco' => 'required',
        ], $messages);
        
    
        // Atualiza os dados do usuário
        $hospital->nome = request('nome');
        $hospital->endereco = request('endereco');

     
    
        try {
            $hospital->save();
        } catch (QueryException $e) {
            session()->flash('mensagem-erro', 'Erro ao salvar o registro.');
            return redirect()->back();
        }
    
        session()->flash('mensagem-sucesso', 'Dados alterados com sucesso!');
        return redirect()->back();
    }

    /**
     * Remove um hospital do banco de dados.
     */
    public function destroy(Hospital $hospital)
    {
        try {
            $hospital->delete();
            session()->flash('mensagem-sucesso', 'Hospital excluído com sucesso.');
        } catch (QueryException $e) {
            session()->flash('mensagem-erro', 'Erro ao excluir o hospital.');
            return redirect()->back();
        }

        return redirect()->back();
    }
}
