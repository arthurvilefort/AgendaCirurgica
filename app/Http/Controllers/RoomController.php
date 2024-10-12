<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;
use App\Models\User;
use App\Models\Room;
use App\Models\Surgery_types;
use App\Models\Surgerie;
use Illuminate\Database\QueryException;


class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $salas = Room::where('hospital_id', '=', $id)->get();
        $hospital = Hospital::where('id', '=', $id)->first();
        $tipocirurgias = Surgery_types::all();
        $cirurgias = Surgerie::where('hospital_id', $id)->get();
        
        //dd($cirurgias);
        return view('sala', compact('salas', 'hospital', 'tipocirurgias','cirurgias'));
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
            'hospital_id' => 'required|exists:hospitals,id',  // Certifique-se de validar o hospital_id
        ]);

        try {
            Room::create([
                'sala_nome' => $validatedData['nome'],
                'hospital_id' => $validatedData['hospital_id'],
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
    public function update(Room $sala)
    {
        $messages = [
            'nome.required' => 'O campo nome é obrigatório.',
            'hospital.required' => 'O campo endereço é obrigatório.',
        ];

        $this->validate(request(), [
            'nome' => 'required',
            'hospital' => 'required',
        ], $messages);

        $sala->sala_nome = request('nome');
        $sala->hospital_id = request('hospital');
        try {
            $sala->save();
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
    public function destroy(Room $Sala)
    {
        try {
            $Sala->delete();
            session()->flash('mensagem-sucesso', 'Hospital excluído com sucesso.');
        } catch (QueryException $e) {
            session()->flash('mensagem-erro', 'Erro ao excluir o hospital.');
            return redirect()->back();
        }

        return redirect()->back();
    }

    public function addRestrictions(Request $request, Room $sala)
    {
        try {
            // Adiciona a restrição (tipo de cirurgia) à sala
            $sala->tipocirurgias()->attach($request->tipocirurgia_id, [
                'created_at' => now(),
                'updated_at' => now()
            ]);
            session()->flash('mensagem-sucesso', 'Restrição adicionada à sala com sucesso.');
        } catch (QueryException $e) {
            session()->flash('mensagem-erro', 'Erro ao adicionar a restrição à sala.');
            return redirect()->back();
        }

        return redirect()->back();
    }

    // Remove restrição
    public function removeRestrictions(Request $request, Room $sala, Surgery_types $tipocirurgia)
    {
        try {
            $sala->tipocirurgias()->detach($tipocirurgia->id);
            session()->flash('mensagem-sucesso', 'Restrição removida da sala com sucesso.');
        } catch (QueryException $e) {
            session()->flash('mensagem-erro', 'Erro ao remover a restrição da sala.');
            return redirect()->back();
        }

        return redirect()->back();
    }


}
