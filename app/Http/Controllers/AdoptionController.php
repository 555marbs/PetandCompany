<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use App\Models\AdoptionApplication;
use Illuminate\Http\Request;

class AdoptionController extends Controller
{
    public function index()
    {
        $adoptions = Adoption::all();
        return view('dashboard.adoption', compact('adoptions'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:30',
            'content' => 'required|string',
            'contact' => 'required|string',
            'image' =>'image|mimes:jpeg,png,jpg,gif',

        ]);


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(storage_path('app/public/image'), $imageName);
            $validatedData['image'] = '/storage/image/'.$imageName;
        } else {
            $validatedData['image'] = null;
        }
        $validatedData['user_id'] = auth()->user()->id;
        Adoption::create($validatedData);
        return redirect('/adoptions');
    }


    public function update(Request $request, $id)
    {
        $adoptions = Adoption::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:30',
            'contact' => 'required|string|max:255',
            'content' => 'required|string',
            'image' =>'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->extension();
            $image->move(storage_path('app/public/image'), $imageName);
            $validatedData['image'] = '/storage/image/'.$imageName;
        }

        $adoptions->update($validatedData);

        return $adoptions;
    }

    public function destroy($id)
    {
        $adoptions = Adoption::findOrFail($id);
        $adoptions->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }

    public function viewApplications()
    {
        $applications = AdoptionApplication::with('user', 'adoption')->get();

        $groupedApplications = $applications->groupBy('adoption_id');

        return view('dashboard.applications', ['groupedApplications' => $groupedApplications]);
    }



}
