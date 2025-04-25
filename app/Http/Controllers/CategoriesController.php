<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Data Category';
        $datas = categories::get();
        return view('categories.index', compact('title', 'datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // categories.store untuk insert data
    public function store(Request $request)
    {
        Categories::create([
            'category_name' => $request->category_name,
        ]);
        return redirect()->to('categories');
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
        $edit = Categories::findorfail($id);
        return view('categories.edit', compact('edit'));
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

        $category = Categories::find($id);
        $category->category_name = $request->category_name;
        $category->save();
        return redirect()->to('categories');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // cara 1 delete
        // Categories::where('id', $id)->delete();


        // cara 2 delete
        $category = Categories::find($id);
        $category->delete();

        return redirect()->to('categories')->with('success', 'Data Berhasil Dihapus');
    }
}
