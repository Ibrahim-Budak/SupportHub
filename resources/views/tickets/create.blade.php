<x-app-layout>
    <div class="py-6 max-w-xl mx-auto">
        <h1 class="text-2xl font-bold mb-4">Yeni Destek Talebi</h1>

        <form method="POST" action="{{ route('tickets.store') }}" class="bg-white p-6 rounded shadow space-y-4">
            @csrf

            <div>
                <label class="block font-medium">Başlık</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded p-2">
                @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium">Kategori</label>
                <input type="text" name="category" value="{{ old('category') }}" class="w-full border rounded p-2">
                @error('category') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block font-medium">Öncelik</label>
                <select name="priority" class="w-full border rounded p-2">
                    <option value="low">Düşük</option>
                    <option value="medium">Orta</option>
                    <option value="high">Yüksek</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Gönder</button>
        </form>
    </div>
</x-app-layout>