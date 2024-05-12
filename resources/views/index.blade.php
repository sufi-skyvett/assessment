@extends('defaultlayout')


@section('contentheader')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Products</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
@endsection


@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ $message }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row justify-content-end mb-3">
                <div class="col-auto text-right"> <!-- Align "Create New Product" button to the right -->
                    <a class="btn btn-success btn-sm" href="{{ route('products.create') }}">Create New Product</a>
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-auto text-right"> <!-- Align search form to the right -->
                    <form action="{{ route('products.search') }}" method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search"
                                value="@isset($searchTerm){{ $searchTerm }}@endisset">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <table id="tableproduct" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Price(RM)</th>
                        <th>Details</th>
                        <th>Publish</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $key => $product)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->details }}</td>
                            <td>{{ $product->is_published ? 'Yes' : 'No' }}</td>
                            <td>
                                <form id="delete-form-{{ $product->id }}"
                                    action="{{ route('products.destroy', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a class="btn btn-info btn-sm" href="{{ route('products.show', $product->id) }}">
                                        
                                        View
                                    </a>
                                    <a class="btn btn-primary btn-sm" href="{{ route('products.edit', $product->id) }}">
                                       
                                        Edit
                                    </a>
                                    <a class="btn btn-danger btn-sm"
                                        onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this product?')) { document.getElementById('delete-form-{{ $product->id }}').submit(); }">
                                        Delete
                                    </a>

                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

    <script>
        $(function() {
            $("#tableproduct").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": true,
                "searching": false // Disable searching feature
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
