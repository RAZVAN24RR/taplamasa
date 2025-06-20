<?php

namespace App\Livewire\Products;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\DailyMenu;
use Livewire\Component;

class ProductManager extends Component
{
    public $name, $price, $busy = false, $description;
    public $typeId;

    public $productTypes;

    public $latestProducts, $products;

    public $filterTypeId = 'all';

    public $showDescriptionModal = false;
    public $modalDescription = '';
    public $modalProductId = null;
    public $modalPrice = null;
    public $showPriceModal = false;

    // Proprietăți pentru meniul zilei
    public $dailyMenus;
    public $selectedDay = 'luni';
    public $selectedMenu;
    public $menuPrice;
    public $menuItem1;
    public $menuItem2;
    public $menuItem3;

    // Loading states
    public $isLoading = false;
    public $loadingAction = '';
    public $loadingProductId = null;

    public function mount()
    {
        $this->productTypes = ProductType::all();
        $this->loadProducts();
        $this->loadDailyMenus();
        $this->selectDay($this->selectedDay);
    }

    public function loadProducts()
    {
        if ($this->filterTypeId == 'all') {
            $this->products = Product::all();
        } else {
            $this->products = Product::where('typeId', $this->filterTypeId)->get();
        }

        $this->latestProducts = Product::orderBy('created_at', 'desc')->limit(5)->get();
    }

    public function loadDailyMenus()
    {
        $this->dailyMenus = DailyMenu::all();
    }

    public function selectDay($day)
    {
        $this->selectedDay = $day;
        $this->selectedMenu = DailyMenu::where('day', $day)->first();

        if ($this->selectedMenu) {
            $this->menuPrice = $this->selectedMenu->price;
            $this->menuItem1 = $this->selectedMenu->item_1;
            $this->menuItem2 = $this->selectedMenu->item_2;
            $this->menuItem3 = $this->selectedMenu->item_3;
        }
    }

    public function updateDailyMenu()
    {
        $this->isLoading = true;
        $this->loadingAction = 'updating_menu';
        
        try {
            $this->validate([
                'menuPrice' => 'required|numeric|min:0',
                'menuItem1' => 'required|string',
                'menuItem2' => 'required|string',
                'menuItem3' => 'required|string',
            ]);

            if ($this->selectedMenu) {
                $this->selectedMenu->update([
                    'price' => $this->menuPrice,
                    'item_1' => $this->menuItem1,
                    'item_2' => $this->menuItem2,
                    'item_3' => $this->menuItem3,
                ]);

                session()->flash('message', 'Meniul pentru ' . $this->selectedDay . ' a fost actualizat cu succes!');
                $this->loadDailyMenus();
            }
        } finally {
            $this->isLoading = false;
            $this->loadingAction = '';
        }
    }

    public function updatedFilterTypeId()
    {
        $this->loadProducts();
    }

    public function filterProducts($typeId)
    {
        $this->filterTypeId = $typeId;
        $this->loadProducts();
    }

    public function addProduct()
    {
        $this->isLoading = true;
        $this->loadingAction = 'adding';
        
        try {
            Product::create([
                'name' => $this->name,
                'price' => $this->price,
                'busy' => $this->busy,
                'locationId' => Auth::id(),
                'description' => $this->description,
                'typeId' => $this->typeId
            ]);

            $this->reset(['name', 'price', 'busy', 'description', 'typeId']);
            session()->flash('message', 'Product added successfully.');
            $this->loadProducts();
        } finally {
            $this->isLoading = false;
            $this->loadingAction = '';
        }
    }

    public function deleteProduct($id)
    {
        $this->isLoading = true;
        $this->loadingAction = 'deleting';
        $this->loadingProductId = $id;
        
        try {
            Product::destroy($id);
            session()->flash('message', 'Product deleted successfully.');
            $this->loadProducts();
        } finally {
            $this->isLoading = false;
            $this->loadingAction = '';
            $this->loadingProductId = null;
        }
    }

    public function updateProduct($id)
    {
        $this->isLoading = true;
        $this->loadingAction = 'updating';
        $this->loadingProductId = $id;
        
        try {
            $product = Product::find($id);
            if($product){
                $product->busy = !$product->busy;
                $product->save();
                session()->flash('message', 'Product updated successfully.');
                $this->loadProducts();
            }
            else{
                session()->flash('message', 'Product not found.');
            }
        } finally {
            $this->isLoading = false;
            $this->loadingAction = '';
            $this->loadingProductId = null;
        }
    }

    public function openPriceModal($id)
    {
        $product = Product::find($id);
        if ($product) {
            $this->modalProductId = $id;
            $this->modalPrice = $product->price;
            $this->showPriceModal = true;
        }
    }

    public function updatePrice()
    {
        $this->isLoading = true;
        $this->loadingAction = 'updating_price';
        $this->loadingProductId = $this->modalProductId;
        
        try {
            $product = Product::find($this->modalProductId);
            if ($product) {
                $product->price = $this->modalPrice;
                $product->save();
                session()->flash('message', 'Price updated successfully.');
                $this->loadProducts();
            } else {
                session()->flash('message', 'Product not found.');
            }
        } finally {
            $this->isLoading = false;
            $this->loadingAction = '';
            $this->loadingProductId = null;
            $this->showPriceModal = false;
        }
    }

    public function openDescriptionModal($id)
    {
        $product = Product::find($id);
        if ($product) {
            $this->modalProductId = $id;
            $this->modalDescription = $product->description;
            $this->showDescriptionModal = true;
        }
    }

    public function updateDescription()
    {
        $this->isLoading = true;
        $this->loadingAction = 'updating_description';
        $this->loadingProductId = $this->modalProductId;
        
        try {
            $product = Product::find($this->modalProductId);
            if ($product) {
                $product->description = $this->modalDescription;
                $product->save();
                session()->flash('message', 'Description updated successfully.');
                $this->loadProducts();
            } else {
                session()->flash('message', 'Product not found.');
            }
        } finally {
            $this->isLoading = false;
            $this->loadingAction = '';
            $this->loadingProductId = null;
            $this->showDescriptionModal = false;
        }
    }

    public function render()
    {
        return view('livewire.products.products');
    }
}
