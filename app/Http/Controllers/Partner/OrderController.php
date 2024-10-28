<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\TransactionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'recipient_name' => 'required|string|max:255',
                'recipient_phone' => 'required|string|max:20',
                'shipping_address' => 'required|string|max:255',
            ], [
                'recipient_name.required' => 'Vui lòng nhập tên người nhận',
                'recipient_name.max' => 'Tên người nhận không được vượt quá 255 ký tự',
                'recipient_phone.required' => 'Vui lòng nhập số điện thoại người nhận',
                'recipient_phone.max' => 'Số điện thoại không được vượt quá 20 ký tự',
                'shipping_address.required' => 'Vui lòng nhập địa chỉ giao hàng',
                'shipping_address.max' => 'Địa chỉ giao hàng không được vượt quá 255 ký tự',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'validated' => false,
                    'message' => $validator->errors()
                ]);
            }

            $user = Auth::user()->load('wallet');
            $cart = Cart::find($request->cart_id)->with('products')->first();

            if ($user->wallet->balance < $request->total) {
                return response()->json([
                    'success' => false,
                    'validated' => true,
                    'message' => 'Số dư tài khoản không đủ'
                ]);
            }

            if ($cart->products->count() == 0) {
                return response()->json([
                    'success' => false,
                    'validated' => true,
                    'message' => 'Giỏ hàng không có sản phẩm'
                ]);
            }

            $order = Order::create([
                'user_id' => $user->id,
                'total' => $request->total,
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'recipient_phone' => $request->recipient_phone,
                'recipient_name' => $request->recipient_name,
                'payment_method' => 'credit_card',
            ]);

            if (empty($order)) {
                return response()->json([
                    'success' => false,
                    'validated' => true,
                    'message' => 'Đặt hàng thất bại'
                ]);
            }

            $outOfStock = false;
            $outOfStockProduct = null;

            $cart->products->each(function ($product) use ($order, $cart, &$outOfStock, &$outOfStockProduct) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $product->pivot->quantity,
                    'price' => $product->price,
                ]);

                if ($product->stock < $product->pivot->quantity) {
                    $outOfStock = true;
                    $outOfStockProduct = $product;
                }
                
                $product->stock -= $product->pivot->quantity;
                $product->save();

                if (empty($orderItem)) {
                    return response()->json([
                        'success' => false,
                        'validated' => true,
                        'message' => 'Đặt hàng thất bại'
                    ]);
                }

                $cart->products()->detach($product->id);
            });

            if ($outOfStock) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'validated' => true,
                    'message' => "Sản phẩm '{$outOfStockProduct->name}' không đủ số lượng trong kho"
                ]);
            }

            $cart->delete();

            $user->wallet->balance -= $request->total;
            $user->wallet->save();

            TransactionHistory::create([
                'wallet_id' => $user->wallet->id,
                'amount' => $request->total,
                'type' => 'withdraw',
                'payment_method_id' => 1,
                'status' => 'completed',
                'reference_id' => uniqid('WITHDRAW_'),
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Đặt hàng thành công'
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        
    }
}



