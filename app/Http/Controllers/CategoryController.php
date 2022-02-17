<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $data = Category::when($request->sort_by, function ($query, $value) {
                $query->orderBy($value, request('order_by', 'asc'));
            })
            ->when(!isset($request->sort_by), function ($query) {
                $query->latest();
            })
            ->when($request->search, function ($query, $value) {
                $query->where('categoryName', 'LIKE', '%'.$value.'%');
            })
            ->paginate($request->page_size ?? 10);
        return Inertia::render('category/index', [
            'items' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'categoryName' => 'required|string',
        ]);
        Category::create($data);
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Berhasil Menambah Kategori Baru!',
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