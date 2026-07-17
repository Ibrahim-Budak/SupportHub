<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Genel Bakış
        </h2>
    </x-slot>

    <div class="py-6 max-w-5xl mx-auto">

        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-white p-4 rounded shadow text-center">
                <p class="text-2xl font-bold text-gray-700">{{ $stats['open'] }}</p>
                <p class="text-sm text-gray-500">Açık</p>
            </div>
            <div class="bg-white p-4 rounded shadow text-center">
                <p class="text-2xl font-bold text-yellow-600">{{ $stats['in_progress'] }}</p>
                <p class="text-sm text-gray-500">İşleniyor</p>
            </div>
            <div class="bg-white p-4 rounded shadow text-center">
                <p class="text-2xl font-bold text-blue-600">{{ $stats['answered'] }}</p>
                <p class="text-sm text-gray-500">Yanıtlandı</p>
            </div>
            <div class="bg-white p-4 rounded shadow text-center">
                <p class="text-2xl font-bold text-green-600">{{ $stats['closed'] }}</p>
                <p class="text-sm text-gray-500">Kapatıldı</p>
            </div>
            <div class="bg-white p-4 rounded shadow text-center">
                <p class="text-2xl font-bold text-red-600">{{ $stats['sla_breached'] }}</p>
                <p class="text-sm text-gray-500">Gecikmiş</p>
            </div>
        </div>

        <div class="bg-white rounded shadow p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Son Talepler</h3>
                <a href="{{ route('tickets.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                    Tüm Talepleri Gör
                </a>
            </div>

            @if($recentTickets->isEmpty())
                <p class="text-gray-500">Henüz talep yok.</p>
            @else
                <div class="space-y-2">
                    @foreach($recentTickets as $ticket)
                        <a href="{{ route('tickets.show', $ticket) }}"
                           class="block border rounded p-3 hover:bg-gray-50">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-medium">{{ $ticket->title }}</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $ticket->category }} — Öncelik: {{ $ticket->priority }}
                                        @if($ticket->agent)
                                            — Temsilci: {{ $ticket->customer->name ?? '' }}
                                        @endif
                                    </p>
                                </div>
                                <span class="text-sm px-2 py-1 rounded bg-gray-100">
                                    {{ $ticket->status }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</x-app-layout>