<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('products', compact('products'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx'
        ]);

        try {
            Excel::import(
                new ProductsImport,
                $request->file('file')
            );
        } catch (ValidationException $e) {
            $errors = collect($e->failures())
                ->map(fn($failure) => 'Row '.$failure->row().': '.implode(', ', $failure->errors()))
                ->implode(' ');

            return back()->with('error', 'Import failed: '.$errors);
        } catch (\Throwable $e) {
            return back()->with('error', 'Import failed: '.$e->getMessage());
        }

        return back()->with(
            'success',
            'Products Imported Successfully!'
        );
    }

    public function export()
    {
        return Excel::download(
            new ProductsExport,
            'products.xlsx'
        );
    }
}