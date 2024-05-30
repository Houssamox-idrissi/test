<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Cv;
use Illuminate\Support\Facades\Storage;

class CvController extends Controller
{

    public function index()
    {
        $cvs = Cv::all();
        return response()->json(['cvs' => $cvs], 200);
    }


    public function store(Request $request)
    {
        $request->validate([
            'ecole' => 'required',
            'diplome' => 'required',
            'domaine' => 'required',
            'dateDebut' => 'required|date',
            'dateFin' => 'required|date',
            'activite' => 'required',
            'description' => 'required',
            'competences' => 'required',
            'cvMedia' => 'required|mimes:pdf,doc,docx',
        ]);

        $file_path =  $request->file('cvMedia')->store('public/cv');


        $cv = Cv::create([
            'ecole' => $request->ecole,
            'diplome' => $request->diplome,
            'domaine' => $request->domaine,
            'dateDebut' => $request->dateDebut,
            'dateFin' => $request->dateFin,
            'activite' => $request->activite,
            'description' => $request->description,
            'competences' => $request->competences,
            'cvMedia' => $file_path
        ]);

        return response()->json(['cv' => $cv], 201);
    }

    public function show($id)
    {
        $cv = Cv::findOrFail($id);
        return response()->json(['cv' => $cv], 200);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'ecole' => 'required',
            'diplome' => 'required',
            'domaine' => 'required',
            'dateDebut' => 'required|date',
            'dateFin' => 'required|date',
            'activite' => 'required',
            'description' => 'required',
            'competences' => 'required',
            'cvMedia' => 'nullable|mimes:pdf,doc,docx',
        ]);
        $cv = Cv::findOrFail($id);

        if ($request->hasFile('cvMedia')) {
            Storage::delete($cv->cvMedia);
            $filePath = $request->file('cvMedia')->store('public/cv');
            $cv->cvMedia = $filePath;
        }

        $cv->update([
            'ecole' => $request->ecole,
            'diplome' => $request->diplome,
            'domaine' => $request->domaine,
            'dateDebut' => $request->dateDebut,
            'dateFin' => $request->dateFin,
            'activite' => $request->activite,
            'description' => $request->description,
            'competences' => $request->competences,
        ]);

        return response()->json(['cv' => $cv], 200);
    }



    public function destroy(Cv $id)
    {
        $id->delete();
        return response()->json(['message' => 'CV deleted successfully'], 200);
    }

    public function download($id)
{
    $cv = Cv::findOrFail($id);
    $filePath = $cv->cvMedia;

    if (!Storage::exists($filePath)) {
        return response()->json(['error' => 'File not found'], 404);
    }

    $url = Storage::url($filePath);
    return response()->json(['url' => $url], 200);
}

}
