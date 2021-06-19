<?php

namespace App\Http\Controllers\ShoppingCartApp;

use App\Http\Controllers\Controller;
use App\Models\ShoppingCart\Carrinho;
use App\Models\ShoppingCart\ProdutoSc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ShoppingCartController extends Controller
{

    ////////////////index///////////////////////////////////////
    public function index()
    {
        return Inertia::render('ShoppingCartApp/Index/LayoutShoppingCart');
    }

    public function getprodutos()
    {
        return ProdutoSc::orderby('created_at', 'asc')->get();
    }

    /////////////////////////////// CRIAR INVENTARIO ////////////////

    public function criariventario()
    {
        return Inertia::render('ShoppingCartApp/CriarInventario/CriarInventario');
    }

    public function store(Request $request)
    {
        if ($request) {
            $produto = new ProdutoSc([
                'user_id' => Auth::id(),
                'nome' => $request->nome,
                'descricao' => $request->descricao,
                'quantidade' => $request->quantidade,
                'preco' => $request->preco,
            ]);
            $produto->save();
            return true;
        }
        return false;
    }

    public function update(Request $request)
    {
        if ($request) {
            $updateproduto = ProdutoSc::find($request->id);
            if ($updateproduto) {
                $updateproduto->nome = $request->nome;
                $updateproduto->descricao = $request->descricao;
                $updateproduto->preco = $request->preco;
                $updateproduto->quantidade = $request->quantidade;
                $updateproduto->update();
                return 'produto editado com sucesso';
            }
            return 'Erro ao encontrar produto';
        }
        return 'erro';
    }

    public function apagar(Request $request)
    {
        return ProdutoSc::find($request->id)->delete();
    }

    /////////////////////////// Carinho ////////////////////////////////

    public function getcarrinho()
    {
        return inertia::render('ShoppingCartApp/Shopping/LayoutCarrinho');
    }

    public function removercarrinho(Request $request)
    {
        if ($request) {
            $car = Carrinho::find($request->id);
            if ($car) {
                $car->quantidade = 0;
                $car->update();
                return 'removido do carrinho com sucesso';
            }
            return 'erro ao encontrar produto no carrinho';
        }
        return 'erro';
    }

    public function carrinho(Request $request)
    { //Adicionar produtos no carrinho
        if ($request) {

            $request->validate([
                'produto' => 'required',
                'quantidade' => 'required',
            ]);

            $upproduto = Carrinho::where('produto_id', $request->produto)
                ->where('user_id', Auth::id())->get();

            $prodteste = ProdutoSc::find($request->produto);

            if ($upproduto) {
                for ($i = 0; $i < count($upproduto); $i++) {
                    $upproduto[$i]->quantidade = $upproduto[$i]->quantidade + $request->quantidade;
                    $upproduto[$i]->pago = false;
                    if ($upproduto[$i]->quantidade > $prodteste->quantidade) {
                        return 'erro - Exedida quantidade em estoque';
                    }
                    $upproduto[$i]->update();
                    return 'produto salvo no carrinho com sucesso';
                }

            }
            if ($request->quantidade > $prodteste->quantidade) {
                return 'erro - Quantidade excedida';
            }
            $car = new Carrinho([
                'user_id' => Auth::id(),
                'produto_id' => $request->produto,
                'quantidade' => $request->quantidade,
            ]);
            $car->save();
            return 'produto salvo com sucesso';

        }
        return 'erro ao salvar';
    }

    public function getprodutoscarrinho()
    {

        $prodcarrinho = Carrinho::join('produto_scs', 'produto_scs.id', 'carrinhos.produto_id')
            ->orderby('carrinhos.created_at', 'desc')->get(['produto_scs.*', 'carrinhos.id', 'carrinhos.quantidade', 'carrinhos.pago']);

        for ($i = 0; $i < count($prodcarrinho); $i++) {
            $prodcarrinho[$i]->valor = $prodcarrinho[$i]->preco * $prodcarrinho[$i]->quantidade;
        }

        return $prodcarrinho;
    }

    public function pagamento(Request $request)
    {
        $car = Carrinho::find($request->id);
        $prod = ProdutoSc::find($car->produto_id);

        if ($car && $prod) {
            if ($car->quantidade <= $prod->quantidade) {
                $car->pago = !$car->pago;
                $prod->quantidade -= $car->quantidade;
                $prod->update();
                $car->quantidade -= $car->quantidade;
                $car->update();
                return 'Produto Comprado com sucesso';
            }
            return 'Quantidade requisitada não existe em estoque';
        }
        return 'Erro';
    }
}
