<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $params = collect($request->query());
        $query = Person::query();

        if($params->get('received') === "1") {
            $query->received(1);
        }

        Log::info(Auth::user());

        if($params->get('received') === "0") {
            $query->received(0);
        }

        $people = $query->get();

        return response()->json(["success" => true, "msg" => "Lista de pessoas.", "data" => $people ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required'
            ]);

            $person = Person::create($request->all());

            return response()->json(['success' => true, 'msg' => 'Pessoa cadastrada com sucesso.', 'data' => $person ]);

        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'msg' => 'Erro ao cadastrar pessoa.', 'data' => $person ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Person $person)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $person = Person::find($id);

        $data = $request->all();

        if($person == null){
            return response()->json(['success' => false, "msg" => "Pessoa não encontrada."], 400);
        }


        if(!count($data)){
            $person->received = 1;
        } else {
            $person->city = $request->city;
        }

        $person->save();

        return response()->json(["success" => true, "msg" => "Pessoa atualizada com sucesso."]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Person $person)
    {
        //
    }
}
