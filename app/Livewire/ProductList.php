<?php

namespace App\Livewire;

use App\Models\Producto;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
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

        $cartItems = Cart::instance('ventas')->content();

        foreach ($cartItems as $item) {
            $this->quantity[$item->rowId] = $item->qty;
        }

        return view(
            'livewire.product-list',
            ['products' => $products, 'cartItems' => $cartItems]
        );
    }

    public function addToCart($productId)
    {
        $product = Producto::find($productId);

        if (!$product) {
            // Producto no encontrado
            session()->flash('error_message', 'Producto no encontrado.');
            return;
        }

        // Verificar si el producto está en el carrito
        $existingItem = Cart::instance('ventas')->search(function ($cartItem, $rowId) use ($productId) {
            return $cartItem->id === $productId;
        });

        // Si el producto ya está en el carrito, sumar la cantidad
        if ($existingItem->isNotEmpty()) {
            $existingItem = $existingItem->first();
            $newQuantity = $existingItem->qty + 1;

            // Verificar si la nueva cantidad supera el stock disponible
            if ($newQuantity > $product->stock) {
                session()->flash('error_message', 'No hay suficiente stock disponible.');
                return;
            }

            // Actualizar la cantidad en el carrito
            Cart::instance('ventas')->update($existingItem->rowId, ['qty' => $newQuantity]);
        } else {
            // Si el producto no está en el carrito, agregarlo
            if ($product->stock < 1) {
                session()->flash('error_message', 'No hay suficiente stock disponible.');
                return;
            }

            Cart::instance('ventas')->add([
                'id' => $product->id,
                'name' => $product->producto,
                'price' => $product->precio_venta,
                'qty' => 1
            ]);
        }

        session()->flash('success_message', 'Producto agregado al carrito.');
    }



    public function updateQuantity($rowId)
    {
        $newQuantity = $this->quantity[$rowId];
        $cartItem = Cart::instance('ventas')->get($rowId);

        if (!$cartItem) {
            session()->flash('error_message', 'No se encontró el producto en el carrito.');
            return;
        }

        $product = Producto::find($cartItem->id);

        // Verificar si la nueva cantidad supera el stock disponible
        if ($newQuantity > $product->stock) {
            session()->flash('error_message', 'No hay suficiente stock disponible.');
            return;
        }

        Cart::instance('ventas')->update($rowId, ['qty' => $newQuantity]);
        session()->flash('success_message', 'Cantidad actualizada en el carrito.');
    }


    public function removeFromCart($rowId)
    {
        Cart::instance('ventas')->remove($rowId);
        session()->flash('success_message', 'Producto eliminado del carrito.');
    }
}
