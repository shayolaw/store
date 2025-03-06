@extends('layouts.app')
@section("content")
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Product Form</h1>
                @isset($product)
                    <h2>Edit Product</h2>
                    <form action="{{route('products.update', $product->id)}}" method="POST">
                        @method('PUT')
                        @csrf
                @else
                    <h2>Create Product</h2>
                    <form action="{{route('products.store')}}" method="POST">
                @endif
                    <div class="form-group
                        @error('name')
                            has-error
                        @enderror">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                        value = "{{
                             (isset($product) && old('name') == null) ? $product->name : old('name')
                        }}"
                        >
                        @error('name')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description">
                                @isset($product)
                                    {{$product->description}}
                                @endisset
                        </textarea>
                        @error('description')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" class="form-control" id="price" name="price" value="
                        @isset($product)
                            {{$product->price}}

                        @endisset
                        ">
                        @error('price')
                            <span class="help-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
    @isset($products)
        @foreach($products as $p)
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1>Product List</h1>
                        <h2>{{$p->name}}</h2>
                        <p>{{$p->description}}</p>
                        <p>{{$p->price}}</p>
                        <form action="{{route('products.destroy', $p->id)}}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endisset
@endsection
