<x-app-layout>
    <div class="py-6 max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Destek Talepleri</h1>
            <a href="{{ route('tickets.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                + Yeni Talep
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <table class="w-full bg-white shadow rounded">
            <thead>
                <tr class="text-left border-b">
                    <th class="p-3">Başlık</th>
                    <th class="p-3">Kategori</th>
                    <th class="p-3">Öncelik</th>
                    <th class="p-3">Durum</th>
                    <th class="p-3">SLA</th>
                    <th class="p-3"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                    <tr class="border-b">
                        <td class="p-3">{{ $ticket->title }}</td>
                        <td class="p-3">{{ $ticket->category }}</td>
                        <td class="p-3">{{ $ticket->priority }}</td>
                        <td class="p-3">{{ $ticket->status }}</td>
                        <td class="p-3">
                            @if($ticket->isSlaBreached())
                                <span class="text-red-600 font-bold">Gecikti!</span>
                            @else
                                -
                            @endif
                        </td>
                        <td class="p-3">
                            <a href="{{ route('tickets.show', $ticket) }}" class="text-blue-600">Görüntüle</a>
                        </td>
                    </tr>
                @empty
                    <tr><td class="p-3" colspan="6">Henüz talep yok.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>