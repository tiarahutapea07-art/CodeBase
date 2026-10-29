<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inbox Pesan - ReUse Market</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 font-sans p-6">

    <div class="max-w-2xl mx-auto bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
        <h1 class="text-xl font-extrabold text-slate-900 mb-4">💬 Kotak Masuk Pesan</h1>

        @if(isset($conversations) && $conversations->count() > 0)
            <div class="space-y-3">
                @foreach($conversations as $conv)
                    <a href="{{ route('chat.show', $conv->id) }}" class="block p-4 rounded-2xl bg-slate-50 hover:bg-amber-50/50 border border-slate-200/80 transition">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-xs font-bold text-slate-800">
                                    {{ auth()->id() === $conv->buyer_id ? 'Penjual: ' . ($conv->seller->name ?? 'User') : 'Pembeli: ' . ($conv->buyer->name ?? 'User') }}
                                </h3>
                                <p class="text-[11px] text-amber-600 font-semibold mt-0.5">Barang: {{ $conv->product->name ?? 'Produk' }}</p>
                            </div>
                            <span class="text-[10px] text-slate-400">{{ $conv->updated_at->diffForHumans() }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <p class="text-xs text-slate-400 text-center py-8">Belum ada percakapan aktif.</p>
        @endif
        
        <div class="mt-6 text-center">
            <a href="/" class="text-xs font-bold text-amber-600 hover:underline">← Kembali ke Katalog</a>
        </div>
    </div>

</body>
</html>