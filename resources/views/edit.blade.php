@extends('defaultlayout')

@section('contentheader')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endsection

@section('content')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container-fluid">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Info</h3>
            </div>
            <form method="POST" action="/products/{{ $product->id }}">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="productname" placeholder="Name"
                                    value="{{ $product->name }}">
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" class="form-control" name="productprice" placeholder="Price"
                                    value="{{ $product->price }}">
                            </div>
                            <div class="form-group">
                                <label>Details</label>
                                <textarea class="form-control" name="productdetails" placeholder="Details">{{ $product->details }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Publish</label>
                                <div>
                                    <label><input type="radio" name="publish" value="yes"
                                            {{ $product->is_published ? 'checked' : '' }}> Yes</label>
                                </div>
                                <div>
                                    <label><input type="radio" name="publish" value="no"
                                            {{ !$product->is_published ? 'checked' : '' }}> No</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            <!-- /.card-header -->

        </div>
    </div>
@endsection
