<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruang Obrolan - ReUse Market</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans">

    <div class="max-w-3xl mx-auto h-screen flex flex-col bg-white border-x border-slate-200 shadow-sm">
        
        <!-- Header Chat - Diperbarui -->
        <div class="p-4 border-b border-slate-200 flex items-center bg-white sticky top-0 z-10">
            <div class="flex items-center gap-4">
                <!-- Tombol Kembali -->
                <a href="{{ route('chat.index') }}" class="text-slate-500 hover:text-amber-600 transition p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                </a>

                <!-- Foto Profil Bulat -->
                @if($conversation->seller->profile_photo_path)
                    <img src="{{ asset('storage/' . $conversation->seller->profile_photo_path) }}" alt="Foto {{ $conversation->seller->name }}" class="w-12 h-12 rounded-full object-cover border-2 border-slate-100">
                @else
                    <!-- Default Avatar jika tidak ada foto -->
                    <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center border-2 border-amber-200">
                        <span class="text-xl font-bold text-amber-600">
                            {{ strtoupper(substr($conversation->seller->name, 0, 1)) }}
                        </span>
                    </div>
                @endif

                <!-- Nama Penjual dan Informasi Produk -->
                <div>
                    <h2 class="text-base font-extrabold text-slate-900 leading-tight">
                        {{ $conversation->seller->name }}
                    </h2>
                    <p class="text-[11px] text-amber-600 font-semibold tracking-wide">
                        Produk: {{ $conversation->product->name ?? 'Barang Preloved' }}
                    </p>
                    <div class="flex items-center gap-1 mt-0.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span class="text-[10px] text-slate-500">Online</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header Chat -->

        <!-- Area Daftar Pesan -->
        <div class="flex-1 p-4 overflow-y-auto space-y-4">
            @foreach($conversation->messages as $message)
                <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-md">
                        
                        <!-- Jika Pesan Teks Biasa -->
                        @if($message->type === 'text')
                            <div class="p-3 rounded-2xl text-xs leading-relaxed {{ $message->sender_id === auth()->id() ? 'bg-amber-500 text-white rounded-br-none' : 'bg-slate-100 text-slate-800 rounded-bl-none' }}">
                                {{ $message->body }}
                            </div>
                        @endif

                        <!-- Jika Pesan Berupa Kartu Penawaran Harga (Offer) -->
                        @if($message->type === 'offer')
                            <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl my-2 max-w-xs shadow-sm">
                                <p class="text-[11px] text-amber-800 font-bold mb-1">🤝 Penawaran Harga Baru</p>
                                <p class="text-base font-black text-amber-600">Rp {{ number_format($message->offered_price, 0, ',', '.') }}</p>
                                
                                @if($message->status === 'pending')
                                    @if(auth()->id() === $conversation->seller_id)
                                        <!-- Tombol Aksi untuk Penjual -->
                                        <div class="flex gap-2 mt-3">
                                            <form action="{{ route('offer.status', $message->id) }}" method="POST" class="w-1/2">
                                                @csrf
                                                <input type="hidden" name="status" value="accepted">
                                                <button type="submit" class="w-full py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[11px] rounded-lg cursor-pointer">Terima</button>
                                            </form>
                                            <form action="{{ route('offer.status', $message->id) }}" method="POST" class="w-1/2">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="w-full py-1.5 bg-rose-500 hover:bg-rose-600 text-white font-bold text-[11px] rounded-lg cursor-pointer">Tolak</button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-[10px] text-slate-400 mt-2 block italic">Menunggu tanggapan penjual...</span>
                                    @endif
                                @elseif($message->status === 'accepted')
                                    <span class="inline-block mt-2 text-[11px] font-bold text-emerald-600 bg-emerald-100 px-2.5 py-0.5 rounded-full">
                                        ✓ Penawaran Diterima
                                    </span>
                                @else
                                    <span class="inline-block mt-2 text-[11px] font-bold text-rose-600 bg-rose-100 px-2.5 py-0.5 rounded-full">
                                        ✕ Penawaran Ditolak
                                    </span>
                                @endif
                            </div>
                        @endif

                    </div>
                </div>
            @endforeach
        </div>

        <!-- Form Kirim Pesan Teks di Bagian Bawah -->
        <div class="p-3 border-t border-slate-200 bg-white">
            <form action="{{ route('chat.send', $conversation->id) }}" method="POST" class="flex gap-2">
                @csrf
                <input type="text" name="body" placeholder="Tulis pesan atau tanyakan detail barang..." class="flex-1 px-4 py-2.5 text-xs bg-slate-100 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500" required>
                <button type="submit" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs rounded-xl transition cursor-pointer">
                    Kirim
                </button>
            </form>
        </div>

    </div>

</body>
</html>