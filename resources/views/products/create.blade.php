@extends('main')

@section('content')
    <div class="container">
        <h4>Add Product</h4>
        
        <hr>
        
        <div style="margin-top:10px;">
            <form action="/products" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="productName">Product Name</label>
                    <input type="text" class="form-control" name="productName" id="productName"  placeholder="Product Name">
                </div>

                <div class="form-group">
                    <label for="productDescription">Description</label>
                    <textarea name="productDescription" id="productDescription" class="form-control" cols="30" rows="10"  placeholder="Description of product"></textarea>
                </div>

                <div class="form-group">
                    <label for="productImage">Product Image</label>
                    <input type="file" name="productImage" id="productImage">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-default">Submit</button>
                </div>
                
                @include('layout.partials.errors')
            </form>
        </div>
        
    </div>
@endsection