<?php

namespace App\Http\Controllers\TodoApp;

use App\Http\Controllers\Controller;
use App\Models\TodoApp\TodoAppModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $novoAfazer = new TodoAppModel([
            'nome' => $request->afazer,
            'user_id' => Auth::id(),

        ]);
        $novoAfazer->save();

        return true;
    }

    public function getAfazeres()
    {
        $afazeres = TodoAppModel::orderby('created_at', 'desc')
        ->where('user_id', Auth::id())
        ->get();
        if ($afazeres) {
            return $afazeres;
        } else {
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

    public function delete(Request $request)
    {
        $deletarAfazer = TodoAppModel::find($request->afazer);
        if ($deletarAfazer) {
            $deletarAfazer->delete();
            return true;
        } else {
            return false;
        }
    }
}
