@extends('layouts.dashApp')

@section('content')
<div class="container">
    <h2>Customer Requests</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Prescription Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendingPrescriptions as $prescription)
            <tr>
                <td>{{ $prescription->user ? $prescription->user->Fname . ' ' . $prescription->user->Lname : 'No Users'}}</td>
                <td>
                    @if ($prescription->pre_details)
                        <a href="{{ asset('storage/' . $prescription->pre_details) }}" target="_blank">
                            <img src="{{ asset('storage/' . $prescription->pre_details) }}" alt="Prescription" width="150" height="150" />
                        </a>
                    @else
                        <p>No Image Available</p>
                    @endif
                </td>
                <td>
                    <!-- Button to go to the medicine store page -->
                    <a href="{{ route('medicines.storePage', ['user_id' => $prescription->user_id]) }}" class="btn btn-primary mt-2">Go to Med Store</a>


                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection





