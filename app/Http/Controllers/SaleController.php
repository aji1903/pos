<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Orders_Details;

use RealRashid\SweetAlert\Facades\Alert;

use App\Models\Products;
use Illuminate\Http\Request;


class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::orderBy('id', 'desc')->where('is_active', 1)->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->product_name,
                    'price' => (int)$product->product_price,
                    'image' => asset('storage/' . $product->product_photo),
                    'option' => '',
                ];
            });
        return view('sale.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        // $data['Products'] = Products::orderBy('id','desc')->get()->map(function($res))
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ORD-100425001
        // return $request->qty;
        $qOrderCode = Orders::max('id');
        $qOrderCode++;
        $orderCode = 'ORD-' . date("dmY") . sprintf("%03d", $qOrderCode);

        $cartItems = json_decode($request->cart, true);

        $order = Orders::create([
            'order_code' => $orderCode,
            'order_date' => date("Y-m-d"),
            'order_amount' => $request->total,
            'payment_amount' => $request->cash,
            'order_change' => $request->change,
            'order_status' => 1,
        ]);


        // $qty = $request->qty;
        foreach ($cartItems as $item) {
            Orders_Details::create([
                'order_id' => $order->id,
                'product_id' => $item['productId'],
                'qty' => $item['qty'],
                'order_price' => $item['price'],
                'order_subtotal' => $item['qty'] * $item['price'],
            ]);
        }
        // Update Product Stok
        foreach ($cartItems as $item) {
            $product = Products::find($item['productId']);
            if ($product) {
                $product->decrement('product_stock', $item['qty']);
            }
        }
        // hasFile
        // !empty()
        // $_FILES, $request->file

        Alert::success('Success', 'Add Pos Product Successfully');

        return redirect()->to('sale')->with('success', 'Product Created');
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
        //
    }
    public function stock()
    {
        $title = 'Data Stock';
        // select * from products LEFT JOIN categories ON categories.id = products.category_id
        // ORM = Object Relation Mapp
        $datas = Products::with('category')->where('is_active', 1)->get();

        return view('stock', compact('title', 'datas'));
    }
}
