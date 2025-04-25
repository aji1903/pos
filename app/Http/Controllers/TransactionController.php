<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Orders;

use App\Models\Orders_Details;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexsale()
    {
        return view('pos.edit');
    }


    public function index()
    {
        $title = 'Order';
        // select * from products LEFT JOIN categories ON categories.id = products.category_id
        // ORM = Object Relation Mapp
        $datas = Orders::orderBy('id', 'desc')->get();

        return view('pos.index', compact('title', 'datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // select * from categories order by id desc
        $categories = Categories::orderBy('id', 'desc')->get();
        return view('pos.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // categories.store untuk insert data
    public function store(Request $request)
    {
        // ORD-100425001
        // return $request->qty;
        $qOrderCode = Orders::max('id');
        $qOrderCode++;
        $orderCode = 'ORD-' . date("dmY") . sprintf("%03d", $qOrderCode);
        $data = [
            'order_code' => $orderCode,
            'order_date' => date("Y-m-d"),
            'order_amount' => $request->grandtotal,
            'order_change' => 1,
            'order_status' => 1,
        ];
        $order = Orders::create($data);

        $qty = $request->qty;
        foreach ($qty as $key => $data) {
            Orders_Details::create([
                'order_id' => $order->id,
                'product_id' => $request->product_id[$key],
                'qty' => $request->qty[$key],
                'order_price' => $request->order_price[$key],
                'order_subtotal' => $request->order_subtotal[$key],
            ]);
        }
        // hasFile
        // !empty()
        // $_FILES, $request->file

        Alert::success('Success', 'Add Pos Product Successfully');

        return redirect()->to('pos')->with('success', 'Tambah Pos Produk Berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $orders = Orders::findOrFail($id);
        $orderDetails = Orders_Details::with('product')->where('order_id', $id)->get();
        $title =   "Order Details Of = " . $orders->order_code;
        return view('pos.show', compact('orders', 'orderDetails', 'title'));
    }
    public function print($id)
    {
        $orders = Orders::findOrFail($id);
        $orderDetails = Orders_Details::with('product')->where('order_id', $id)->get();

        return view('pos.print-struk', compact('orders', 'orderDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // fungsi edit ini sama dengan seperti select * from categories order by id desc
        // jadi function ini berfungsi untuk menampilkan data saja bukan untuk update data okeee!!!!!
        $edit = Products::findorfail($id);
        $categories = Categories::orderBy('id', 'desc')->get();
        return view('product.edit', compact('edit', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // cara 1 update
        // Categories::where('id',$id)->update([
        //     'category_name' => $request->category_name,
        // ]);
        // cara 2 update
        $data = [
            'category_id' => $request->category_id,
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'product_description' => $request->product_description,
            'is_active' => $request->is_active
        ];
        $product = Products::find($id);
        if ($request->hasFile('product_photo')) {
            // jika gambar sudah ada dan mau diubah maka gambar lama kita hapus di ganti oleh gambar baru
            if ($product->product_photo) {
                file::delete(public_path('storage/' . $product->photo));
            }
            $photo = $request->file('product_photo')->store('product', 'public');
            $data['product_photo'] = $photo;
        }
        $product->update($data);
        Alert::success('Success', 'Update Product Successfully');
        return redirect()->to('product')->with('update', 'Update Data Berhasil');
        // return redirect()->to('product')->with('update', 'Update Data Berhasil');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // cara 1 delete
        $product = Products::find($id);
        Products::where('id', $id)->delete();
        File::delete(public_path('storage/' . $product->product_photo));
        $product->delete();
        // cara 2 delete
        Alert::success('Success', 'Delete Product Successfully');
        return redirect()->to('product');

        // return redirect()->to('product')->with('success', 'Data Berhasil Dihapus');
    }
    public function getProduct($category_id)
    {
        $product = Products::where('category_id', $category_id)->get();
        $response = ['status' => 'success', 'message' => 'Fetch Product Success', 'data' => $product];
        return response()->json($response, 200);
    }
}
