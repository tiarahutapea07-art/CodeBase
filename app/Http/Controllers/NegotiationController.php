<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Negotiation;
use App\Models\Product;

class NegotiationController extends Controller
{
    //
    // Daftar: tawaran saya (pembeli) + tawaran masuk (penjual)
    public function index()
    {
        $myOffers = Negotiation::with('product')
            ->where('buyer_id', auth()->id())->latest()->get();

        $incoming = Negotiation::with(['product', 'buyer'])
            ->whereHas('product', fn ($q) => $q->where('user_id', auth()->id()))
            ->latest()->get();

        return view('negotiations.index', compact('myOffers', 'incoming'));
    }

    public function store(Request $request, Product $product)
    {
        abort_if($product->user_id === auth()->id(), 403, 'Tidak bisa menawar barang sendiri.');

        $data = $request->validate([
            'offered_price' => "required|integer|min:1|lt:{$product->price}",
            'message'       => 'nullable|string|max:255',
        ], [
            'offered_price.lt' => 'Harga tawaran harus lebih rendah dari harga barang.',
        ]);

        if (Negotiation::where('product_id', $product->id)
            ->where('buyer_id', auth()->id())->where('status', 'pending')->exists()) {
            return back()->with('error', 'Tawaranmu untuk barang ini masih menunggu respon penjual.');
        }

        Negotiation::create($data + [
            'product_id' => $product->id,
            'buyer_id'   => auth()->id(),
        ]);

        return redirect()->route('negotiations.index')->with('success', 'Tawaran berhasil dikirim.');
    }

    public function update(Request $request, Negotiation $negotiation)
    {
        abort_unless($negotiation->product->user_id === auth()->id(), 403);

        $request->validate(['status' => 'required|in:accepted,rejected']);
        $negotiation->update(['status' => $request->status]);

        return back()->with('success', 'Tawaran diperbarui.');
    }
}

