<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    public function model(array $row)
    {
        return new Product([
            'name' => $row[0],
            'price' => $row[1],
            'quantity' => $row[2],
        ]);
    }
}