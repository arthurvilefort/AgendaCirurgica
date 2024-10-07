<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request; // Importando Request corretamente

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'contato' => ['required', 'string', 'max:255'],
            'level' => ['required', 'string', 'max:255'],
            'crm_cpf' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
  
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        try {
            // Criar e retornar o usuário
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'contato' => $data['contato'],
                'level' => $data['level'],
                'crmv_cpf' => $data['crm_cpf'],
                'password' => Hash::make($data['password']),
            ]);
        } catch (QueryException $e) {
            session()->flash('mensagem-erro', 'Erro ao salvar o registro.');
            return redirect()->back()->withErrors(['Erro ao registrar o usuário.']);
        }
    }

    /**
     * Handle post-registration redirection and session message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Valida os dados
        $this->validator($request->all())->validate();

        // Cria o novo usuário
        $user = $this->create($request->all());

        // Redireciona sem fazer login
        return redirect($this->redirectPath())->with('mensagem-sucesso', 'Usuário registrado com sucesso.');
    }
}
