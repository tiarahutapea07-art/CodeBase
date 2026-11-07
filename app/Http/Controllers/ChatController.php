<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Conversation;
use App\Models\Message;

class ChatController extends Controller
{
    // Menampilkan daftar chat pengguna
    public function index()
    {
        $userId = auth()->id();

        $conversations = Conversation::with([
            'product',
            'buyer',
            'seller',
            'userOne',
            'userTwo',
            'messages'
        ])
        ->where('user_one_id', $userId)
        ->orWhere('user_two_id', $userId)
        ->latest()
        ->get();

        $selectedConversation = null;

        return view('chat.index', compact(
            'conversations',
            'selectedConversation'
        ));
    }

    // Membuka atau membuat ruang chat
    public function startConversation($productId)
    {
        $product = Product::findOrFail($productId);

        $buyerId = auth()->id();
        $sellerId = $product->user_id;

        // Tidak boleh chat dengan akun sendiri
        if ($buyerId == $sellerId) {
            return back()->with('error', 'Tidak bisa menghubungi barang milik sendiri.');
        }

        // Urutkan ID agar pasangan selalu sama
        $userOneId = min($buyerId, $sellerId);
        $userTwoId = max($buyerId, $sellerId);

        // Cari ruang chat berdasarkan pasangan pengguna
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

        // Perbarui konteks produk yang sedang dibicarakan
        $conversation->update([
            'product_id' => $product->id,
            'buyer_id' => $buyerId,
            'seller_id' => $sellerId,
        ]);

        return redirect()->route('chat.show', $conversation->id);
    }

    // Memastikan pengguna merupakan anggota ruang chat
    private function getUserConversation($id)
    {
        $userId = auth()->id();

        return Conversation::where('id', $id)
            ->where(function ($query) use ($userId) {
                $query->where('user_one_id', $userId)
                      ->orWhere('user_two_id', $userId);
            })
            ->firstOrFail();
    }

    // Menampilkan isi ruang chat
    public function showChat($id)
    {
        $userId = auth()->id();

        $conversations = Conversation::with([
            'product',
            'buyer',
            'seller',
            'userOne',
            'userTwo',
            'messages.sender',
            'messages.product'
        ])
        ->where('user_one_id', $userId)
        ->orWhere('user_two_id', $userId)
        ->latest()
        ->get();

        $selectedConversation = $conversations->firstWhere('id', $id);

        if (!$selectedConversation) {
            abort(404);
        }

        return view('chat.index', compact(
            'conversations',
            'selectedConversation'
        ));
    }

    // Mengirim pesan teks
    public function sendMessage(Request $request, $id)
    {
        $conversation = $this->getUserConversation($id);

        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => auth()->id(),
            'product_id' => $conversation->product_id,
            'body' => $request->body,
            'type' => 'text',
            'status' => 'pending',
        ]);

        return back();
    }

    // Mengirim penawaran harga
    public function sendOffer(Request $request, $id)
    {
        $conversation = $this->getUserConversation($id);

        $request->validate([
            'offered_price' => 'required|numeric|min:1000',
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => auth()->id(),
            'product_id' => $conversation->product_id,
            'body' => 'Mengajukan penawaran harga sebesar Rp ' .
                number_format($request->offered_price, 0, ',', '.'),
            'type' => 'offer',
            'offered_price' => $request->offered_price,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Tawaran harga berhasil dikirim!');
    }

    // Menerima atau menolak penawaran
    public function updateOfferStatus(Request $request, $messageId)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $userId = auth()->id();

        $message = Message::where('type', 'offer')
            ->where('status', 'pending')
            ->whereHas('conversation', function ($query) use ($userId) {
                $query->where('user_one_id', $userId)
                      ->orWhere('user_two_id', $userId);
            })
            ->findOrFail($messageId);

        // Pengirim penawaran tidak boleh menerima penawarannya sendiri
        if ($message->sender_id == $userId) {
            abort(403, 'Tidak dapat mengubah penawaran sendiri.');
        }

        $message->update([
            'status' => $request->status,
        ]);

        $statusText = $request->status === 'accepted'
            ? 'diterima'
            : 'ditolak';

        return back()->with('success', 'Penawaran telah ' . $statusText . '.');
    }
}