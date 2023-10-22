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

    // 最小価格が指定されている場合、その価格以上の商品をクエリに追加
    if($min_price = $request->min_price){
        $query->where('price', '>=', $min_price);
    }

    // 最大価格が指定されている場合、その価格以下の商品をクエリに追加
    if($max_price = $request->max_price){
        $query->where('price', '<=', $max_price);
    }

    // 最小在庫数が指定されている場合、その在庫数以上の商品をクエリに追加
    if($min_stock = $request->min_stock){
        $query->where('stock', '>=', $min_stock);
    }

    // 最大在庫数が指定されている場合、その在庫数以下の商品をクエリに追加
    if($max_stock = $request->max_stock){
        $query->where('stock', '<=', $max_stock);
    }

    $companies = $this->company->get();
    $posts = Product::sortable()->get();
    $products = $query->paginate(10)->appends($request->all());

    if($sort = $request->sort){
        $direction = $request->direction == 'desc' ? 'desc' : 'asc'; 
// もし $request->direction の値が 'desc' であれば、'desc' を返す。
// そうでなければ'asc' を返す
        $query->orderBy($sort, $direction);
// orderBy('カラム名', '並び順')

    }
    
    return view('product.index', compact('products'), ['companies' => $companies])->with('posts', $posts);;

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

        DB::transaction(function () use($request) {
            
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
        }else{
            $product->img_path = null;
        }

        $product -> save();
    });
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
    }

    /**
     * 削除処理
     */
    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $product = Product::find($id);

            $product->delete();
    });
        return redirect()->route('products');
    }

    
}
