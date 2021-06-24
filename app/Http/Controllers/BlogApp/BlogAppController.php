<?php

namespace App\Http\Controllers\BlogApp;

use App\Http\Controllers\Controller;
use App\Models\BlogApp\BlogPosts;
use App\Models\BlogApp\Secao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class BlogAppController extends Controller
{
    public function index()
    {
        return Inertia::render('BlogApp/LayoutBlogApp');
    }

    public function getSecao()
    {
        return Secao::get();
    }

    public function store(Request $request)
    {

        if ($request) {
            $request->validate([
                'file' => 'file|image|',
            ]);
            $path = null;
            if ($request->hasFile('file')) {
                $path = $request->file->store('public/BlogApp/Posts');

            }

            $newBlosPost = new BlogPosts([
                'user_id' => Auth::id(),
                'titulo' => $request->titulo,
                'secao_id' => $request->sec,
                'conteudo' => $request->conteudo,
                'tags' => $request->tags,
                'path' => $path,
            ]);
            $newBlosPost->save();
            return true;
        }
        return false;

    }

    public function getConteudo(Request $request)
    {

        if ($request) {
            if ($request->id == null) {
                $posts = BlogPosts::join('secaos', 'blog_posts.secao_id', 'secaos.id')
                    ->orderBy('blog_posts.created_at', 'desc')
                    ->get(["blog_posts.*", 'secaos.nome']);

                for ($i = 0; $i < count($posts); $i++) {
                    if ($posts[$i]->user_id == Auth::id()) {
                        $posts[$i]->deletar = true;
                    }

                }

                return $posts;
            }

            $posts = BlogPosts::join('secaos', 'blog_posts.secao_id', 'secaos.id')
                ->orderBy('blog_posts.created_at', 'desc')
                ->where('secaos.id', $request->id)
                ->get(["blog_posts.*", 'secaos.nome']);

            for ($i = 0; $i < count($posts); $i++) {
                if ($posts[$i]->user_id == Auth::id()) {
                    $posts[$i]->deletar = true;
                }
            }

            return $posts;
        }
        return false;
    }

    public function getTagsConteudo(Request $request)
    {
        $posts = BlogPosts::join('secaos', 'blog_posts.secao_id', 'secaos.id')
            ->where('blog_posts.tags', 'like', "%{$request->tag}%")
            ->get(["blog_posts.*", 'secaos.nome']);

        for ($i = 0; $i < count($posts); $i++) {
            if ($posts[$i]->user_id == Auth::id()) {
                $posts[$i]->deletar = true;
            }
        }
        return $posts;
    }

    public function delete(Request $request)
    {
        if ($request) {

            $delPost = BlogPosts::find($request->id);

            if ($delPost->path) {
                Storage::delete($delPost->path);
            }
            $delPost->delete();
            return true;
        }
        return false;
    }

    public function secao()
    {

        $s1 = new Secao();
        $s1->nome = 'Engraçado';
        $s1->save();

        $s2 = new Secao();
        $s2->nome = 'Comida';
        $s2->save();

        $s3 = new Secao();
        $s3->nome = 'Animais';
        $s3->save();

        $s4 = new Secao();
        $s4->nome = 'Incrivel';
        $s4->save();

        $s5 = new Secao();
        $s5->nome = 'Filmes e Tv';
        $s5->save();

        $s6 = new Secao();
        $s6->nome = 'HumorNegro';
        $s6->save();
    }

    ///////////////////////////////// PAGINA CODE ///////////////////////////////

    public function pagina($id)
    {
        return Inertia::render('BlogApp/Pagina/LayoutPagina')->with('id', $id);
    }

    public function getContentbyId(Request $request)
    {
        $posts = BlogPosts::join('secaos', 'blog_posts.secao_id', 'secaos.id')
            ->where('blog_posts.id', $request->id)
            ->get(["blog_posts.*", 'secaos.nome']);

        for ($i = 0; $i < count($posts); $i++) {
            if ($posts[$i]->user_id == Auth::id()) {
                $posts[$i]->deletar = true;
            }
        }

        return $posts;
    }

}
