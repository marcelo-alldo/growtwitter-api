<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $params = collect($request->query());
        $query = Category::query();

        if($params->get('enable') === "0"){
            $query->notEnable();
        }

        if($params->get('enable') === null || $params->get('enable') === "1"){
            $query->enable();
        }

        if($params->get('name') !== null){
            $query->findByName($params->get('name'));
        }

        if($params->get('all') === "1"){
            $query = Category::query();
        }

        $categories = $query->get();

        return response()->json(['success' => true, 'msg' => 'Lista de categorias', 'data' => $categories]);
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

            $category = Category::create($request->all());

            return response()->json(['success'=> true, 'msg' => 'Categoria criada com sucesso.', 'data'=> $category]);

        } catch (\Throwable $th) {
            Log::error('Erro ao criar categoria', ['error' => $th->getMessage()]);
            return response()->json(['success'=> false, 'msg'=> "Erro ao criar categoria."], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
}
