<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{

    public function showBill($id)
    {
        $prescription = Prescription::findOrFail($id);
        return view('prescriptions.bill', compact('prescription'));
    }

    public function requests()
    {
        // Fetch all pending prescriptions with the related user
        $pendingPrescriptions = Prescription::with('user') // Assuming you have a relationship with User model
        ->where('status', 'pending')
        ->get();
        
        return view('dashboard.requests', compact('pendingPrescriptions'));
    }

    // for notifications in the sidebar
    public function getPendingCount()
    {
        return Prescription::where('status', 'pending')->count();
    }
    

    public function index()
    {
        $prescriptions = Prescription::all(); 
        return view('dashboard.prescriptions', ['prescriptions' => $prescriptions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    






    public function store(Request $request)
    {
        $request->validate([
            'pre_details' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        // Handle image upload
        $imagePath = $request->file('pre_details')->store('assets/dashboard/images/img', 'public');
    
        // Create a new prescription
        $prescription = new Prescription();
        $prescription->status = 'pending';
        $prescription->pre_details = $imagePath; 
        $prescription->user_id = auth()->id();
        $prescription->save(); 
    
        return redirect()->route('main')->with('success', 'Your request is sent! Wait 10-20 minutes.'); // Change to the route for your main page
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Prescription $prescription)
    {
        //
    }

    


    public function edit($id)
    {
        $prescription = Prescription::find($id); // Fetch the medicine by ID
        if (!$prescription) {
            return redirect()->back()->with('error', 'Prescription not found.');
        }
        return view('dashboard.edit_prescription', compact('prescription'));
    }

    


    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
            'bill' => 'nullable|string|required_if:status,completed',
        ]);
    
        // Find the prescription by ID
        $prescription = Prescription::find($id);
    
        if ($prescription) {
            // Update the status
            $prescription->status = $request->status;
    
            // If the status is 'completed', update the bill
            if ($request->status === 'completed') {
                $prescription->bill = $request->bill;  // Assign bill content
            }
    
            // Save changes
            $prescription->save();
    
            return redirect()->route('prescriptions.index')->with('success', 'Prescription updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Prescription not found.');
        }
    
    }

    

    public function destroy($id)
    {
        $prescription = Prescription::findOrFail($id); 
        $prescription->delete(); 
    
        return redirect()->route('prescriptions.index');
    }
}
