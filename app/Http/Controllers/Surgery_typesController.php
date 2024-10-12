<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surgery_types;
use Illuminate\Database\QueryException;
use Psy\Sudo;

class Surgery_typesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $procedimentos= Surgery_types::orderBy('id')->get();
        return view('procedimentos', compact('procedimentos'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|max:255',
            'desc' => 'required|max:255',  // Certifique-se de validar o hospital_id
        ]);
    
        try {
            Surgery_types::create([
                'nome' => $validatedData['nome'],
                'desc' => $validatedData['desc'],
            ]);
            session()->flash('mensagem-sucesso', 'Sala cadastrada com sucesso!');
        } catch (QueryException $e) {
            session()->flash('mensagem-erro', 'Erro ao salvar a sala.');
            return redirect()->back();
        }
    
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Surgery_types $procedimento)
    {
        $messages = [
            'nome.required' => 'O campo nome é obrigatório.',
            'desc.required' => 'O campo descrição é obrigatório.',
        ];

        $this->validate(request(), [
            'nome' => 'required',
            'desc' => 'required',
        ], $messages);

        $procedimento->nome = request('nome');
        $procedimento->desc = request('desc');
        try {
            $procedimento->save();
        } catch (QueryException $e) {
            session()->flash('mensagem-erro', 'Erro ao salvar o registro.');
            return redirect()->back();
        }

        session()->flash('mensagem-sucesso', 'Dados alterados com sucesso!');
        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Surgery_types $procedimento)
    {
        try {
            $procedimento->delete();
            session()->flash('mensagem-sucesso', 'Hospital excluído com sucesso.');
        } catch (QueryException $e) {
            session()->flash('mensagem-erro', 'Erro ao excluir o hospital.');
            return redirect()->back();
        }

        return redirect()->back();
    }

}
