@extends('layouts.app')

@section('content')
<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="h3 mb-5 text-black">Welcome to the Main Page</h2>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(isset($prescription))  <!-- Check if prescription exists -->
            @if($prescription->status === 'completed')
                <p class="mb-4">Your request has been processed. Please review your bill below.</p>
                <a href="{{ route('prescriptions.bill', $prescription->id) }}" class="btn btn-primary">View Bill</a>
            @elseif($prescription->status === 'pending')
                <p class="mb-4">Your request is sent! Just wait 10-20 minutes.</p>
                <!-- Optionally, you could add an HTML element to display a spinner or loading animation -->
            @else
                <p class="mb-4">Your prescription is currently in {{ $prescription->status }} state.</p>
            @endif
        @else
            <!-- Show form if no prescription and user is not logged out -->
            <div class="row">
                <div class="col-md-12">
                    <h3 class="mb-4">Please add your prescription</h3>
                    <form action="{{ route('prescriptions.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="pre_details">Choose a photo to upload:</label>
                            <input type="file" class="form-control" id="pre_details" name="pre_details" accept="image/*" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Photo</button>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection



