<?php

namespace App\Livewire\Products;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Livewire\Component;

class ProductManager extends Component
{
    public $name, $price, $busy = false, $description;

    public $latestProducts, $products;

    public $showDescriptionModal = false;
    public $modalDescription = '';
    public $modalProductId = null;
    public $modalPrice = null;
    public $showPriceModal = false;

    public function mount()
    {
        $this->loadProducts();
    }

    public function loadProducts()
    {
        $this->products = Product::all();
        $this->latestProducts = Product::orderBy('created_at', 'desc')->limit(5)->get();
    }

    public function addProduct()
    {
        Product::create([
            'name' => $this->name,
            'price' => $this->price,
            'busy' => $this->busy,
            'locationId' => Auth::id(),
            'description' => $this->description
        ]);

        $this->reset(['name', 'price', 'busy']);
        session()->flash('message', 'Product added successfully.');

        $this->loadProducts();
    }

    public function deleteProduct($id)
    {
        Product::destroy($id);
        session()->flash('message', 'Product deleted successfully.');

        $this->loadProducts();
    }

    public function updateProduct($id)
    {
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
        $product = Product::find($this->modalProductId);
        if ($product) {
            $product->price = $this->modalPrice;
            $product->save();
            session()->flash('message', 'Price updated successfully.');
            $this->loadProducts();
        } else {
            session()->flash('message', 'Product not found.');
        }
        $this->showPriceModal = false;
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
        $product = Product::find($this->modalProductId);
        if ($product) {
            $product->description = $this->modalDescription;
            $product->save();
            session()->flash('message', 'Description updated successfully.');
            $this->loadProducts();
        } else {
            session()->flash('message', 'Product not found.');
        }
        $this->showDescriptionModal = false;
    }

    public function render()
    {
        return view('livewire.products.products');
    }
}
