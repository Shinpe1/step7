@extends('layouts.app')

@section('content')
<div class="container small">
<h1>商品編集</h1>
<form action="{{ route('products.update', ['id'=>$product->products_id]) }}" method="POST" enctype="multipart/form-data">

@csrf

<table class="table table-striped">


    <fieldset>

    <div class="form-group">
    <div>
        @if ($errors->has('product_name'))
        <h5 style="color:red">{{ $errors->first('product_name') }}</h5>
    @endif
        <label for="product_name">{{ __('商品名') }}</label>
        <input type="text" class="form-name" name="product_name" id="product_name" value="{{ $product->product_name }}" required>
    </div>

    <div class="form-group">
    <div>
        @if ($errors->has('price'))
        <h5 style="color:red">{{ $errors->first('price') }}</h5>
    @endif
        <label for="price">{{ __('価格') }}</label>
        <input type="text" class="form-name" name="price" id="price" value="{{ $product->price }}" required>
    </div>

    <div class="form-group">
    <div>
        @if ($errors->has('stock'))
        <h5 style="color:red">{{ $errors->first('stock') }}</h5>
    @endif
        <label for="stock">{{ __('在庫数') }}</label>
        <input type="text" class="form-name" name="stock" id="stock"value="{{ $product->stock }}" required >
    </div>

    <div class="mb-3">
    <div>
        @if ($errors->has('company_id'))
        <h5 style="color:red">{{ $errors->first('company_id') }}</h5>
    @endif
    <label for="company_id">{{ __('メーカー名') }}</label>
    <select type="text" class="form-select" id="company_id" name="company_id" >
    <option disabled style='display:none;' @if (empty($product->company_id)) selected @endif>選択してください</option>
    @foreach($companies as $company)
            <option value="{{ $company->company_id }}" @if (isset($product->company_id) && ($product->company_id === $company->company_id)) selected @endif>{{ $company->company_name }}</option>
        @endforeach
    </select> 
        
    <div class="form-group">
        <label for="comment">{{ __('コメント') }}</label>
        <input type="text" class="form-name" name="comment" id="comment" value="{{ $product->comment }}" required>
    </div>

    <div>
            <label for="img_path">{{ __('商品画像') }}</label>
            <input type="file" class="form-" name="img_path" id="img_path">
            <img src="{{ asset('storage/images/'. $product->img_path)}}" class="img-fluid" width = "100px">
        <div class="d-flex justify-content-between pt-3">
</dit>

    

        <a href="{{ route('products.show',['id'=>$product->products_id]) }}" class="btn btn-outline-secondary" role="button">
            <i class="fa fa-reply mr-1" aria-hidden="true"></i>{{ __('◀️ 戻る') }}
        </a>

        <button type="submit" class="btn btn-success" onclick= "return confirm('更新しますか？');">
            {{ __('更新') }}
        </button>
    </div>
    </fieldset>
</form>
</div>
@endsection