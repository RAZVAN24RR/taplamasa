@php
    use Illuminate\Support\Str;
@endphp

<section class="bg-white px-4 py-6 max-w-6xl mx-auto space-y-8">
    <!-- Formular + ultimele 5 produse -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="col-span-2 flex items-center justify-center bg-white p-6 rounded-2xl shadow-lg">
            <div class="w-full max-w-md">
                <h2 class="text-3xl font-bold text-gray-900 mb-3 text-center">TapLaMasa</h2>
                <p class="text-gray-600 mb-4 text-center">Gestionează produsele restaurantului tău</p>

                @if (session()->has('message'))
                    <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('message') }}
                    </div>
                @endif

                <form wire:submit.prevent="addProduct" class="space-y-5">
                    <div>
                        <label class="block text-gray-900 font-semibold mb-1" for="name">Nume Produs</label>
                        <input
                            type="text"
                            id="name"
                            wire:model="name"
                            placeholder="Introdu numele produsului"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                        />
                    </div>

                    <div>
                        <label class="block text-gray-900 font-semibold mb-1" for="price">Preț (Lei)</label>
                        <input
                            type="number"
                            id="price"
                            wire:model="price"
                            placeholder="Introdu prețul"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                        />
                    </div>

                    <div>
                        <label class="block text-gray-900 font-semibold mb-1" for="description">Descriere</label>
                        <textarea
                            id="description"
                            wire:model="description"
                            placeholder="Introdu descrierea produsului"
                            rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition resize-none"
                        ></textarea>
                    </div>

                    <div class="flex items-center space-x-2">
                        <input
                            type="checkbox"
                            wire:model="busy"
                            id="busy"
                            class="w-5 h-5 text-orange-500 bg-gray-100 border-gray-300 rounded focus:ring-orange-400"
                        />
                        <label for="busy" class="text-gray-900 font-medium select-none">Indisponibil</label>
                    </div>

                    <button
                        type="submit"
                        class="w-full py-3 bg-orange-500 text-white font-semibold rounded-md hover:bg-orange-600 transition focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2"
                    >
                        Adaugă Produs
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg overflow-auto max-h-[600px]">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Ultimele 5 Produse Adăugate</h3>
            @if($latestProducts->count() > 0)
                <div class="space-y-3">
                    @foreach($latestProducts as $product)
                        <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-200 {{ $product->busy ? 'bg-red-50' : '' }}">
                            <div class="flex justify-between items-center space-x-4">
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $product->name }}</h4>
                                    <p class="text-green-600 font-medium">{{ $product->price }} lei</p>
                                    @if($product->busy)
                                        <span class="inline-block px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">Indisponibil</span>
                                    @else
                                        <span class="inline-block px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Disponibil</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">Nu există produse recente.</p>
            @endif
        </div>
    </div>

    <!-- Galerie Produse -->
    <div class="bg-white p-6 rounded-2xl shadow-lg overflow-auto max-h-[600px]">
        <h3 class="text-2xl font-bold text-gray-900 mb-4">Galerie Produse</h3>
        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($products as $product)
                    <div class="border border-gray-200 rounded-lg p-4 {{ $product->busy ? 'bg-red-50' : 'bg-white' }}">
                        <h4 class="font-semibold text-gray-900 mb-2">{{ $product->name }}</h4>

                        <div class="flex items-center justify-between mb-2">
                            <p class="text-green-600 font-medium">{{ $product->price }} lei</p>
                            <button
                                wire:click="openPriceModal({{ $product->id }})"
                                class="px-3 py-1 text-sm font-semibold rounded bg-green-300 text-green-900 hover:bg-green-400 focus:outline-none"
                                title="Editează prețul"
                            >
                                Edit
                            </button>
                        </div>

                        <p class="text-gray-700 mb-2 whitespace-pre-line">
                            {{ Str::limit($product->description, 80) }}
                            @if(strlen($product->description) > 80)
                                ...
                            @endif
                        </p>

                        @if($product->busy)
                            <span class="inline-block px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full mb-3">Indisponibil</span>
                        @else
                            <span class="inline-block px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full mb-3">Disponibil</span>
                        @endif

                        <button
                            wire:click="openDescriptionModal({{ $product->id }})"
                            class="w-full py-2 mb-2 text-orange-600 font-semibold hover:underline focus:outline-none"
                            title="Vezi și editează descrierea completă"
                        >
                            Editeaza Descrierea
                        </button>

                        <button
                            wire:click="updateProduct({{ $product->id }})"
                            class="w-full py-2 text-white rounded-md font-semibold focus:outline-none transition
                            {{ $product->busy ? 'bg-green-600 hover:bg-green-700 focus:ring-green-500' : 'bg-gray-400 hover:bg-gray-500 focus:ring-gray-700' }}"
                            title="Actualizează starea produsului"
                        >
                            {{ $product->busy ? 'Marchează ca disponibil' : 'Marchează ca indisponibil' }}
                        </button>
                        <button
                            wire:click="deleteProduct({{ $product->id }})"
                            onclick="return confirm('Sigur vrei să ștergi acest produs?')"
                            class="w-full py-2 mt-2 text-white bg-red-600 rounded-md font-semibold hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition"
                            title="Șterge produs"
                        >
                            Șterge
                        </button>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Nu există produse.</p>
        @endif
    </div>

    <!-- Modal Editare Descriere -->
    @if($showDescriptionModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-8 w-11/12 max-w-3xl">
                <h3 class="text-xl font-bold mb-4">Editare Descriere</h3>
                <textarea
                    wire:model.defer="modalDescription"
                    rows="8"
                    class="w-full border border-gray-300 rounded-md p-3 resize-none"
                ></textarea>

                <div class="mt-6 flex justify-end space-x-4">
                    <button
                        wire:click="$set('showDescriptionModal', false)"
                        class="px-5 py-2 bg-gray-300 rounded hover:bg-gray-400 focus:outline-none"
                    >
                        Anulează
                    </button>
                    <button
                        wire:click="updateDescription"
                        class="px-5 py-2 bg-orange-600 text-white rounded hover:bg-orange-700 focus:outline-none"
                    >
                        Salvează
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal Editare Preț -->
    @if($showPriceModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-8 w-11/12 max-w-3xl">
                <h3 class="text-xl font-bold mb-4">Editare Preț</h3>
                <input
                    type="number"
                    wire:model.defer="modalPrice"
                    class="w-full border border-gray-300 rounded-md p-3 mb-4"
                    min="0"
                    step="0.01"
                />

                <div class="flex justify-end space-x-4">
                    <button
                        wire:click="$set('showPriceModal', false)"
                        class="px-5 py-2 bg-gray-300 rounded hover:bg-gray-400 focus:outline-none"
                    >
                        Anulează
                    </button>
                    <button
                        wire:click="updatePrice"
                        class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none"
                    >
                        Salvează
                    </button>
                </div>
            </div>
        </div>
    @endif
</section>
