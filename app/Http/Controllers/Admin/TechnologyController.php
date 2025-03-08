<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Inc\Technology;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class TechnologyController extends Controller
{
    function toAdminTechnology()
    {
        $technologies = Technology::get();
        return view('admin.technologies.technology', compact('technologies'));
    }




    public function toAdminTechnologyStore(Request $request)
    {
        try {
            // Validate the request
            $validatedData = $request->validate([
                'technology' => 'required|unique:technologies,name',
                'description' => 'nullable|string',
            ]);
            // Create and save the technology
            $technology = new Technology();
            $technology->name = $validatedData['technology'];
            $technology->slug = Str::slug($validatedData['technology']);
            $technology->description = $validatedData['description'] ?? null;
            $technology->image = $request->photo;
            $technology->status = $request->status;
            $technology->save();

            return redirect()->back()->with('success', 'Technology added successfully!');
        } catch (ValidationException $e) {
            // Return validation error messages
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Throwable $th) {
            // Handle other exceptions
            return redirect()->back()->with('error', 'Something went wrong! ' . $th->getMessage());
        }
    }

    function toAdminTechnologyDelete($id)
    {
        try {
            // Fetch the CustomPage with its relations
            $customPage = Technology::findOrFail($id);


            // Attempt to delete the page
            if ($customPage->delete()) {
                return response()->json(['success' => 'Item deleted successfully.'], 200);
            }

            // Handle unexpected failure to delete
            return response()->json(['error' => 'Item could not be deleted.'], 500);
        } catch (\Exception $e) {
            // Handle any unexpected exceptions
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }


    function toAdminTechnologyUpdate(Request $request)
    {
        // dd($request->all());
        try {
            // Validate the request
            $validatedData = $request->validate([
                'id' => 'required|exists:technologies,id',
                'name' => 'required|unique:technologies,name,' . $request->id,
                'description' => 'nullable|string',
            ]);
            // Create and save the technology
            $technology = Technology::find($request->id);
            $technology->name = $validatedData['name'];
            $technology->slug = Str::slug($validatedData['name']);
            $technology->description = $validatedData['description'] ?? null;
            $technology->image = $request->image;
            $technology->status = $request->status;
            $technology->save();

            return redirect()->back()->with('success', 'Technology added successfully!');
        } catch (ValidationException $e) {
            // Return validation error messages
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Throwable $th) {
            // Handle other exceptions
            return redirect()->back()->with('error', 'Something went wrong! ' . $th->getMessage());
        }
    }
}
