<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\Subject;
use App\Notifications\TaskReminder;
use App\Services\SubjectService;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    private $subjectService;

    public function __construct(SubjectService $subjectService)
    {
        $this->subjectService = $subjectService;
    }

    public function index()
    {
        $subjects = $this->subjectService->index();
        return response()->json($subjects);
    }

    public function create()
    {
        return View('subject.create');
    }

    public function store(StoreSubjectRequest $request)
    {
        $this->subjectService->store($request->validated());
        return redirect()->route('subject.index');
    }

    public function show(Subject $subject)
    {
        // TODO list tasks, materials, etc this subject owns
        // TODO Add properties to this model
    }

    public function edit(Subject $subject)
    {
        $this->subjectService->authorize($subject->id);
        return View('subject.edit')->with('subject', $subject);
    }

    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $this->subjectService->update($subject, $request->validated());
        return redirect()->route('subject.index');
    }

    public function destroy(Subject $subject)
    {
        $this->subjectService->destroy($subject);
        return redirect()->route('subject.index');
    }
}
