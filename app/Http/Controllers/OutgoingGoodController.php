<?php

namespace App\Http\Controllers;

use App\Models\OutgoingGood;
use App\Models\Product;
use Illuminate\Http\Request;

class OutgoingGoodController extends Controller
{
    public function index()
    {
        $outgoingGoods = OutgoingGood::with(['product', 'user'])->latest()->get();
        $products = Product::all();
        return view('outgoing_goods.index', compact('outgoingGoods', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'  => 'required|exists:products,id',
            'quantity'    => 'required|integer|min:1',
            'destination' => 'nullable|string|max:255',
            'date'        => 'required|date',
        ]);

        $validated['user_id'] = auth()->id();
        OutgoingGood::create($validated);

        return redirect()->route('outgoing-goods.index')->with('success', 'Data barang keluar berhasil ditambahkan!');
    }

    public function update(Request $request, OutgoingGood $outgoingGood)
    {
        $validated = $request->validate([
            'product_id'  => 'required|exists:products,id',
            'quantity'    => 'required|integer|min:1',
            'destination' => 'nullable|string|max:255',
            'date'        => 'required|date',
        ]);

        $outgoingGood->update($validated);

        return redirect()->route('outgoing-goods.index')->with('success', 'Data barang keluar berhasil diperbarui!');
    }

    public function destroy(OutgoingGood $outgoingGood)
    {
        $outgoingGood->delete();
        return redirect()->route('outgoing-goods.index')->with('success', 'Data berhasil dihapus!');
    }
}