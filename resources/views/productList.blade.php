@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              {{--   <div class="panel-heading"><h3>User Profile</h3><span>{{$name}}</span></div> --}}

                <div class="panel-body">
                    <h3>Product List</h3>
                     <table class="table">
                         <tr><th>Product Name</th><th>Description</th><th>Action</th></tr>
                            @foreach ($productList as $product)
                                <tr><td>{{ $product->productName }}</td><td>{{ $product->description }}</td><td><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal" onclick="get_product({{$product->id}})">Edit</button></td><td><button type="button" class="btn btn-danger btn-sm" onclick="del_product({{$product->id}})">Delete</button></td></tr>
                            @endforeach
                    </table>
                    <!-- Modal -->
                    <div id="myModal" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Modal Header</h4>
                          </div>
                          <div class="modal-body">
                               <h3>Product Details</h3>
                                     {{ Form::open(['url' => 'formSubmit', 'method' => 'post']) }}
                                     {!! csrf_field() !!}
                                    <table class="table">
                                    <tr><td>{{Form::label('Product Name', 'Product Name')}}</td><td>{{Form::text('productName',null, array('class'=>'productName form-control'))}}</td></tr> 
                                    <tr><td>{!! $errors->first('productName', '<p class="help-block">:message</p>') !!}</td></tr>
                                    <tr><td>{{Form::label('Product desciption', 'Product desciption')}}</td><td> {{ Form::textarea('description', null, ['class'=>'description','size' => '18x5']) }}</td></tr>
                                    <tr><td>{!! $errors->first('description', '<p class="help-block">:message</p>') !!}</td></tr>
                                    <tr><td>{{Form::label('product categories', 'Product categories')}}</td><td>{{Form::select('productCategories',array('0' => 'Option 1', '1' => 'Option 2'))}}</td></tr> 
                                     {{ Form::hidden('product_id',null, array('id' => 'product_id')) }}
                                    <tr><td>{{Form::submit('Submit')}}</td></tr>  
                                    </table>
                                    {{ Form::close() }}
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>

                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection