<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Level;


class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Data Level';
        $datas = Level::get();
        return view('levels.index', compact('title', 'datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('levels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Level::create([
            'level_name' => $request->level_name,
        ]);
        return redirect()->to('levels');
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
        $edit = Level::findorfail($id);
        return view('levels.edit', compact('edit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $level = Level::find($id);
        $level->level_name = $request->level_name;
        $level->save();
        return redirect()->to('levels');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $level = Level::find($id);
        $level->delete();
        return redirect()->to('levels');
    }
}
