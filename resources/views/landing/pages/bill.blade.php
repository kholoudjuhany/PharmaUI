@extends('layouts.app')

@section('content')
<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="h3 mb-5 text-black">Your Bill</h2>
                <p>{{ $prescription->bill }}</p>
                <a href="{{ route('confirmOrder', $prescription->id) }}" class="btn btn-success">Confirm Order</a>
                <a href="{{ route('cancelOrder', $prescription->id) }}" class="btn btn-danger">Cancel Order</a>
            </div>
        </div>
    </div>
</div>
@endsection
