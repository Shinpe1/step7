@extends('layouts.app')

@section('content')

    <h1>商品情報一覧</h1>


    <a href="{{ route('products.create') }}"class="btn btn-primary">商品新規登録</a>


    <!-- 検索フォームのセクション -->

<div class="search mt-5">
    
{{ $products->appends(request()->query())->links() }}

    <!-- 検索のタイトル -->
    <h4>検索</h4>

    <div id="ajax"></div>
    
    <!-- 検索フォーム。GETメソッドで、商品一覧のルートにデータを送信 -->
    <form action="{{ route('products') }}" method="GET" class="row g-3" id ="search-form">

        <div class="col-sm-12 col-md-3">
            <input type="text" name="product_name" id= "product_name" class="form-control" placeholder="商品名" value="{{ request('product_name') }}">
        </div>

        <div class="col-sm-12 col-md-2">

            <select type="text" name="company_id" id= "company_id" class="form-control"  value="{{ request('company_id') }}">
            <option value="">選択してください</option>
            <option disabled style='display:none;' @if (empty($product->company_id)) selected @endif>選択してください</option>

    @foreach($companies as $company)
    
            <option value="{{ $company->company_id }}"> {{ $company->company_name }}</option>

        @endforeach

        </select>

        </div>

        <!-- 最小価格の入力欄 -->
        <div class="col-sm-12 col-md-2">
            <input type="number" name="min_price" id= "min_price" class="form-control" placeholder="最小価格" value="{{ request('min_price') }}">
        </div>

        <!-- 最大価格の入力欄 -->
        <div class="col-sm-12 col-md-2">
            <input type="number" name="max_price" id= "max_price" class="form-control" placeholder="最大価格" value="{{ request('max_price') }}">
        </div>

        <!-- 最小在庫数の入力欄 -->
        <div class="col-sm-12 col-md-2">
            <input type="number" name="min_stock" id= "min_stock" class="form-control" placeholder="最小在庫" value="{{ request('min_stock') }}">
        </div>

        <!-- 最大在庫数の入力欄 -->
        <div class="col-sm-12 col-md-2">
            <input type="number" name="max_stock"id= "max_stock"  class="form-control" placeholder="最大在庫" value="{{ request('max_stock') }}">
        </div>


        <!-- 絞り込みボタン -->
        <div class="col-sm-12 col-md-1">
            <button class="btn btn-outline-secondary" type="submit">検索</button>
        </div>
    </form>
</div>

<!-- 検索条件をリセットするためのリンクボタン -->
<a href="{{ route('products') }}" class="btn btn-success mt-3">検索条件を元に戻す</a>


<table class="table table-striped" id = product_table>
<thead>
<tr>
    <th>ID
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'products_id', 'direction' => 'asc']) }}">↑</a>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'products_id', 'direction' => 'desc']) }}">↓</a>
    </th>
    <th>商品画像</th>
    <th>商品名
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'product_name', 'direction' => 'asc']) }}">↑</a>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'product_name', 'direction' => 'desc']) }}">↓</a>
    </th>
    <th>価格
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'price', 'direction' => 'asc']) }}">↑</a>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'price', 'direction' => 'desc']) }}">↓</a>
    </th>
    <th>
        在庫数
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'stock', 'direction' => 'asc']) }}">↑</a>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'stock', 'direction' => 'desc']) }}">↓</a>
    </th>
    <th>メーカー名
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'company_id', 'direction' => 'asc']) }}">↑</a>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'company_id', 'direction' => 'desc']) }}">↓</a>
    </th>
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
        <form   action="{{ route('products.destroy', ['id'=>$product->products_id]) }}" method="POST" >
        @csrf
        <button type="submit" class="btn btn-danger"  data-product-id = "{{ $product->products_id }}"  >削除</button>
        </form>
    </td>
    </tr>
    @endforeach
</tbody>

</table>

@endsection
