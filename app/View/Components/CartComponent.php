<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CartComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public $listProduct, $totalItem, $totalPrice;
    public function __construct($listProduct = [], $totalItem = 0, $totalPrice = 0)
    {
        $this->listProduct = $listProduct;
        $this->totalItem = $totalItem;
        $this->totalPrice = $totalPrice;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cart-component');
    }
}
