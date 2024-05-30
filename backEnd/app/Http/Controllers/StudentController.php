<?php
// app/Http/Controllers/StudentController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller  
{
    public function index()
    {
        $students = Student::all();
        return response()->json($students);
    }

    public function show($id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }
        return response()->json($student);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'course' => 'required|string'
        ]);

        $student = Student::create([
          'name' =>$request->name,
          'course' => $request->course
        ]);
        return response()->json($student, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'course' => 'required|string'
        ]);

        $student = Student::find($id);

        $student
        ->update([
            'name' =>$request->name,
            'course' => $request->course
          ]);
        return response()->json($student);
    }

    public function edit($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }

        return response()->json($student);
    }

    public function destroy( Student $id)
    {
        $id->delete();
        return response()->json(['message' => 'Student deleted']);
    }
}
