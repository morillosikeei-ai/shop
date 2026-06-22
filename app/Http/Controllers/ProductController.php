<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

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

        Excel::import(
            new ProductsImport,
            $request->file('file')
        );

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