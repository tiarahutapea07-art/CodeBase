<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Negotiation;
use App\Models\Product;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\DB;

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
    // Pembeli tidak boleh menawar barang sendiri
    abort_if(
        $product->user_id == auth()->id(),
        403,
        'Tidak bisa menawar barang sendiri.'
    );

    // Validasi harga penawaran
    $data = $request->validate([
        'offered_price' => "required|integer|min:1|lt:{$product->price}",
    ], [
        'offered_price.integer' => 'Harga penawaran harus berupa angka bulat tanpa titik atau koma.',
        'offered_price.lt' => 'Harga tawaran harus lebih rendah dari harga barang.',
    ]);

    $buyerId = auth()->id();
    $sellerId = $product->user_id;
    $offeredPrice = (int) $data['offered_price'];

    // Cegah penawaran pending ganda
    if (Negotiation::where('product_id', $product->id)
        ->where('buyer_id', $buyerId)
        ->where('status', 'pending')
        ->exists()) {

        return back()->with(
            'error',
            'Tawaranmu untuk barang ini masih menunggu respon penjual.'
        );
    }

    // Simpan penawaran dan pesan chat sekaligus
    $conversation = DB::transaction(function () use (
        $product,
        $buyerId,
        $sellerId,
        $offeredPrice
    ) {
        // Simpan data nego
        Negotiation::create([
            'product_id' => $product->id,
            'buyer_id' => $buyerId,
            'offered_price' => $offeredPrice,
            'status' => 'pending',
        ]);

        // Urutkan ID pengguna agar pasangan chat konsisten
        $userOneId = min($buyerId, $sellerId);
        $userTwoId = max($buyerId, $sellerId);

        // Cari atau buat percakapan
        $conversation = Conversation::firstOrCreate(
            [
                'user_one_id' => $userOneId,
                'user_two_id' => $userTwoId,
            ],
            [
                'product_id' => $product->id,
                'buyer_id' => $buyerId,
                'seller_id' => $sellerId,
            ]
        );

        // Perbarui konteks produk dan pihak percakapan
        $conversation->update([
            'product_id' => $product->id,
            'buyer_id' => $buyerId,
            'seller_id' => $sellerId,
        ]);

        // Kirim penawaran sebagai pesan di chat
        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $buyerId,
            'product_id' => $product->id,
            'body' => 'Mengajukan penawaran harga sebesar Rp ' .
                number_format($offeredPrice, 0, ',', '.'),
            'type' => 'offer',
            'offered_price' => $offeredPrice,
            'status' => 'pending',
        ]);

        return $conversation;
    });

    // Langsung buka chat dengan penjual
    return redirect()
        ->route('chat.show', $conversation->id)
        ->with('success', 'Penawaran berhasil dikirim kepada penjual!');
}


    public function update(Request $request, Negotiation $negotiation)
    {
        abort_unless($negotiation->product->user_id === auth()->id(), 403);

        $request->validate(['status' => 'required|in:accepted,rejected']);
        $negotiation->update(['status' => $request->status]);

        return back()->with('success', 'Tawaran diperbarui.');
    }
}

