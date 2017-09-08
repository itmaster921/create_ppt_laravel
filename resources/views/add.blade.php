@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              {{--   <div class="panel-heading"><h3>User Profile</h3><span>{{$name}}</span></div> --}}

                <div class="panel-body">
                    <h3>Product Details</h3>
                     {{ Form::open(['url' => 'productSubmit', 'method' => 'post']) }}
                    <table class="table">
                    <tr><td>{{Form::label('Product Name', 'Product Name')}}</td><td>{{Form::text('productName')}}</td></tr> 
                    <tr><td>{!! $errors->first('productName', '<p class="help-block">:message</p>') !!}</td></tr>
                    <tr><td>{{Form::label('Product desciption', 'Product desciption')}}</td><td> {{ Form::textarea('description',null,['class'=>'description','size' => '18x5']) }}</td></tr>
                    <tr><td>{!! $errors->first('description', '<p class="help-block">:message</p>') !!}</td></tr>
                    <tr><td>{{Form::label('product categories', 'Product categories')}}</td><td>{{Form::select('productCategories',[],'list',array('class'=>'product_list'))}}</td></tr> 
                    <tr><td>{{Form::submit('Submit')}}</td></tr>  
                    </table>
                    {{ Form::close() }}
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection