<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\Language;
use App\Enums\Program;
use App\Enums\Sexe;
use App\Http\Requests\StudentRequest;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class StudentController extends Controller
{
    private function transformStudent(Student $student): array
    {
        return [
            'id' => $student->id,
            'name' => $student->name,
            'email' => $student->email,
            'sexe' => $student->sexe->value,
            'programs' => $student->programs,
            'profile_url' => $student->profile_url,
            'country' => $student->country,
            'language' => $student->language->value,
            'bio' => $student->bio,
            'created_at' => optional($student->created_at)->format('d/m/Y'),
        ];
    }

    private function handleProfileUpload(Request $request, ?Student $student = null): ?string
    {
        if ($request->hasFile('profile')) {
            if ($student?->profile) {
                Storage::disk('public')->delete($student->profile);
            }

            return $request->file('profile')->store('students/profiles', 'public');
        }

        return $student?->profile;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $students = Student::latest()
            ->paginate(7)
            ->withQueryString()
            ->through(fn (Student $student) => $this->transformStudent($student));

        return Inertia::render('courses/students/DashboardStudents', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('courses/students/CreateStudents', [
            'sexeOptions' => Sexe::options(),
            'languageOptions' => Language::options(),
            'programOptions' => Program::options(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['profile'] = $this->handleProfileUpload($request);

        Student::create($validated);

        return redirect()->route('students.index')
            ->with('success', 'Étudiant créé avec succès.');
    }

    public function show(Student $student): Response
    {
        return Inertia::render('courses/students/ShowStudents', [
            'student' => $this->transformStudent($student),
        ]);
    }

    public function edit(Student $student): Response
    {
        return Inertia::render('courses/students/EditStudents', [
            'student' => $this->transformStudent($student),
            'sexeOptions' => Sexe::options(),
            'languageOptions' => Language::options(),
            'programOptions' => Program::options(),
        ]);
    }

    public function update(StudentRequest $request, Student $student)
    {
        $validated = $request->validated();
        $validated['profile'] = $this->handleProfileUpload($request, $student);

        $student->update($validated);

        return redirect()->route('students.index')
            ->with('success', 'Étudiant mis à jour avec succès.');
    }

    public function destroy(Student $student)
    {
        if ($student->profile) {
            Storage::disk('public')->delete($student->profile);
        }

        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Étudiant supprimé avec succès.');
    }
}
