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
                $query->where('redakturNama', 'LIKE', '%' . $value . '%');
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
            'redakturEmail' => 'required|email',
            'redakturNomor' => 'required|string',
            'redakturAlamat' => 'required|string',
            'redakturUniv' => 'required|string',
            'redakturFakultas' => 'required|string',
            'redakturProdi' => 'required|string',
            'redakturKuliah' => 'required|integer',
            'redakturMapaba' => 'required|integer',
            'redakturFoto' => 'required|file',
        ]);
        Redaktur::create($data);
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Berhasil Menambah Redaktur Baru !',
        ]);
    }

    public function update(Redaktur $redaktur, Request $request)
    {
        $data = $this->validate($request, [
            'redakturNama' => 'required|string',
            'redakturEmail' => 'required|email',
            'redakturNomor' => 'required|string',
            'redakturAlamat' => 'required|string',
            'redakturUniv' => 'required|string',
            'redakturFakultas' => 'required|string',
            'redakturProdi' => 'required|string',
            'redakturKuliah' => 'required|integer',
            'redakturMapaba' => 'required|integer',
            'redakturFoto' => 'required|file',
        ]);
        $redaktur->update($data);
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Berhasil Mengubah Redaktur !',
        ]);
    }

    public function destroy(Redaktur $redaktur)
    {
        $redaktur->delete();
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Berhasil Menghapus Redaktur !',
        ]);
    }
}