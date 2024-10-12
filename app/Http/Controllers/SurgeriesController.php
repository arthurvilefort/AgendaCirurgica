<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;
use App\Models\Room;
use App\Models\Surgery_types;
use App\Models\Pacient;
use App\Models\Surgerie;

class SurgeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hospitals = Hospital::orderBy('nome')->get();
        $salas = Room::orderBy('sala_nome')->get();
        $surgeryTypes = Surgery_types::orderBy('nome')->get();
        $pacients = Pacient::orderBy('nome')->get();

        return view('agendamentos', compact('hospitals', 'salas', 'surgeryTypes', 'pacients'));
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
        // Concatenar a data com os horários para realizar a validação corretamente
        $dataCompletaInicio = $request->data . ' ' . $request->data_inicio;
        $dataCompletaFim = $request->data . ' ' . $request->data_fim;

        // Validação
        $request->validate([
            'hospital_id' => 'required',
            'sala_id' => 'required',
            'tipo_cirurgia_id' => 'required',
            'paciente_id' => 'required',
            'data' => 'required|date',
            'data_inicio' => 'required',
            'data_fim' => 'required|after:data_inicio',
        ]);

        try {
            // Criar a cirurgia
            Surgerie::create([
                'hospital_id' => $request->hospital_id,
                'sala_id' => $request->sala_id,
                'tipo_cirurgia_id' => $request->tipo_cirurgia_id,
                'paciente_id' => $request->paciente_id,
                'data' => $request->data,
                'data_inicio' => $request->data_inicio,
                'data_fim' => $request->data_fim,
                'status' => 'agendada', // Definir status inicial
            ]);
            session()->flash('mensagem-sucesso', 'Cirurgia Cadastrada com sucesso!');
            return redirect()->back()->with('success', 'Cirurgia agendada com sucesso.');
        } catch (\Exception $e) {
            session()->flash('mensagem-erro', 'Erro ao salvar o registro.');
            return redirect()->back()->with('error', 'Erro ao agendar a cirurgia: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getSalas($hospital_id)
    {
        $salas = Room::where('hospital_id', $hospital_id)->get();
        return response()->json($salas);
    }
}
