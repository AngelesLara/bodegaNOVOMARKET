<?php

namespace App\Livewire;

use App\Models\Producto;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;
use Livewire\WithPagination;

class ProductCompra extends Component
{

    use WithPagination;

	protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $perPage = 12;
    public $quantity = [];

    public function render()
    {
        $products = Producto::where('producto', 'like', '%' . $this->search . '%')
        ->orderBy('id', 'desc')    
        ->paginate($this->perPage);

        $cartItems = Cart::instance('compras')->content();

        foreach ($cartItems as $item) {
            // Inicializar la cantidad para cada elemento del carrito
            $this->quantity[$item->rowId] = $item->qty;
        }

        return view('livewire.product-compra', ['products' => $products, 'cartItems' => $cartItems]);
    }

    public function addToCart($productId)
    {
        $product = Producto::find($productId);

        Cart::instance('compras')->add([
            'id' => $product->id,
            'name' => $product->producto,
            'price' => $product->precio_compra,
            'qty' => 1
        ]);

        session()->flash('success_message', 'Producto agregado al carrito.');
    }

    public function updateQuantity($rowId)
    {
        $newCant = $this->quantity[$rowId];
        Cart::instance('compras')->update($rowId, ['qty' => $newCant]);
    }

    public function removeFromCart($rowId)
    {
        Cart::instance('compras')->remove($rowId);
        session()->flash('success_message', 'Producto eliminado del carrito.');
    }
}
