@extends('layouts.master')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 100px">
            <h1 class="font-weight-semi-bold text-uppercase">{{ $content->slug }}</h1>
        </div>
    </div>

    <!-- Contact Start -->
    <div class="container-fluid pt-3">
        <div class="mb-4">
            <div class="row px-xl-5">
                {!! $content->description !!}
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection
