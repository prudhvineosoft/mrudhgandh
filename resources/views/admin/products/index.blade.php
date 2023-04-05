@extends('layouts.admin.master')

@section('content')
<div class="breadcrumb-wrapper">
	<h1>Products</h1>
</div>

<div class="row">
	<div class="col-12">
		<div class="card card-default">
			<div class="card-header card-header-border-bottom d-flex justify-content-between">
				<h2>Products</h2>
                <a href="{{route('admin.product.create')}}" class="btn btn-outline-primary btn-sm text-uppercase">
					<i class=" mdi mdi-plus mr-1"></i> Add Product
				</a>
			</div>
			<div class="card-body">
				<div class="basic-data-table">
					<table id="basic-data-table" class="table nowrap" style="width:100%">
						<thead>
							<tr>
								<th>Name</th>
								<th>Category</th>
								<th>Qty</th>
								<th>Price</th>
								<th>Sale Price</th>
								<th>Image</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
                            @foreach($products as $product)
							<tr>
								<td>{{$product->name}}</td>
								<td>{{$product->category->name}}</td>
								<td>{{$product->quantity}}</td>
								<td>Rs. {{$product->price}}</td>
								<td>Rs. {{$product->sale_price}}</td>
								<td><img src="{{ url('storage/'.$product->image) }}" width="50"></img></td>
								<td><a href="{{route('admin.product.edit',['id'=>$product->id])}}">EDIT</a> | <a href="javascript:void(0);" class="delete-product" data-productId="{{$product->id}}"  >DELETE</a>
								</td>
							</tr>
                            @endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				Are you sure you want to delete this product? 
			</div>
			<div class="modal-footer">
				<form action="{{route('admin.product.delete')}}" method="post">
					@csrf
					<input type="hidden" name="product_id" id="product_id" value="">		
					<button type="button" class="btn btn-primary btn-pill" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-danger btn-pill">Delete</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script>
	$(document).ready(function () {
		$(document).on("click",".delete-product",function() {
			var productId = $(this).attr('data-productId');
			var thisObj = $(this);
			$("#product_id").val(productId);
			$("#exampleModal").modal('show');	
		});
	});
</script>
@endsection