<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $data = Tag::when($request->sort_by, function ($query, $value) {
                $query->orderBy($value, request('order_by', 'asc'));
            })
            ->when(!isset($request->sort_by), function ($query) {
                $query->latest();
            })
            ->when($request->search, function ($query, $value) {
                $query->where('tagName', 'LIKE', '%'.$value.'%');
            })
            ->paginate($request->page_size ?? 10);
        return Inertia::render('tag/index', [
            'items' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'tagName' => 'required|string',
        ]);
        Tag::create($data);
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Berhasil Menambah Tag Baru!',
        ]);
    }

    public function update(Tag $tag, Request $request)
    {
        $data = $this->validate($request, [
            'tagName' => 'required|string'
        ]);
        $tag->update($data);
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Berhasil Mengubah Tag!',
        ]);
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Berhasil Menghapus Tag!',
        ]);
    }
}