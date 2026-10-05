<?php

namespace App\Http\Controllers;

use App\Models\IncomingGood;
use App\Models\Product;
use Illuminate\Http\Request;

class IncomingGoodController extends Controller
{
    public function index()
    {
        $incomingGoods = IncomingGood::with(['product', 'user'])->latest()->get();
        $products = Product::all();
        return view('incoming_goods.index', compact('incomingGoods', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'supplier'   => 'nullable|string|max:255',
            'date'       => 'required|date',
        ]);

        $validated['user_id'] = auth()->id();
        IncomingGood::create($validated);

        return redirect()->route('incoming-goods.index')->with('success', 'Data barang masuk berhasil ditambahkan!');
    }

    public function update(Request $request, IncomingGood $incomingGood)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'supplier'   => 'nullable|string|max:255',
            'date'       => 'required|date',
        ]);

        $incomingGood->update($validated);

        return redirect()->route('incoming-goods.index')->with('success', 'Data barang masuk berhasil diperbarui!');
    }

    public function destroy(IncomingGood $incomingGood)
    {
        $incomingGood->delete();
        return redirect()->route('incoming-goods.index')->with('success', 'Data berhasil dihapus!');
    }
}