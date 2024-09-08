<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function index()
    {
        //Menampilkan daftar training dgn instruktur terkait
        $trainings = Training::with('instructor')->get();
        $instructors = Instructor::all();
        return view('trainings.index', compact('trainings', 'instructors'));
    }

    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'capacity' => 'required|integer',
            'instructor_id' => 'required|exists:instructors,id', 
            // Validasi FK
        ]);

        // Menyimpan training baru ke database
        Training::create($validated);

        return redirect()->route('trainings.index')->with('success', 'Training added successfully.');
    }
}
