@extends('layouts.app')

@section('content')
<div class="container small">
<h1>商品新規登録</h1>



<form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">

@csrf
    <fieldset>
        <div class="form-group">
        
        <div>
        @if ($errors->has('product_name'))
        <h5 style="color:red">{{ $errors->first('product_name') }}</h5>
    @endif
            <label for="product_name">{{ __('商品名') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
            <input type="text" class="form-control" name="product_name" id="product_name">
        <div class="d-flex justify-content-between pt-3">
            
</dit>

        <div>
        @if ($errors->has('company_id'))
        <h5 style="color:red">{{ $errors->first('company_id') }}</h5>
    @endif
        <label for="company_id">{{ __('メーカー名') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
    <select type="text" class="form-control" id="company_id" name="company_id">
    <option disabled style='display:none;' @if (empty($product->company_id)) selected @endif>選択してください</option>
    @foreach($companies as $company)
            <option value="{{ $company->company_id }}" @if (isset($product->company_id) && ($product->company_id === $company->company_id)) selected @endif>{{ $company->company_name }}</option>
        @endforeach
    </select>
    </label>
</dit>

        <div>
        @if ($errors->has('price'))
        <h5 style="color:red">{{ $errors->first('price') }}</h5>
    @endif
            <label for="price">{{ __('価格') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
            <input type="text" class="form-control" name="price" id="price">
        <div class="d-flex justify-content-between pt-3">
</dit>


        <div>
        @if ($errors->has('stock'))
        <h5 style="color:red">{{ $errors->first('stock') }}</h5>
    @endif
            <label for="stock">{{ __('在庫数') }}<span class="badge badge-danger ml-2">{{ __('必須') }}</span></label>
            <input type="text" class="form-control" name="stock" id="stock">
        <div class="d-flex justify-content-between pt-3">
</dit>

        <div>
            <label for="comment">{{ __('コメント') }}</label>
            <input type="textarea" class="form-control" name="comment" id="comment">
        <div class="d-flex justify-content-between pt-3">
</dit>

        <div>
            <label for="img_path" class="form-label" >{{ __('商品画像') }}</label>
            <input type="file" class="form-" name="img_path" id="img_path">
        <div class="d-flex justify-content-between pt-3">
</dit>

        <a href="{{ route('products') }}" class="btn btn-outline-secondary" role="button">

                <i class="fa fa-reply mr-1" aria-hidden="true"></i>{{ __('◀️ 戻る') }}
            </a>
            <button type="submit" class="btn btn-success" onclick= "return confirm('登録しますか？');">
                {{ __('登録') }}
            </button>
        </div>
    </fieldset>
</form>
</div>
@endsection