<?php

namespace App\Http\Controllers;

use App\Models\Redaktur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        // ddd(time() . "." . $request->redakturFoto->extension());
        $data = $this->validate($request, [
            'redakturNama' => 'required|string',
            'redakturEmail' => 'required|email',
            'redakturNomor' => 'required|numeric',
            'redakturAlamat' => 'required|string',
            'redakturUniv' => 'required|string',
            'redakturFakultas' => 'required|string',
            'redakturProdi' => 'required|string',
            'redakturKuliah' => 'required|integer',
            'redakturMapaba' => 'required|integer',
            'redakturFoto' => 'image|nullable|file|max:2000',
        ]);
        $file = $request->file('redakturFoto');
        if ($file) {
            $filename = time() . "." . $file->extension();
            $file->storeAs('redaktur', $filename);
            $data['redakturFoto'] = $filename;
        } else {
            $data['redakturFoto'] = 'default.jpg';
        }
        Redaktur::create($data);
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Berhasil Menambah Redaktur Baru !',
        ]);
    }

    public function update(Redaktur $redaktur, Request $request)
    {
        ddd($request);
        $data = $this->validate($request, [
            'redakturNama' => 'required|string',
            'redakturEmail' => 'required|email',
            'redakturNomor' => 'required|numeric',
            'redakturAlamat' => 'required|string',
            'redakturUniv' => 'required|string',
            'redakturFakultas' => 'required|string',
            'redakturProdi' => 'required|string',
            'redakturKuliah' => 'required|integer',
            'redakturMapaba' => 'required|integer',
            'redakturFoto' => 'image|nullable|file|max:2000',
        ]);
        $file = $request->file('redakturFoto');
        if ($file) {
            if (!$redaktur->redakturFoto == "default.png") {
                Storage::delete('redaktur/' . $redaktur->redakturFoto);
            }
            $filename = time() . "." . $file->extension();
            $file->storeAs('redaktur', $filename);
            $data['redakturFoto'] = $filename;
        } else {
            $data['redakturFoto'] = $redaktur->redakturFoto;
        }
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