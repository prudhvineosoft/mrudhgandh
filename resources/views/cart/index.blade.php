@extends('layouts.master')

@section('content')
<!-- Cart Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-bordered text-center mb-0">
                <thead class="bg-secondary text-dark">
                    <tr>
                        <th>Products</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                @php $total = 0 @endphp
                @if(session('cart'))
                @foreach(session('cart') as $id => $details)
                    @php $total += $details['sale_price'] * $details['quantity'] @endphp
                    <tr  data-id="{{ $id }}">
                        <td class="align-middle"><img src="img/product-1.jpg" alt="" style="width: 50px;"> {{$details['name']}}</td>
                        <td class="align-middle">{{$details['sale_price']}}</td>
                        <td class="align-middle">
                            <div class="input-group  mx-auto" style="width: 100px;">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-primary btn-minus update-cart" data-price="{{$details['sale_price']}}" data-value="minus">
                                    <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control form-control-sm quantity bg-secondary text-center" value="{{$details['quantity']}}">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-primary btn-plus update-cart" data-price="{{$details['sale_price']}}" data-value="plus">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle product_total">Rs. {{$details['sale_price'] * $details['quantity']}}</td>
                        <td class="align-middle"><button class="btn btn-sm btn-primary remove-from-cart"><i class="fa fa-times"></i></button></td>
                    </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <div class="col-lg-4">
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3 pt-1">
                        <h6 class="font-weight-medium">Subtotal</h6>
                        <h6 class="font-weight-medium total">Rs {{ $total }}</h6>
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <div class="d-flex justify-content-between mt-2">
                        <h5 class="font-weight-bold">Total</h5>
                        <h5 class="font-weight-bold total">Rs {{ $total }}</h5>
                    </div>
                    <a href="{{route('checkout')}}" class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->
@endsection

@section('scripts')
<script type="text/javascript">
  
    $(".update-cart").click(function (e) {
        e.preventDefault();
  
        var ele = $(this);
        var qty_operation = ele.attr('data-value');
        var price = ele.attr('data-price');
        var product_qty = parseInt(ele.parents("tr").find(".quantity").val());
        var qty = qty_operation=='minus' ? product_qty - 1 : product_qty + 1;
        if(qty > 0){
            console.log(ele.parents("tr").attr("data-id"),qty);
            $.ajax({
                url: "{{ route('update.cart') }}",
                method: "patch",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: ele.parents("tr").attr("data-id"), 
                    quantity: qty 
                },
                success: function (response) {
                    ele.parents("tr").find(".quantity").val(qty);
                    ele.parents("tr").find('.product_total').text('Rs. '+ qty*price);
                    $('.total').text('Rs. '+response.total);
                }
            });
        }
    });
  
    $(".remove-from-cart").click(function (e) {
        e.preventDefault();
  
        var ele = $(this);
  
        if(confirm("Are you sure want to remove?")) {
            $.ajax({
                url: '{{ route('remove.from.cart') }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}', 
                    id: ele.parents("tr").attr("data-id")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });
  
</script>
@endsection
