<?php

namespace App\Http\Controllers;

use App\Models\Redaktur;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RedakturController extends Controller
{
    public function index(Request $request)
    {
        $data = Redaktur::when($request->sort_by, function ($query, $value) {
                $query->orderBy($value, request('order_by', 'asc'));
            })
            ->when(!isset($request->sort_by), function ($query) {
                $query->latest();
            })
            ->when($request->search, function ($query, $value) {
                $query->where('redakturNama', 'LIKE', '%'.$value.'%');
            })
            ->paginate($request->page_size ?? 10);
        return Inertia::render('redaktur/index', [
            'items' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'redakturNama' => 'required|string',
            'redakturEmail' => 'required|string',
            'redakturNomor' => 'required|string',
            'redakturAlamat' => 'required|string',
            'redakturUniv' => 'required|string',
            'redakturFakultas' => 'required|string',
            'redakturProdi' => 'required|string',
            'redakturKuliah' => 'required|string',
            'redakturMapaba' => 'required|string',
            'redakturFoto' => 'required|string',
        ]);
        Redaktur::create($data);
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Berhasil Menambah Redaktur Baru!',
        ]);
    }

    public function update(Category $category, Request $request)
    {
        $data = $this->validate($request, [
            'categoryName' => 'required|string'
        ]);
        $category->update($data);
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Berhasil Mengubah Kategori!',
        ]);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Berhasil Menghapus Kategori!',
        ]);
    }
}