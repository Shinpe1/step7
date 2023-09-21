<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\Product;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->product = new Product();
        $this->company = new Company();
    }

    public function index()
    {
        $companies = $this->company->get();


        return view('product.index', compact('products'));
    }
    /**
     * 登録画面
     */
    public function create(Request $request)
    {
        $companies = $this->company->get();
        return view('product.create', compact('companies'));
    }
}
