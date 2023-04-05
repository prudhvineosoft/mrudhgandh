@extends('layouts.admin.master')

@section('css')
<link href="{{asset('admin/assets/plugins/data-tables/responsive.datatables.min.css')}}" rel='stylesheet'>
@endsection
@section('content')
<div class="breadcrumb-wrapper">
	<h1>Orders Details</h1>
</div>

<div class="row">
	<div class="col-12">
		<div class="card card-default">
			<div class="card-header card-header-border-bottom d-flex justify-content-between">
				<h2>Order {{$order->id}}</h2>
			</div>
			<div class="card-body">
				<div class="responsive-data-table" id="responsive-data-table_wrapper">
					<table id="responsive-data-table" class="table dt-responsive nowrap" style="width:100%">
						<thead>
							<tr>
								<th>Image</th>
								<th>Name</th>
								<th>Price</th>
								<th>Qty</th>
							</tr>
						</thead>
						<tbody>
                            @foreach($order->orderItems as $item)
							<tr>
                                <td>@if($item->product)<img src="{{ url('storage/'.$item->product->image) }}" width="50"></img>@endif</td>
								<td>{{$item->product ? $item->product->name : ''}}</td>
								<td>{{$item->price}}</td>
								<td>{{$item->quantity}}</td>
							</tr>
                            @endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script src="{{asset('admin/assets/plugins/data-tables/datatables.responsive.min.js')}}"></script>
@endsection