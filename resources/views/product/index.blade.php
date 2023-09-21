@extends('layouts.app')

@section('content')

    <h1>商品情報一覧</h1>


    <a href="{{ route('products.create') }}">商品新規登録</a>

<table class="table table-striped">
<thead>
    <tr>
    <th>ID</th>
    <th>商品画像</th>
    <th>商品名</th>
    <th>価格</th>
    <th>在庫数</th>
    <th>メーカー名</th>
    </tr>
</thead>
<tbody>
    @foreach ($products as $product)
    <tr>
    <td>{{ $product->products_id }}</td>
    <td> <img src="{{ asset('storage/images/'. $product->img_path)}}" class="img-fluid" width = "100px"></td>
    <td>{{ $product->product_name }}</td>
    <td>{{ $product->price }}</td>
    <td>{{ $product->stock }}</td>
    <td>{{ $product->company->company_name}}</td>
    <td><a href="{{ route('products.show',['id'=>$product->products_id]) }}" class="btn btn-primary">詳細表示</a></td>
    <td>
        <form  action="{{ route('products.destroy', ['id'=>$product->products_id]) }}" method="POST" >
        @csrf
        <button type="submit" class="btn btn-danger" onclick= "return confirm('本当に削除しますか？');" >削除</button>
        </form>
    </td>
    </tr>
    @endforeach
</tbody>
</table>

<!-- 検索フォームのセクション -->
<div class="search mt-5">
    
    <!-- 検索のタイトル -->
    <h4>検索</h4>
    
    <!-- 検索フォーム。GETメソッドで、商品一覧のルートにデータを送信 -->
    <form action="{{ route('products') }}" method="GET" class="row g-3">

        <div class="col-sm-12 col-md-3">
            <input type="text" name="product_name" id= "product_name" class="form-control" placeholder="商品名" value="{{ request('product_name') }}">
        </div>

        <div class="col-sm-12 col-md-2">
            <select type="text" name="company_id" id= "company_id" class="form-control"  value="{{ request('company_id') }}">
            <option disabled style='display:none;' @if (empty($product->company_id)) selected @endif>選択してください</option>
    @foreach($companies as $company)
            <option value="{{ $company->company_id }}" @if (isset($product->company_id) && ($product->company_id === $company->company_id)) selected @endif>{{ $company->company_name }}</option>
        @endforeach
        </select>
        </div>

        <!-- 絞り込みボタン -->
        <div class="col-sm-12 col-md-1">
            <button class="btn btn-outline-secondary" type="submit">検索</button>
        </div>
    </form>
</div>

<!-- 検索条件をリセットするためのリンクボタン -->
<a href="{{ route('products') }}" class="btn btn-success mt-3">検索条件を元に戻す</a>




@endsection