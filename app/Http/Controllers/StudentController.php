<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Student::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {
        $student = DB::transaction(function () use ($request) {
            $student = Student::create($request->validated('student'));
            
            $student->address()->create($request->validated('address'));

            if (array_key_exists('guardians', $request->validated()))
                $student->guardians()->createMany($request->validated('guardians'));

            return $student;
        });

        return redirect()->route('students.show', $student);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return $student;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentRequest $request, Student $student)
    {
        DB::transaction(function () use ($request, $student) {
            $student->update($request->validated('student'));

            $student->address()->update($request->validated('address'));

            $student->guardians->delete();
            if ($request->has('guardians'))
                $student->guardians()->createMany($request->validated('guardians'));
        });

        return redirect()->route('students.show', $student);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index');
    }
}
