<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_loads_successfully()
    {
        $response = $this->get('/customer/dashboard');
        $response->assertStatus(200);
    }

    public function test_search_products_functionality()
    {
        // Test searching for specific products
        $searchTerms = [
            'Bayam Hijau',
            'Apel Merah',
            'Daging Sapi',
            'Ikan Salmon',
            'Bawang Merah'
        ];

        foreach ($searchTerms as $term) {
            $response = $this->get("/customer/search?query={$term}");
            $response->assertStatus(200)
                    ->assertSee($term)
                    ->assertJsonStructure([
                        'products' => [
                            '*' => [
                                'name',
                                'category',
                                'image',
                                'price'
                            ]
                        ]
                    ]);
        }
    }

    public function test_category_filter_functionality()
    {
        // Test filtering by categories
        $categories = [
            'Sayur',
            'Buah-buahan',
            'Daging Sapi',
            'Daging Ayam',
            'Ikan Laut',
            'Rempah & Bumbu',
            'Makanan Instan',
            'Produk Olahan Daging',
            'Produk Olahan Nabati',
            'Bahan Pokok',
            'Minuman'
        ];

        foreach ($categories as $category) {
            $response = $this->get("/customer/filter?category={$category}");
            $response->assertStatus(200)
                    ->assertSee($category)
                    ->assertJsonStructure([
                        'products' => [
                            '*' => [
                                'name',
                                'category',
                                'image',
                                'price'
                            ]
                        ]
                    ]);
        }
    }

    public function test_search_with_empty_query()
    {
        $response = $this->get('/customer/search?query=');
        $response->assertStatus(200)
                ->assertJsonStructure([
                    'products' => []
                ]);
    }

    public function test_product_details_display()
    {
        $products = [
            [
                'name' => 'Bayam Hijau',
                'category' => 'Sayur',
                'price' => '5K'
            ],
            [
                'name' => 'Daging Sapi Has Dalam',
                'category' => 'Daging Sapi',
                'price' => '140K'
            ]
        ];

        foreach ($products as $product) {
            $response = $this->get("/customer/product/{$product['name']}");
            $response->assertStatus(200)
                    ->assertSee($product['name'])
                    ->assertSee($product['category'])
                    ->assertSee($product['price']);
        }
    }
} 