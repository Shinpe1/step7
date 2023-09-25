<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->product = new Product();
        $this->company = new Company();

    }

    /**
     * 一覧画面
     */
    public function index(Request $request)
    {
        $products = $this->product->findAllProducts();
        $user = auth()->user();
        $companies = $this->company->get();

         // Productモデルに基づいてクエリビルダを初期化
    $query = Product::query();
    // この行の後にクエリを逐次構築していきます。
    // そして、最終的にそのクエリを実行するためのメソッド（例：get(), first(), paginate() など）を呼び出すことで、データベースに対してクエリを実行します。
    

    if($product_name = $request->product_name){
        $query->where('product_name', 'LIKE', "%{$product_name}%");
    }

    if($company_id = $request->company_id){
        $query->where('company_id', 'LIKE', "$company_id");
    }
    
    $companies = $this->company->get();
    $products = $query->paginate(10);

    
        return view('product.index', compact('products'), ['companies' => $companies]);
    }

    /**
     * 登録画面
     */
    public function create(Request $request)
    {

        $companies = $this->company->get();


        return view('product.create', compact('companies'));
    } 
    


    /**
     * 登録処理
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'company_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ],
        [
            'product_name.required' => '商品名は必須です。',
            'company_id.required' => 'メーカー名は必須項目です。',
            'price.required' => '価格は必須です。',
            'stock.required' => '在庫数は必須項目です。'
        
        ]);

        // $img = $request->file('img_path')->getClientOriginalName();
        // $img_path = Str::random(40) . '.' . $img;


        DB::transaction(function () use($request, $img_path) {
            
            $product = new Product();
            $product -> product_name = $request -> product_name;
            $product -> company_id = $request -> company_id;
            $product -> price = $request -> price;
            $product -> stock = $request -> stock;
            $product -> comment = $request -> comment;
                
        if($request ->file('img_path')){
            $img = $request->file('img_path')->getClientOriginalName();
            $path = Str::random(40) . '.' . $img;
            $filePath = $request -> file('img_path') ->storeAs('public/images', $path);
            
            $product -> img_path = $path;
            // $filePath = $request -> file('img_path') ->storeAs('public/images', $img_path);
            // $img = $request->file('img_path')->getClientOriginalName();
            // $img_path = Str::random(40) . '.' . $img;

            // $product -> img_path = $img_path;
        }else{
            $product->img_path = null;
        }

        $product -> save();
    });

       // $registerProducts = $this->product->InsertProduct($request,$filename);

        return redirect()->route('products');
    }

    /**
     * 詳細画面の表示
     */
    public function show($id)
    {
        $product = Product::find($id);

        return view('product.show', compact('product'));
    }

    /**
     * 編集画面の表示
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $companies = $this->company->get();

        return view('product.edit', compact('product'))
        ->with('companies', $companies)
        ->with(['defaultName' => 'product_name','price', 'stock','company_id','comment']);
    }
    

    /**
     * 更新処理
     */
    
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'product_name' => 'required',
            'company_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ],
        [
            'product_name.required' => '商品名は必須です。',
            'company_id.required' => 'メーカー名は必須項目です。',
            'price.required' => '価格は必須です。',
            'stock.required' => '在庫数は必須項目です。'
        
        ]);

        

        DB::transaction(function () use($request, $id) {
            
            $product = Product::find($id);
            $product -> product_name = $request -> product_name;
            $product -> company_id = $request -> company_id;
            $product -> price = $request -> price;
            $product -> stock = $request -> stock;
            $product -> comment = $request -> comment;
                
        if($request ->file('img_path')){
            $img = $request->file('img_path')->getClientOriginalName();
            $path = Str::random(40) . '.' . $img;
            $filePath = $request -> file('img_path') ->storeAs('public/images', $path);
            
            $product -> img_path = $path;
        }

        $product -> save();
    });

        return redirect()->route('products');
            //     $filename = $request->img_path->getClientOriginalName();
            //     $filePath = $request->img_path->storeAs('public/images', $filename);  
            // }
            // if(request('img_path')){
            // }else{
            //     $img_path = '';
            
            
        // $updateProduct = $this->product->updateProduct($request, $product);
    
    }

    /**
     * 削除処理
     */
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $product = Product::find($id);

            $product->delete();
        // 指定されたIDのレコードを削除
        // $deleteProduct = $this->product->deleteProductById($id);
        // 
        
    });
        return redirect()->route('products');
    }

}
