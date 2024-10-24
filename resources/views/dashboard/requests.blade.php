@extends('layouts.dashApp') <!-- Adjust as per your layout file -->

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
                <td>{{ $prescription->user ? $prescription->user->Fname . ' ' . $prescription->user->Lname : 'No Users'}}</td> <!-- Assuming user relationship is defined in Prescription model -->
                <td>
                    <img src="{{ asset('storage/' . $prescription->pre_details) }}" alt="Prescription" width="100" height="100" />
                </td>
                <td>
                    <a href="{{ route('medicines.store', ['user_id' => $prescription->user_id]) }}" class="btn" style="background-color: lightgreen; color: black;">Go to Store</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

