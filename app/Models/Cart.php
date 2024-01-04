<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class Cart extends Model
{
	use HasFactory;

    public function getCartData(){
        $cart = \Session::get('cart');
        $cartCount = 0;
        $cartTotal = 0;
        $cartHtml = '';
        $removedItems = false;
        if(isset($cart['items'])){
            $productModel = new Product();
            foreach($cart['items'] as $key => $c){
                $product = $productModel->getProductShort($c['id'],$c['priceId']);
                if ($product) {
                    $cartHtml .= view('app.blocks.cart_item_html', ['product' => $product, 'qty' => $c['qty']])->render();
                    $cartCount += $c['qty'];
                    $cartTotal += $product->effective_price * $c['qty'];
                }
                else {
                    unset($cart['items'][$key]);
                    $removedItems = true;
                }
            }
        }

        if ($removedItems) {
            $cart['items'] = array_values($cart['items']);
            \Session::put('cart', $cart);
        }

        $cartTotal = number_format($cartTotal,2);
        $cartData = ['count'=>$cartCount,'total'=>$cartTotal,'html'=>$cartHtml];
        return $cartData;
    }
}
