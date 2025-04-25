<?php

namespace App\Http\Controllers;

use App\Models\Categories;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Data Product';
        // select * from products LEFT JOIN categories ON categories.id = products.category_id
        // ORM = Object Relation Mapp
        $datas = Products::with('category')->get();

        return view('product.index', compact('title', 'datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // select * from categories order by id desc
        $categories = Categories::orderBy('id', 'desc')->get();
        return view('product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // categories.store untuk insert data
    public function store(Request $request)
    {
        $data = [
            'category_id' => $request->category_id,
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'product_stock' => $request->product_stock,
            'product_description' => $request->product_description,
            'is_active' => $request->is_active
        ];
        // hasFile
        // !empty()
        // $_FILES, $request->file
        if ($request->hasFile('product_photo')) {
            $photo = $request->file('product_photo')->store('product', 'public');
            $data['product_photo'] = $photo;
            # code...
        }
        Products::create($data);
        Alert::success('Success', 'Add Product Successfully');

        return redirect()->to('product')->with('success', 'Tambah Produk Berhasil');
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
            'product_stock' => $request->product_stock,
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
    public function stock()
    {
        $title = 'Data Product';
        // select * from products LEFT JOIN categories ON categories.id = products.category_id
        // ORM = Object Relation Mapp
        $datas = Products::with('category')->get();

        return view('sale.stock', compact('title', 'datas'));
    }
}
