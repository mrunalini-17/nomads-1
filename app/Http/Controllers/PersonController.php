<?php

namespace App\Http\Controllers;

use App\Models\PersonCount;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function savePersonCount(Request $request)
    {
        // Validate the request data
        $request->validate([
            'person_counts.*.name' => 'required|string|max:255',
            'person_counts.*.age' => 'required|integer|min:0',
            'person_counts.*.gender' => 'required|string|in:male,female,other',
            'person_counts.*.category' => 'required|string|in:adult,child,senior_citizen',
            'person_counts.*.count' => 'required|integer|min:1',
        ]);

        // Process the person counts
        foreach ($request->input('person_counts') as $person) {
            // Save each person count to the database
            PersonCount::create([
                'name' => $person['name'],
                'age' => $person['age'],
                'gender' => $person['gender'],
                'category' => $person['category'],
                'count' => $person['count'],
            ]);
        }

        // Redirect or return a response
        return redirect()->back()->with('success', 'Person counts saved successfully.');
    }
}
