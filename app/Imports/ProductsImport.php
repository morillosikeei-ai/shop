<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public function model(array $row)
    {
        $name = trim($row['name'] ?? ($row[0] ?? ''));
        $price = $this->normalizeNumeric($row['price'] ?? ($row[1] ?? null));
        $quantity = $this->normalizeInteger($row['quantity'] ?? ($row[2] ?? null));

        if ($name === '' && $price === null && $quantity === null) {
            return null;
        }

        return new Product([
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.name' => 'required|string',
            '*.price' => 'required|numeric',
            '*.quantity' => 'required|integer',
        ];
    }

    private function normalizeNumeric($value)
    {
        if ($value === null || $value === '') {
            return null;
        }

        $value = str_replace([',', '$', ' '], '', $value);

        return is_numeric($value) ? (float) $value : null;
    }

    private function normalizeInteger($value)
    {
        if ($value === null || $value === '') {
            return null;
        }

        $value = str_replace([',', '$', ' '], '', $value);

        return ctype_digit((string) $value) ? (int) $value : null;
    }
}