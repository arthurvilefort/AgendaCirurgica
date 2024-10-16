<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;
use App\Models\Room;
use App\Models\Surgery_types;
use App\Models\Pacient;
use App\Models\Surgerie;
use Carbon\Carbon;  
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Auth;


class SurgeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Verifica se o usuário é admin (supondo que level 0 seja admin)
        if ($user->level == 0) {
            $hospitals = Hospital::all(); // Admin pode ver todos os hospitais
        } else {
            // Usuários normais só podem ver os hospitais aos quais estão vinculados
            $hospitals = $user->hospitals; // Assumindo que você tem o relacionamento User -> Hospitals
        }


        //$hospitals = Hospital::orderBy('nome')->get();
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
        // Validação básica
        $request->validate([
            'hospital_id' => 'required',
            'sala_id' => 'required',
            'tipo_cirurgia_id' => 'required',
            'paciente_id' => 'required',
            'data' => 'required|date',
            'data_inicio' => 'required|date_format:H:i',
            'data_fim' => 'required|date_format:H:i|after:data_inicio',
        ]);
    
        // Verificar conflitos de horário
        $dataCirurgia = Carbon::parse($request->data);
        $dataInicio = Carbon::parse($request->data . ' ' . $request->data_inicio);
        $dataFim = Carbon::parse($request->data . ' ' . $request->data_fim);
    
        $conflito = Surgerie::where('sala_id', $request->sala_id)
            ->whereDate('data', $dataCirurgia)
            ->where(function($query) use ($dataInicio, $dataFim) {
                // Verificar se há conflitos entre os horários de início e fim
                $query->where(function ($subQuery) use ($dataInicio, $dataFim) {
                    $subQuery->whereTime('data_inicio', '<', $dataFim)
                        ->whereTime('data_fim', '>', $dataInicio);
                });
            })
            ->exists();
    
        if ($conflito) {
            session()->flash('mensagem-erro', 'Já existe uma cirurgia agendada nesse horário.');
            return back()->with('error', 'Já existe uma cirurgia agendada nesse horário.');
        }
    
        // Se não houver conflitos, prosseguir com o cadastro
        try {
            Surgerie::create([
                'hospital_id' => $request->hospital_id,
                'sala_id' => $request->sala_id,
                'tipo_cirurgia_id' => $request->tipo_cirurgia_id,
                'paciente_id' => $request->paciente_id,
                'data' => $dataCirurgia,
                'data_inicio' => $dataInicio->format('H:i'),
                'data_fim' => $dataFim->format('H:i'),
                'status' => 'agendada', // Status inicial
            ]);
            session()->flash('mensagem-sucesso', 'Cirurgia agendada com sucesso.');
            return redirect()->back()->with('success', 'Cirurgia agendada com sucesso.');
        } catch (\Exception $e) {
            session()->flash('mensagem-erro', 'Erro ao agendar a cirurgia.');
            return back()->with('error', 'Erro ao agendar a cirurgia: ' . $e->getMessage());
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

    public function getTiposCirurgia($salaId)
    {
        // Obter a sala pelo ID
        $sala = Room::find($salaId);

        if (!$sala) {
            return response()->json([], 404); // Retorna erro se a sala não for encontrada
        }

        // Buscar tipos de cirurgia que NÃO estão nas restrições
        $tiposCirurgiaPermitidos = Surgery_types::whereDoesntHave('rooms', function ($query) use ($salaId) {
            $query->where('room_id', $salaId);
        })->get();

        return response()->json($tiposCirurgiaPermitidos);
    }

    public function exportSurgeries()
    {
        // Obtenha todas as cirurgias com seus relacionamentos
        $cirurgias = Surgerie::with(['tipoCirurgia', 'sala', 'hospital', 'pacient'])->get();
        //dd($cirurgias->first()->pacient);

        // Mapeie as cirurgias para exibir os nomes em vez dos IDs
        $dadosFormatados = $cirurgias->map(function ($cirurgia) {
            return [
                'cirurgia_id' => $cirurgia->cirurgia_id,
                'data' => Carbon::parse($cirurgia->data)->format('d/m/Y'), // Converte e formata a data
                'data_inicio' => $cirurgia->data_inicio,
                'data_fim' => $cirurgia->data_fim,
                'tipo_cirurgia' => $cirurgia->tipoCirurgia->nome ?? 'N/A', // Nome do tipo de cirurgia
                'sala' => $cirurgia->sala->sala_nome ?? 'N/A', // Nome da sala
                'hospital' => $cirurgia->hospital->nome ?? 'N/A', // Nome do hospital
                'paciente' => $cirurgia->pacient->nome ?? 'N/A', // Nome do paciente
                //'status' => $cirurgia->status,
                'Criado em' => Carbon::parse($cirurgia->created_at)->format('d/m/Y'), // Converte e formata a data
                'Atualizado em' => Carbon::parse($cirurgia->updated_at)->format('d/m/Y'), // Converte e formata a data
            ];
        });
    
        // Exporte os dados formatados para Excel
        return (new FastExcel($dadosFormatados))->download('cirurgias.xlsx');
    }
    
}
