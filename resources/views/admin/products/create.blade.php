@extends('layouts.admin.master')

@section('content')
<div class="breadcrumb-wrapper">
	<h1>Create Product</h1>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="card card-default">
			<div class="card-header card-header-border-bottom">
				<h2>Create Product</h2>
			</div>

			<div class="card-body">
				<form method="post" id="create-product" action="{{route('admin.product.store')}}" enctype="multipart/form-data" data-parsley-validate>
					@csrf
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" required>
					</div>
					<div class="form-group">
						<label for="category_id">Category</label>
						<select class="form-control" id="category_id" name="category_id" required>
							<option value="">Select Category</option>
							@foreach($categories as $category)
								<option value="{{$category->id}}">{{$category->name}}</option>
							@endforeach
						</select>
					</div>

					<div class="form-group">
						<label for="qty">Quantity</label>
						<input type="number" class="form-control" id="qty" name="qty" placeholder="Enter Quantity" value="" required>
					</div>
					<div class="form-group">
						<label for="price">Price</label>
						<input type="text" class="form-control" id="price" name="price" placeholder="Enter Price" value="" required>
					</div>
					<div class="form-group">
						<label for="sale_price">Sale Price</label>
						<input type="text" class="form-control" id="sale_price" name="sale_price" placeholder="Enter Sale Price" value="" required>
					</div>

					<div class="form-group">
						<label for="description">Description</label>
						<textarea class="form-control" id="description" name="description" rows="3"></textarea>
					</div>
					<label class="control control-checkbox">Featured Product
						<input type="checkbox" name="is_featured" id="is_featured">
						<div class="control-indicator"></div>
					</label>
					<div class="form-group">
						<label for="image">Image</label>
						<input type="file" class="form-control-file" id="image" name="image" required>
					</div>

					<div class="form-group">
						<label for="image">Other Images</label>
						<input type="file" multiple class="form-control-file" id="multiple_images" name="multiple_images[]">
					</div>

					<div class="form-footer pt-4 pt-5 mt-4 border-top">
						<button type="submit" class="btn btn-primary btn-default">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


@endsection

@section('script')
<script>
$('#create-product').parsley();	
</script>
@endsection