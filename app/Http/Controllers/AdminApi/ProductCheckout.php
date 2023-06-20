<?php

namespace App\Http\Controllers\AdminApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Resources\ProductCheckout as Checkout;
use App\Models\Orders;
use Illuminate\Support\Facades\Validator;

class ProductCheckout extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = Orders::all();
        $arr = [
            'status' => true,
            'message' => "Danh sách giỏ hàng",
            'data' => Checkout::collection($orders)
        ];
        return response()->json($arr, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = array();
        $data['user_id'] = $request->user_id;
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data['note'] = $request->note;
        $data['total'] = $request->total;
        $data['status'] = 1;
        $data['created_at'] = now();
        $data['updated_at'] = now();
        $orderId = DB::table('orders')->insertGetId($data);

        //order_details
        $product = Cart::content();
        foreach ($product as $product) {
            $data = array();
            $data['order_id'] = $orderId;
            $data['product_id'] = $product->id;
            $data['name'] = $product->name;
            $data['price'] = $product->price;
            $data['qty'] = $product->qty;
            $data['created_at'] = now();
            $data['updated_at'] = now();
            DB::table('orders_details')->insert($data);
        }
        Cart::destroy();
        $arr = [
            'status' => true,
            'message' => "Giỏ hàng đã thêm thành công",
            'data' => new Checkout($orderId)
        ];
        return response()->json($arr, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Orders::find($id);
        $order->delete();
        $arr = [
            'status' => true,
            'message' => 'Giỏ hàng đã được xóa',
            'data' => [],
        ];
        return response()->json($arr, 200);
    }
}
