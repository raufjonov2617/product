<?php

namespace App\Services;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function create(array $payload)
    {
        $product = Product::create([
            'article' => $payload['article'],
            'name' => $payload['name'],
            'status' => $payload['status'],
            'data' => json_encode($payload['data'])
        ]);

        return $product;
    }

    public function allowedColumnsForUpdate()
    {
        //$user = User::find(1);
        $user = auth()->user();

        if ($user->role == config('products.role')) {
            return ['article'];
        }

        return ['name', 'status', 'data'];
    }
}
