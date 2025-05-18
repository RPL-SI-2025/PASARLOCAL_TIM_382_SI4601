<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $products = [
        // Sayur
        ['name' => 'Bayam Hijau', 'category' => 'Sayur', 'image' => 'bayam_hijau.jpg', 'price' => '5K'],
        ['name' => 'Kangkung Air', 'category' => 'Sayur', 'image' => 'kangkung.jpg', 'price' => '4K'],
        ['name' => 'Wortel', 'category' => 'Sayur', 'image' => 'wortel.jpg', 'price' => '8K'],
        ['name' => 'Tomat Merah', 'category' => 'Sayur', 'image' => 'tomat_merah.jpg', 'price' => '10K'],
        ['name' => 'Selada Hijau', 'category' => 'Sayur', 'image' => 'selada_hijau.jpg', 'price' => '6K'],
        ['name' => 'Brokoli', 'category' => 'Sayur', 'image' => 'brokoli.jpg', 'price' => '15K'],
        
        // Buah-buahan
        ['name' => 'Apel Merah', 'category' => 'Buah-buahan', 'image' => 'apel_merah.jpg', 'price' => '25K'],
        ['name' => 'Pisang Ambon', 'category' => 'Buah-buahan', 'image' => 'pisang_ambon.jpg', 'price' => '15K'],
        ['name' => 'Mangga Harum Manis', 'category' => 'Buah-buahan', 'image' => 'mangga_harummanis.jpg', 'price' => '20K'],
        
        // Daging Sapi
        ['name' => 'Daging Sapi Has Dalam', 'category' => 'Daging Sapi', 'image' => 'sapi_has_dalam.jpg', 'price' => '140K'],
        ['name' => 'Iga Sapi', 'category' => 'Daging Sapi', 'image' => 'iga_sapi.jpg', 'price' => '120K'],
        ['name' => 'Daging Sapi Giling', 'category' => 'Daging Sapi', 'image' => 'sapi_giling.jpg', 'price' => '100K'],

        // Ikan Laut
        ['name' => 'Ikan Salmon Fillet', 'category' => 'Ikan Laut', 'image' => 'ikan_salmon_fillet.jpg', 'price' => '180K'],
        ['name' => 'Ikan Tuna Fillet', 'category' => 'Ikan Laut', 'image' => 'ikan_tuna_fillet.jpg', 'price' => '120K'],
        
        // Rempah & Bumbu
        ['name' => 'Bawang Merah', 'category' => 'Rempah & Bumbu', 'image' => 'bawang_merah.jpg', 'price' => '40K'],
        ['name' => 'Bawang Putih', 'category' => 'Rempah & Bumbu', 'image' => 'bawang_putih.jpg', 'price' => '35K']
    ];

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        // Filter products based on search query
        $filteredProducts = array_filter($this->products, function($product) use ($query) {
            return stripos($product['name'], $query) !== false || 
                   stripos($product['category'], $query) !== false;
        });

        return response()->json(['products' => array_values($filteredProducts)]);
    }

    public function filter(Request $request)
    {
        $category = $request->input('category');
        
        // Filter products by category
        $filteredProducts = array_filter($this->products, function($product) use ($category) {
            return $product['category'] === $category;
        });

        return response()->json(['products' => array_values($filteredProducts)]);
    }

    public function show($name)
    {
        // Find the product by name
        $product = collect($this->products)->firstWhere('name', $name);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json(['product' => $product]);
    }
}