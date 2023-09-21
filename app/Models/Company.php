<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Company extends Model
{
     // モデルに関連付けるテーブル
    protected $table = 'companies';

     // テーブルに関連付ける主キー
    protected $primaryKey = 'company_id';

     // 登録・更新可能なカラムの指定
    protected $fillable = [
        'company_id',
        'company_name'
    ];

    /**
      * 一覧画面表示用にテーブルから全てのデータを取得
      */
    public function findAllCompany()
    {
        $data = Company::all();
        return $data;
    }


/**
     * 投稿の取得(モデルとのリレーション)
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'company_id');
    }
}
