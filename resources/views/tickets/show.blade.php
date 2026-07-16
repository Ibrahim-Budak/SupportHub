<x-app-layout>
    <div class="py-6 max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold mb-2">{{ $ticket->title }}</h1>
        <p class="text-gray-600 mb-4">{{ $ticket->category }} — Öncelik: {{ $ticket->priority }}</p>
        <p class="text-sm text-gray-500 mb-4">
    Temsilci: {{ $ticket->agent?->name ?? 'Atanmamış' }}
</p>

        @can('update', $ticket)
            <form method="POST" action="{{ route('tickets.update', $ticket) }}" class="mb-6 bg-white p-4 rounded shadow">
                @csrf
                @method('PATCH')
                <label class="block font-medium mb-1">Durum</label>
                <select name="status" class="border rounded p-2">
                    <option value="open" @selected($ticket->status === 'open')>Açık</option>
                    <option value="in_progress" @selected($ticket->status === 'in_progress')>İşleniyor</option>
                    <option value="answered" @selected($ticket->status === 'answered')>Yanıtlandı</option>
                    <option value="closed" @selected($ticket->status === 'closed')>Kapatıldı</option>
                </select>
                <button class="bg-blue-600 text-white px-3 py-2 rounded ml-2">Güncelle</button>
            </form>
        @endcan

        @can('assign', $ticket)
    <form method="POST" action="{{ route('tickets.assign', $ticket) }}" class="mb-6 bg-white p-4 rounded shadow">
        @csrf
        @method('PATCH')
        <label class="block font-medium mb-1">Temsilci Ata</label>
        <select name="agent_id" class="border rounded p-2">
            
            <option value="">— Atanmamış —</option>
            @foreach($agents as $agent)
                <option value="{{ $agent->id }}" @selected($ticket->agent_id === $agent->id)>
                    {{ $agent->name }}
                </option>
            @endforeach
        </select>
        <button class="bg-green-600 text-white px-3 py-2 rounded ml-2">Ata</button>
    </form>
@endcan

        <div id="messages" class="space-y-3 mb-6">
            @foreach($ticket->messages as $msg)
                <div class="bg-white p-3 rounded shadow">
                    <p class="text-sm text-gray-500">{{ $msg->user->name }} — {{ $msg->created_at->diffForHumans() }}</p>
                    <p>{{ $msg->message }}</p>
                </div>
            @endforeach
        </div>

        @can('reply', $ticket)
            <form method="POST" action="{{ route('tickets.reply', $ticket) }}" class="bg-white p-4 rounded shadow">
                @csrf
                <textarea name="message" class="w-full border rounded p-2" rows="3" placeholder="Mesajınızı yazın..."></textarea>
                <button class="bg-blue-600 text-white px-4 py-2 rounded mt-2">Gönder</button>
            </form>
        @endcan
    </div>
    @push('scripts')
<script type="module">
    window.Echo.private('ticket.{{ $ticket->id }}')
        .listen('.message.sent', (e) => {
            const container = document.getElementById('messages');
            const div = document.createElement('div');
            div.className = 'bg-white p-3 rounded shadow';
            div.innerHTML = `<p class="text-sm text-gray-500">${e.user_name} — ${e.created_at}</p><p>${e.message}</p>`;
            container.appendChild(div);
        });
</script>
@endpush
</x-app-layout>