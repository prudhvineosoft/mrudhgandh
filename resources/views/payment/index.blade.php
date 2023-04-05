@extends('layouts.master')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid bg-secondary">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 150px">
        <h1 class="font-weight-semi-bold text-uppercase">Payment Status</h1>
    </div>
</div>

<!-- Contact Start -->
 <div class="container-fluid pt-3">
    <div class="mb-4">
        <div class="row px-xl-5">
            <div class="alert {{$status_class}} font-weight-semi-bold mb-3 m-auto" role="alert">
                {{$message}}
            </div>    
        </div>
    </div>
</div>
<!-- Contact End -->

@endsection