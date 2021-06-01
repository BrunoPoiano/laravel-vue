<?php

namespace App\Http\Controllers\TodoApp;

use App\Http\Controllers\Controller;
use App\Models\TodoApp\TodoAppModel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TodoAppController extends Controller
{
    public function index()
    {
        return Inertia::render('TodoApp/LayoutTodoApp');
    }

    public function store(Request $request)
    {

        if ($request->afazer == null) {
            return false;
        }
        $novoAfazer = new TodoAppModel();
        $novoAfazer->nome = $request->afazer;
        $novoAfazer->save();

        return true;
    }

    public function getAfazeres()
    {
        $afazeres =  TodoAppModel::orderby('created_at', 'desc')->get();
        if($afazeres){
            return  $afazeres;
        }else{
            return 'Erro';
        }
    }

    public function update(Request $request)
    {

        if ($request != null) {
            $upafazer = TodoAppModel::find($request->afazer);
            $upafazer->finalizado = !$upafazer->finalizado;
            $upafazer->save();
            return true;
        }
    }

    public function delete(Request $request){
        $deletarAfazer = TodoAppModel::find($request->afazer);
        if($deletarAfazer){
        $deletarAfazer->delete();
        return true;
        }else{
            return false;
        }
    }
}
