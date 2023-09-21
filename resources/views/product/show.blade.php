@extends('layouts.app')

@section('content')
<h1>詳細確認</h1>
<table class="table table-striped">
<thead>
    <tr>
    <th>ID</th>
    <th>商品画像</th>
    <th>商品名</th>
    <th>価格</th>
    <th>在庫数</th>
    <th>メーカー名</th>
    <th>コメント</th>
    </tr>
</thead>
<tbody>
    <tr>
    <td>{{ $product->products_id }}</td>
    <td> <img src="{{ asset('storage/images/'. $product->img_path)}}" class="img-fluid" width = "100px"/></td>
    <td>{{ $product->product_name }}</td>
    <td>{{ $product->price }}</td>
    <td>{{ $product->stock }}</td>
    <td>{{ $product->company->company_name }}</td>
    <td>{{ $product->comment }}</td>
    <td><a href="{{ route('products.edit', ['id'=>$product->products_id])  }}" class="btn btn-info">編集</a></td>
    </tr>
</tbody>
</table>

<a href="{{ route('products') }}" class="btn btn-outline-secondary" role="button">
        <i class="fa fa-reply mr-1" aria-hidden="true"></i>{{ __('◀️ 戻る') }}
        </a>
@endsection