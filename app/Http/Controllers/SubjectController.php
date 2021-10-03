<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $subjects = Subject::where('user_id', auth()->user()->id)->get();

        return View('subject.index')
            ->with('subjects', $subjects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View('subject.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'color' => 'nullable'
        ]);

        $subject = new Subject();
        $subject->name = $request->input('name');
        $subject->user_id = auth()->user()->id;
        $subject->save();

        return redirect()->route('subject.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function edit(int $id)
    {
        $subject = Subject::where('id', $id)->first();

        // Todo show no access or something
        if (auth()->user()->id !== $subject->user_id) {
            return redirect('/');
        }

        return View('subject.edit')
            ->with('subject', $subject);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subject  $subject
     * @return string
     */
    public function update(Request $request, Subject $subject)
    {
        // TODO Validate form
        $request->validate([
            'name' => 'required|max:255',
            'color' => 'nullable'
        ]);

        $subject->name = $request->input('name');
        $subject->color = $request->input('color');
        $subject->save();

        return redirect()->route('subject.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Subject $subject)
    {
        // Todo needs validation
        Subject::destroy($subject->id);

        return redirect()->route('subject.index');
    }
}
