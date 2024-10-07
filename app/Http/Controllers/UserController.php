<?php

namespace App\Http\Controllers;

use App\Models\User as ModelsUser;
use App\Models\User;
use Illuminate\Database\QueryException;



use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('auth.users', compact('users'));
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
        //
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
    public function update(User $user)
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'contato' => 'required',
            'level' => 'required',
            'crm_cpf' => 'required',
            'password' => 'nullable|min:6|confirmed' // Senha não é obrigatória, mas precisa ser confirmada se enviada
        ]);
    
        // Atualiza os dados do usuário
        $user->name = request('name');
        $user->email = request('email');
        $user->contato = request('contato');
        $user->level = request('level');
        $user->crmv_cpf = request('crm_cpf');
    
        // Atualiza a senha apenas se um novo valor for enviado
        if (request('password')) {
            $user->password = bcrypt(request('password'));
        }
    
        try {
            $user->save();
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
    public function destroy(User $user)
    {

        try {
            $user->delete();
        } catch (QueryException $e) {
            session()->flash('mensagem-erro', 'Erro ao excluir o registro.');
            return redirect()->back();
        }

        session()->flash('mensagem-sucesso', 'Usuário excluído com sucesso.');

        return redirect()->back();
    }
}
