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
    public $cart_info;
    public function __construct($cart_info = null)
    {
        $this->cart_info = $cart_info;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cart-component');
    }
}
