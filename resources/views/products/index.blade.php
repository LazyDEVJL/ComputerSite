@extends('layouts.app')
@section('content')
    <h3 class="text-center mt-5">Danh sách sản phẩm</h3> <hr>
    <p class="text-center">
        <a href="<?=action('ProductController@create')?>" class="btn btn-primary"><i class="fa fa-plus"></i> Thêm sản phẩm</a>
    </p>
    <div class="row">
        <div class="col-lg-10 offset-lg-1 text-center">
            <div class="row pt-lg-3 pb-lg-3 mb-lg-4 bg-primary text-white font-weight-bold">
                <div class="col-lg-1">ID</div>
                <div class="col-lg-2">Product Name</div>
                <div class="col-lg-1">Price</div>
                <div class="col-lg-1">Discount</div>
                <div class="col-lg-2">Discounted Price</div>
                <div class="col-lg-1">Image</div>
                <div class="col-lg-2">Slug</div>
                <div class="col-lg-1">Show/Hide</div>
                <div class="col-lg-1">Action</div>
            </div>
            <?php foreach($products as $product):?>
            <div class="row pt-lg-3 pb-lg-3">
                <div class="col-lg-1">{{ $product->id }}</div>
                <div class="col-lg-2">{{ $product->name }}</div>
                <div class="col-lg-1">{{ $product->price }}</div>
                <div class="col-lg-1">{{ $product->discount }}</div>
                <div class="col-lg-2">{{ $product->discounted_price }}</div>
                <div class="col-lg-1">
                    <img src="{{ $product->image }}" width="100">
                </div>
                <div class="col-lg-2">{{ $product->slug }}</div>
                <div class="col-lg-1">{{ $product->active == 1 ? 'Show' : 'Hide' }}</div>
                <div class="col-lg-1">
                    <a href="<?=action('ProductController@edit', ['id' => $product->id])?>" class="btn btn-secondary"><i class="fa fa-edit text-white"></i></a>
                    <a onclick="return confirm('Bạn có chắc chắn muốn xoá không?');" href="<?=action('ProductController@destroy', ['id' => $product->id])?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
@endsection