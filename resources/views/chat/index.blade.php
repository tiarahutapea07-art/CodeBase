
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message - ReUseMarket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 font-sans">

<div class="h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-white border-b border-slate-200 px-5 py-4 flex items-center justify-between">
        <a href="/" class="text-xl font-extrabold text-emerald-600">
            ReUseMarket
        </a>

        <h1 class="font-bold text-slate-800">Message</h1>

        <a href="/" class="text-sm text-slate-500 hover:text-emerald-600">
            Kembali
        </a>
    </header>

    <!-- Area Message -->
    <div class="flex-1 flex overflow-hidden bg-white">

        <!-- SIDEBAR DAFTAR CHAT -->
        <div class="w-full md:w-1/3 lg:w-1/4 border-r border-slate-200
            flex flex-col
            {{ $selectedConversation ? 'hidden md:flex' : 'flex' }}">

            <div class="p-4 border-b border-slate-200">
                <h2 class="text-lg font-bold text-slate-800">Percakapan</h2>

                <input
                    type="text"
                    id="searchChat"
                    placeholder="Cari percakapan..."
                    class="mt-3 w-full px-4 py-2 rounded-xl bg-slate-100
                    text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                >
            </div>

            <div class="flex-1 overflow-y-auto">

                @forelse($conversations as $conv)

                    @php
                        $otherUser = auth()->id() == $conv->user_one_id
                            ? $conv->userTwo
                            : $conv->userOne;

                        $lastMessage = $conv->messages
                            ->sortByDesc('created_at')
                            ->first();
                    @endphp

                    <a href="{{ route('chat.show', $conv->id) }}"
                       class="chat-item flex items-center gap-3 p-4 border-b
                       border-slate-100 hover:bg-emerald-50 transition
                       {{ $selectedConversation && $selectedConversation->id == $conv->id
                            ? 'bg-emerald-50 border-l-4 border-l-emerald-500'
                            : '' }}">

                        <!-- Foto Profil -->
                        @if($otherUser && $otherUser->profile_photo_path)
                            <img
                                src="{{ asset('storage/' . $otherUser->profile_photo_path) }}"
                                class="w-12 h-12 rounded-full object-cover"
                                alt="Foto profil"
                            >
                        @else
                            <div class="w-12 h-12 rounded-full bg-emerald-100
                                flex items-center justify-center text-emerald-700
                                font-bold text-lg">
                                {{ strtoupper(substr($otherUser->name ?? 'U', 0, 1)) }}
                            </div>
                        @endif

                        <!-- Informasi Chat -->
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-center gap-2">
                                <h3 class="font-bold text-sm text-slate-800 truncate">
                                    {{ $otherUser->name ?? 'User' }}
                                </h3>

                                <span class="text-[10px] text-slate-400 whitespace-nowrap">
                                    {{ $lastMessage
                                        ? $lastMessage->created_at->format('H:i')
                                        : $conv->updated_at->format('H:i') }}
                                </span>
                            </div>

                            <p class="text-xs text-emerald-600 truncate mt-1">
                                {{ $lastMessage
                                    ? $lastMessage->body
                                    : 'Mulai percakapan' }}
                            </p>

                            <p class="text-[10px] text-slate-400 truncate mt-1">
                                {{ $conv->product->name ?? 'Produk' }}
                            </p>
                        </div>

                    </a>

                @empty

                    <p class="text-center text-sm text-slate-400 py-10">
                        Belum ada percakapan.
                    </p>

                @endforelse

            </div>
        </div>


        <!-- AREA ISI CHAT -->
        <div class="flex-1 flex flex-col
            {{ $selectedConversation ? 'flex' : 'hidden md:flex' }}">

            @if($selectedConversation)

                @php
                    $otherUser = auth()->id() == $selectedConversation->user_one_id
                        ? $selectedConversation->userTwo
                        : $selectedConversation->userOne;
                @endphp

                <!-- Header Chat -->
                <div class="p-4 border-b border-slate-200 flex items-center gap-3">

                    <a href="{{ route('chat.index') }}"
                       class="md:hidden text-slate-500 mr-1">
                        ←
                    </a>

                    @if($otherUser && $otherUser->profile_photo_path)
                        <img
                            src="{{ asset('storage/' . $otherUser->profile_photo_path) }}"
                            class="w-11 h-11 rounded-full object-cover"
                            alt="Foto profil"
                        >
                    @else
                        <div class="w-11 h-11 rounded-full bg-emerald-100
                            flex items-center justify-center text-emerald-700 font-bold">
                            {{ strtoupper(substr($otherUser->name ?? 'U', 0, 1)) }}
                        </div>
                    @endif

                    <div>
                        <h2 class="font-bold text-slate-800">
                            {{ $otherUser->name ?? 'User' }}
                        </h2>

                        <p class="text-xs text-emerald-600">
                            {{ $selectedConversation->product->name ?? 'Barang Preloved' }}
                        </p>
                    </div>
                </div>


                                <!-- Informasi Barang -->
                @if($selectedConversation->product)
                    <div class="px-4 py-3 border-b border-slate-200 bg-white">
                        <div class="flex items-center gap-3">

                            @if($selectedConversation->product->image_url)
                                <img
                                    src="{{ asset($selectedConversation->product->image_url) }}"
                                    alt="Foto barang"
                                    class="w-16 h-16 rounded-xl object-cover"
                                >
                            @else
                                <div class="w-16 h-16 rounded-xl bg-slate-100
                                    flex items-center justify-center text-slate-400 text-xs">
                                    Tidak ada foto
                                </div>
                            @endif

                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-slate-400">
                                    Barang yang dibicarakan
                                </p>

                                <h3 class="font-bold text-sm text-slate-800 truncate">
                                    {{ $selectedConversation->product->name }}
                                </h3>

                                <p class="text-sm font-semibold text-emerald-600">
                                    @if($selectedConversation->product->price > 0)
                                        Rp {{ number_format($selectedConversation->product->price, 0, ',', '.') }}
                                    @else
                                        Gratis
                                    @endif
                                </p>
                            </div>

                        </div>
                    </div>
                @endif
                
                
                <!-- Isi Percakapan -->
                <div class="flex-1 overflow-y-auto p-5 space-y-4 bg-slate-50">

                    @forelse($selectedConversation->messages as $message)

                        <div class="flex
                            {{ $message->sender_id == auth()->id()
                                ? 'justify-end'
                                : 'justify-start' }}">

                            <div class="max-w-[80%] md:max-w-md">

                                @if($message->product)
                                    <p class="text-[10px] text-slate-400 mb-1 px-2">
                                        {{ $message->product->name }}
                                    </p>
                                @endif

                                <!-- Pesan Teks -->
                                @if($message->type === 'text')

                                    <div class="px-4 py-3 rounded-2xl text-sm
                                        {{ $message->sender_id == auth()->id()
                                            ? 'bg-emerald-600 text-white rounded-br-none'
                                            : 'bg-white text-slate-800 border border-slate-200 rounded-bl-none' }}">
                                        {{ $message->body }}
                                    </div>

                                @endif

                                <!-- Penawaran Harga -->
                                @if($message->type === 'offer')

                                    <div class="p-4 bg-amber-50 border border-amber-200
                                        rounded-2xl my-2 shadow-sm">

                                        <p class="text-sm font-bold text-amber-800 mb-1">
                                            🤝 Penawaran Harga
                                        </p>

                                        <p class="text-lg font-black text-amber-600">
                                            Rp {{ number_format($message->offered_price, 0, ',', '.') }}
                                        </p>

                                        @if($message->status === 'pending')

                                            @if($message->sender_id != auth()->id())

                                                <div class="flex gap-2 mt-3">

                                                    <form action="{{ route('offer.status', $message->id) }}"
                                                          method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="accepted">

                                                        <button class="px-4 py-2 bg-emerald-600
                                                            text-white text-xs rounded-lg font-bold">
                                                            Terima
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('offer.status', $message->id) }}"
                                                          method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="rejected">

                                                        <button class="px-4 py-2 bg-rose-500
                                                            text-white text-xs rounded-lg font-bold">
                                                            Tolak
                                                        </button>
                                                    </form>

                                                </div>

                                            @else

                                                <p class="text-xs text-slate-400 mt-2">
                                                    Menunggu tanggapan...
                                                </p>

                                            @endif

                                        @elseif($message->status === 'accepted')

                                            <p class="text-xs text-emerald-600 font-bold mt-2">
                                                ✓ Penawaran Diterima
                                            </p>

                                        @else

                                            <p class="text-xs text-rose-600 font-bold mt-2">
                                                ✕ Penawaran Ditolak
                                            </p>

                                        @endif
                                    </div>

                                @endif

                                <p class="text-[10px] text-slate-400 mt-1 px-2">
                                    {{ $message->created_at->format('H:i') }}
                                </p>

                            </div>
                        </div>

                    @empty

                        <div class="text-center text-sm text-slate-400 py-10">
                            Belum ada pesan. Mulai percakapan sekarang!
                        </div>

                    @endforelse

                </div>


                <!-- Form Kirim Pesan -->
                <div class="p-4 border-t border-slate-200 bg-white">

                    <form action="{{ route('chat.send', $selectedConversation->id) }}"
                          method="POST"
                          class="flex gap-3">

                        @csrf

                        <input
                            type="text"
                            name="body"
                            placeholder="Ketik pesan..."
                            required
                            maxlength="1000"
                            class="flex-1 px-4 py-3 rounded-xl bg-slate-100
                            text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500"
                        >

                        <button
                            type="submit"
                            class="px-5 py-3 bg-emerald-600 hover:bg-emerald-700
                            text-white rounded-xl font-bold text-sm">
                            Kirim
                        </button>

                    </form>
                </div>

            @else

                <!-- Tampilan Awal -->
                <div class="flex-1 flex flex-col items-center justify-center
                    text-center p-6 bg-slate-50">

                    <div class="w-20 h-20 rounded-full bg-emerald-100
                        flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-emerald-600"
                            fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M8 10h8M8 14h5m-9 6l2.5-3H18a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v14z"/>
                        </svg>
                    </div>

                    <h2 class="text-xl font-bold text-slate-800">
                        Selamat Datang di Message
                    </h2>

                    <p class="text-sm text-slate-400 mt-2">
                        Pilih percakapan untuk mulai bertukar pesan.
                    </p>

                </div>

            @endif

        </div>

    </div>
</div>


<!-- Pencarian Chat -->
<script>
    document.getElementById('searchChat').addEventListener('input', function () {
        const keyword = this.value.toLowerCase();

        document.querySelectorAll('.chat-item').forEach(function (item) {
            item.style.display = item.innerText.toLowerCase().includes(keyword)
                ? ''
                : 'none';
        });
    });
</script>

</body>
</html>