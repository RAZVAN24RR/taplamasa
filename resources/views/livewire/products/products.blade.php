@php
    use Illuminate\Support\Str;
@endphp

<section class="bg-white px-4 py-6 max-w-6xl mx-auto space-y-8 relative">
    <!-- Loading Overlay -->
    @if($isLoading)
        <div class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center z-50">
            <div class="flex flex-col items-center">
                <div class="w-16 h-16">
                    <svg class="animate-spin h-16 w-16 text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-semibold text-gray-900">
                    @switch($loadingAction)
                        @case('adding')
                            Adăugare produs...
                            @break
                        @case('deleting')
                            Ștergere produs...
                            @break
                        @case('updating')
                            Actualizare produs...
                            @break
                        @case('updating_price')
                            Actualizare preț...
                            @break
                        @case('updating_description')
                            Actualizare descriere...
                            @break
                        @case('updating_menu')
                            Actualizare meniu...
                            @break
                        @default
                            Se procesează...
                    @endswitch
                </h3>
            </div>
        </div>
    @endif

    <!-- Popup pentru mesaje -->
    @if (session()->has('message'))
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-8 max-w-md w-11/12 text-center shadow-2xl">
                <div class="mb-4">
                    <div class="w-16 h-16 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Succes!</h3>
                    <p class="text-gray-600">{{ session('message') }}</p>
                </div>
                <button
                    onclick="this.closest('.fixed').style.display='none'"
                    class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition"
                >
                    OK
                </button>
            </div>
        </div>
    @endif

    <!-- Formular + ultimele 5 produse -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="col-span-2 flex items-center justify-center bg-white p-6 rounded-2xl shadow-lg">
            <div class="w-full max-w-md">
                <h2 class="text-3xl font-bold text-gray-900 mb-3 text-center">Adauga Produs</h2>
                <p class="text-gray-600 mb-4 text-center">Gestionează produsele restaurantului tău</p>

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
                        <label class="block text-gray-900 font-semibold mb-1" for="typeId">Tip Produs</label>
                        <select
                            id="typeId"
                            wire:model="typeId"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition"
                        >
                            <option value="">Selectează tipul produsului</option>
                            @foreach($productTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-900 font-semibold mb-1" for="price">Preț (Lei)</label>
                        <input
                            type="string"
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
                        class="w-full py-3 bg-orange-500 text-white font-semibold rounded-md hover:bg-orange-600 transition focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove wire:target="addProduct">Adaugă Produs</span>
                        <span wire:loading wire:target="addProduct">Se adaugă...</span>
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

    <!-- Secțiunea pentru Meniul Zilei -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h3 class="text-xl font-bold text-gray-900 mb-6">Meniul Zilei</h3>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-1">
                <h4 class="font-semibold text-gray-700 mb-3">Selectează ziua:</h4>
                <div class="space-y-2">
                    @foreach(['luni', 'marti', 'miercuri', 'joi', 'vineri'] as $day)
                        <button
                            wire:click="selectDay('{{ $day }}')"
                            class="w-full text-left px-4 py-3 rounded-md transition {{ $selectedDay === $day ? 'bg-orange-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                        >
                            {{ ucfirst($day) }}
                        </button>
                    @endforeach
                </div>
            </div>
            <div class="lg:col-span-2">
                <h4 class="font-semibold text-gray-700 mb-3">Meniul pentru {{ ucfirst($selectedDay) }}:</h4>

                <form wire:submit.prevent="updateDailyMenu" class="space-y-4">
                    <!-- Preț -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Preț (Lei)</label>
                        <input
                            type="number"
                            step="0.01"
                            wire:model="menuPrice"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                            placeholder="Introdu prețul"
                        />
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Felul 1</label>
                        <textarea
                            wire:model="menuItem1"
                            rows="2"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 resize-none"
                            placeholder="Ex: 01.Supă cu tăiței de casa 250ml sau Ciorbă de vacuță 250ml/20g"
                        ></textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Felul 2</label>
                        <textarea
                            wire:model="menuItem2"
                            rows="2"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 resize-none"
                            placeholder="Ex: 02.Mâncare de cartofi cu piept de porc 150g/80g"
                        ></textarea>
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Felul 3</label>
                        <textarea
                            wire:model="menuItem3"
                            rows="2"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 resize-none"
                            placeholder="Ex: 03.Salată de ardei copti 80g"
                        ></textarea>
                    </div>

                    <!-- Buton de salvare -->
                    <button
                        type="submit"
                        class="w-full py-3 bg-orange-500 text-white font-semibold rounded-md hover:bg-orange-600 transition focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove wire:target="updateDailyMenu">Actualizează Meniul pentru {{ ucfirst($selectedDay) }}</span>
                        <span wire:loading wire:target="updateDailyMenu">Se actualizează...</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Filtru pentru galeria de produse -->
    <div class="mb-6">
        <label class="block text-gray-900 font-semibold mb-2">Filtrează după tip:</label>
        <select wire:change="filterProducts($event.target.value)" class="px-4 py-2 border border-gray-300 rounded-md bg-gray-50 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
            <option value="all">Toate produsele</option>
            @foreach($productTypes as $type)
                <option value="{{ $type->id }}">{{ $type->type }}</option>
            @endforeach
        </select>
    </div>

    <!-- Galeria de produse (aici afișezi $products) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($products as $product)
            <!-- Card-ul produsului -->
        @endforeach
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
                                class="px-3 py-1 text-sm font-semibold rounded bg-green-300 text-green-900 hover:bg-green-400 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed"
                                title="Editează prețul"
                                wire:loading.attr="disabled"
                                wire:target="updatePrice"
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

                        <button
                            wire:click="openDescriptionModal({{ $product->id }})"
                            class="w-full py-2 mb-2 text-orange-600 font-semibold hover:underline focus:outline-none"
                            title="Vezi și editează descrierea completă"
                        >
                            Editeaza Descrierea
                        </button>

                        <div class="flex justify-between items-center mt-4">
                            <button
                                wire:click="updateProduct({{ $product->id }})"
                                class="px-3 py-1 text-sm font-semibold rounded {{ $product->busy ? 'bg-red-300 text-red-900 hover:bg-red-400' : 'bg-green-300 text-green-900 hover:bg-green-400' }} focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed"
                                wire:loading.attr="disabled"
                                wire:target="updateProduct"
                            >
                                <span wire:loading.remove wire:target="updateProduct">
                                    {{ $product->busy ? 'Indisponibil' : 'Disponibil' }}
                                </span>
                                <span wire:loading wire:target="updateProduct">Se actualizează...</span>
                            </button>

                            <button
                                wire:click="deleteProduct({{ $product->id }})"
                                class="px-3 py-1 text-sm font-semibold rounded bg-red-300 text-red-900 hover:bg-red-400 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed"
                                wire:loading.attr="disabled"
                                wire:target="deleteProduct"
                            >
                                <span wire:loading.remove wire:target="deleteProduct">Șterge</span>
                                <span wire:loading wire:target="deleteProduct">Se șterge...</span>
                            </button>
                        </div>
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
            <div class="bg-white rounded-lg p-8 max-w-md w-11/12">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Editează Descrierea</h3>
                <form wire:submit.prevent="updateDescription">
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Descriere</label>
                        <textarea
                            wire:model="modalDescription"
                            rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 resize-none"
                            required
                        ></textarea>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button
                            type="button"
                            wire:click="$set('showDescriptionModal', false)"
                            class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none"
                        >
                            Anulează
                        </button>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed"
                            wire:loading.attr="disabled"
                        >
                            <span wire:loading.remove>Salvează</span>
                            <span wire:loading>Se salvează...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Modal Editare Preț -->
    @if($showPriceModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-8 max-w-md w-11/12">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Editează Prețul</h3>
                <form wire:submit.prevent="updatePrice">
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Preț (Lei)</label>
                        <input
                            type="number"
                            step="0.01"
                            wire:model="modalPrice"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
                            required
                        />
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button
                            type="button"
                            wire:click="$set('showPriceModal', false)"
                            class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 focus:outline-none"
                        >
                            Anulează
                        </button>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600 focus:outline-none disabled:opacity-50 disabled:cursor-not-allowed"
                            wire:loading.attr="disabled"
                        >
                            <span wire:loading.remove>Salvează</span>
                            <span wire:loading>Se salvează...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</section>
