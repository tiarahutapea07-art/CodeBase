<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Conversation;
use App\Models\Message;

class ChatController extends Controller
{
    // Menampilkan daftar semua chat (Inbox)
    public function index()
    {
        $userId = auth()->id();
        $conversations = Conversation::with(['product', 'buyer', 'seller'])
            ->where('buyer_id', $userId)
            ->orWhere('seller_id', $userId)
            ->latest()
            ->get();

        return view('chat.index', compact('conversations'));
    }

    // 1. Logika saat tombol "Chat Penjual" diklik
    public function startConversation($productId)
    {
        $product = Product::findOrFail($productId);
        $buyerId = auth()->id();

        // Cek apakah pembeli dan penjual sudah punya ruang chat untuk produk ini
        $conversation = Conversation::firstOrCreate([
            'product_id' => $product->id,
            'buyer_id'   => $buyerId,
            'seller_id'  => $product->user_id, // Pastikan tabel produk punya kolom user_id pemilik barang
        ]);

        return redirect()->route('chat.show', $conversation->id);
    }

    // 2. Logika untuk menampilkan isi ruang chat
    public function showChat($id)
    {
        $conversation = Conversation::with(['messages.sender', 'product', 'buyer', 'seller'])->findOrFail($id);
        
        // Pastikan yang akses adalah pembeli atau penjual yang bersangkutan
        if (auth()->id() !== $conversation->buyer_id && auth()->id() !== $conversation->seller_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('chat.show', compact('conversation'));
    }

    // Mengirim pesan teks biasa di dalam chat
    public function sendMessage(Request $request, $id)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        Message::create([
            'conversation_id' => $id,
            'sender_id'       => auth()->id(),
            'body'            => $request->body,
            'type'            => 'text',
            'status'          => 'pending',
        ]);

        return back();
    }

    // 3. Logika saat pengguna mengirimkan Ajukan Penawaran (Nego)
    public function sendOffer(Request $request, $id)
    {
        $request->validate([
            'offered_price' => 'required|numeric|min:1000',
        ]);

        Message::create([
            'conversation_id' => $id,
            'sender_id'       => auth()->id(),
            'body'            => 'Mengajukan penawaran harga sebesar Rp ' . number_format($request->offered_price, 0, ',', '.'),
            'type'            => 'offer',
            'offered_price'   => $request->offered_price,
            'status'          => 'pending', // Status awal penawaran
        ]);

        return back()->with('success', 'Tawaran harga berhasil dikirim ke penjual!');
    }

    // 4. Logika Penjual Menerima atau Menolak Tawaran
    public function updateOfferStatus(Request $request, $messageId)
    {
        $message = Message::findOrFail($messageId);
        
        // Validasi status yang dikirim ('accepted' atau 'rejected')
        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $message->update([
            'status' => $request->status,
        ]);

        $statusText = $request->status === 'accepted' ? 'diterima' : 'ditolak';
        return back()->with('success', 'Penawaran telah ' . $statusText);
    }
}