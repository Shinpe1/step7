<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class Product extends Model
{

    // モデルに関連付けるテーブル
    protected $table = 'products';

    // テーブルに関連付ける主キー
    protected $primaryKey = 'products_id';

    // 登録・更新可能なカラムの指定
    protected $fillable = [
        'products_id',
        'user_id',
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment',
        'img_path',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class , 'company_id');
    }

    /**
     * 一覧画面表示用にテーブルから全てのデータを取得
     */
    public function findAllProducts()
    {
        $data = Product::all();
        return $data;
    }

/**
     * リクエストされたIDをもとにテーブルのレコードを1件取得
     */
    public function findProductById($id)
    {
        return Product::find($id);
    }

    /**
     * 登録処理
     */
    public function InsertProduct($request,$filename)
    {
        // リクエストデータを基に管理マスターユーザーに登録する
        return $this->create([
        
        'product_name' => $request->product_name,
        'company_id' => $request->company_id,
        'price' => $request->price,
        'stock' => $request->stock,
        'comment' => $request->comment,
        'img_path' => $filename

        ]);
    }

    /**
     * 更新処理
     */
    public function updateProduct($request)
    {
        $result = $product->fill([
            'product_name' => $request->product_name,
            'company_id' => $request->company_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => $request->comment,
            'img_path' => $request->img_path
    
        ])->save();

        return $result;
    }

    /**
     * 削除処理
     */
    public function deleteProductById($id)
    {
        return $this->destroy($id);
    }
//     public function search($request)
// {
//     $query = self::query();
//         if($search = $request->search){ $query->where('product_name', 'LIKE', "%{$search}%"); }
//         if($company_id = $request->input("company_id")){$query->where('company_id', '=', $company_id);}
//         if($min_price = $request->min_price){ $query->where('price', '>=', $min_price); }
//         if($max_price = $request->max_price){ $query->where('price', '<=', $max_price); }
//         if($min_stock = $request->min_stock){ $query->where('stock', '>=', $min_stock); }
//         if($max_stock = $request->max_stock){ $query->where('stock', '<=', $max_stock); }
//         if($sort = $request->sort){ $direction = $request->direction == 'desc' ? 'desc' : 'asc';  
//         $query->orderBy($sort, $direction);
//     }
//     $products = $query->paginate(5);

//     return $products;
// }

}