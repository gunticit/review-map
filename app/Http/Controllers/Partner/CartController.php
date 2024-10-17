<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->first();
        if (!$cart) {
            $cart = Cart::create(['user_id' => $user->id]);
        }

        $cart->load('products.images');
        $total = 0;
        if ($cart->products->count() > 0) {
            $cart->products->each(function ($product) use (&$total) {
                $subtotal = $product->price * $product->pivot->quantity;
                $total += $subtotal;

                $productDate = date('Y-m', strtotime($product->created_at));
                $productCode = $product->product_code;
                $productLinkImage = $product->images->first()->link_image;

                $product->price_formatted = $this->formatCurrencyVND($product->price);
                $product->subtotal_formatted = $this->formatCurrencyVND($subtotal);
                $product->image = "storage/app/public/uploads/quantri/uploads/products/{$productDate}/{$productCode}/{$productLinkImage}"; 
            });
        }
        $cart->total = $total;
        $cart->total_formatted = $this->formatCurrencyVND($total);

        $voucher_applied = session('voucher_applied');

        if ($voucher_applied) {
            $voucher = Voucher::find($voucher_applied);
            if ($voucher) {
                $discount = 0;
                if ($voucher->discount_type == 'percent') {
                    $discount = $total * $voucher->discount_value / 100;
                }
                if ($voucher->discount_type == 'fixed') {
                    $discount = $voucher->discount_value;
                }
                $cart->discount = $discount;
                $cart->total = $total - $discount;
                $cart->discount_formatted = $this->formatCurrencyVND($discount);
                $cart->total_formatted = $this->formatCurrencyVND($cart->total);
            }
        }

        $wallet = Wallet::where('user_id', $user->id)->first();
        $wallet->balance_formatted = $this->formatCurrencyVND($wallet->balance);
        return view('pages.partner.cart.index', compact('cart', 'wallet', 'user'));
    }

    public function updateQuantity(Request $request)
    {
        try {
            DB::beginTransaction();
            $cart = Cart::where('user_id', Auth::user()->id)->first();
            $product = Product::findOrFail($request->id);
            if ($request->action == 'increase') {
                $currentQuantity = $cart->products()->where('product_id', $product->id)->first()->pivot->quantity ?? 0;
                $newQuantity = $currentQuantity + $request->quantity;
                $cart->products()->updateExistingPivot($product->id, ['quantity' => $newQuantity]);
            } else {
                $currentQuantity = $cart->products()->where('product_id', $product->id)->first()->pivot->quantity ?? 0;
                $newQuantity = $currentQuantity - $request->quantity;
                if ($newQuantity < 1) {
                    $cart->products()->detach($product);
                } else {
                    $cart->products()->updateExistingPivot($product->id, ['quantity' => $newQuantity]);
                }
            }
            DB::commit();
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Có lỗi xảy ra']);
        }
    }

    public function deleteItem(Request $request)
    {
        try {
            DB::beginTransaction();
            $cart = Cart::where('user_id', Auth::user()->id)->first();
            $product = Product::findOrFail($request->id);
            $cart->products()->detach($product);
            DB::commit();
            return redirect()->back();
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Có lỗi xảy ra']);
        }
    }

    public function applyVoucher(Request $request)
    {
        $voucher = Voucher::where('code', $request->voucher)->first();
        
        if (!$voucher) {
            return redirect()->back()->withErrors(['error_voucher' => "Mã giảm giá không hợp lệ"]);
        }

        if ($voucher->status != 'active') {
            return redirect()->back()->withErrors(['error_voucher' => "Mã giảm giá không hợp lệ"]);
        }

        if ($voucher->start_date > now() || $voucher->end_date < now()) {
            return redirect()->back()->withErrors(['error_voucher' => "Mã giảm giá không hợp lệ"]);
        }

        if ($voucher->uses_left >= $voucher->max_uses) {
            return redirect()->back()->withErrors(['error_voucher' => "Mã giảm giá đã hết lượt sử dụng"]);
        }

        if ($voucher->min_order_value > $request->total) {
            return redirect()->back()->withErrors(['error_voucher' => "Tổng giá trị đơn hàng phải lớn hơn {$this->formatCurrencyVND($voucher->min_order_value)}"]);
        }

        return redirect()->route('cart.index')->withInput()->with('voucher_applied', $voucher->id);
    }

    private function formatCurrencyVND($number)
    {
        return number_format($number, 0, ',', '.') . ' VND';
    }
}
