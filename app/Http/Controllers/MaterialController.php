<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMaterialRequest;
use App\Models\Category;
use App\Models\Material;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MaterialController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $subjects = Subject::where('user_id', auth()->user()->id)->get();

        return View('material.index')
            ->with('subjects', $subjects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $subjects = Subject::where('user_id', auth()->user()->id)->get();
        $categories = Category::where('user_id', auth()->user()->id)->get();

        return View('material.create')
            ->with('subjects', $subjects)
            ->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateMaterialRequest $request)
    {
        $material = new Material();


        // todo files table. make file optional, not required,
        // todo maybe students just want to write down some notes
        $file = $request->file('file');
        $material->path = $file->store('materials');
        $material->user_id = auth()->user()->id;

        $material->name = $file->getClientOriginalName();
        $material->details = $request->input('details');
        $material->subject_id = $request->input('subject_id');
        $material->categories = implode(",", $request->input('categories', []));
        $material->save();

        return redirect()->route('material.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Material $material)
    {
        $material->categories = explode(",", $material->categories);

        $categories = Category::whereIn('id', $material->categories)->get();

        return View('material.show')
            ->with('material', $material)
            ->with('categories', $categories);
    }

    /**
     * Display the grouped resources.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function subject(int $subject_id)
    {
        $materials = Material::where('user_id', auth()->user()->id)
            ->where('subject_id', $subject_id)->get();

        $subject = Subject::where('id', $subject_id)->first();

        return View('material.list')
            ->with('subject', $subject)
            ->with('materials', $materials);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Material $material)
    {
        $subjects = Subject::where('user_id', auth()->user()->id)->get();
        $categories = Category::where('user_id', auth()->user()->id)->get();

        // Todo
        $material->categories = explode(",", $material->categories);

        return View('material.edit')
            ->with('material', $material)
            ->with('subjects', $subjects)
            ->with('categories', $categories);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Material $material)
    {
        $subjects = Subject::where('user_id', auth()->user()->id)->pluck('id')->toArray();
        $categories = Category::where('user_id', auth()->user()->id)->pluck('id')->toArray();

        // Todo validate
        $request->validate([
            'file-name' => 'required',
            'details' => 'max:1024',
            'subject_id' => ['required', Rule::in($subjects)],
            'categories' => [Rule::in($categories)]
        ]);

        $material->name = $request->input('file-name');
        $material->details = $request->input('details');
        $material->subject_id = $request->input('subject_id');
        $material->categories = implode(",", $request->input('categories'));
        $material->save();

        return redirect()->route('material.show', $material);

    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function delete(Material $material)
    {
        return View('material.delete')->with('material', $material);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {

    }
}
