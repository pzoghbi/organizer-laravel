<?php

namespace App\Http\Controllers;

use App\Http\Requests\SoftDeleteMaterialRequest;
use App\Http\Requests\StoreMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Models\Category;
use App\Models\Material;
use App\Models\Subject;
use App\Services\MaterialService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    private $materialService;

    public function __construct(MaterialService $materialService)
    {
        $this->materialService = $materialService;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $subjects = $this->materialService->index();
        $recentMaterials = $this->materialService->getRecentMaterials();

        foreach($recentMaterials as $material) {
            $material->subject = $material->subject; // gets relationship instance. change field name to something else ?
            $material->categories = auth()->user()->categories()->whereIn('id', explode(",", $material->categories))->get();
            // TODO change to created at
            $material->visited_at = \Carbon\Carbon::parse($material->visited_at)->shortRelativeToNowDiffForHumans();
        }

        return response()->json([
            'subjects' => $subjects,
            'recentMaterials' => $recentMaterials
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return View('material.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreMaterialRequest $request)
    {
        $this->materialService->store($request->validated());
        return redirect()->route('material.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Material $material
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Material $material)
    {
        $material = $this->materialService->show($material);
        return response()->json($material);
    }

    /**
     * Display the grouped resources.
     *
     * @param \App\Models\Material $material
     * @return \Illuminate\Contracts\View\View
     */
    public function listBySubject(int $subject_id)
    {
        $materials = $this->materialService->listBySubject($subject_id);
        return View('material.list')->with('materials', $materials);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Material $material
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Material $material)
    {
        $material = $this->materialService->edit($material);
        return View('material.edit')->with('material', $material);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Material $material
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Material $material, UpdateMaterialRequest $request)
    {
        $material = $this->materialService->update($material, $request->validated());
        return redirect()->route('material.show', $material);
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param \App\Models\Material $material
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function delete(Material $material)
    {
        $this->materialService->authorize($material->id, 'No permission to delete this material');
        return View('material.delete')->with('material', $material);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Material $material
     * @return \Illuminate\Http\RedirectResponse
     */

    public function softDelete(Material $material)
    {
        $deleted = $this->materialService->softDelete($material);
        if ($deleted) request()->session()->flash('message', 'Material successfully moved to trash.');
        return redirect()->route('material.list', $material->subject_id);
    }

    public function trash()
    {
        return View('material.trash');
    }

    public function restore(int $material_id)
    {
        $material = $this->materialService->restore($material_id);
        request()->session()->flash('message', $material->name . ' was successfully restored.');
        return redirect()->route('material.list', $material->subject_id);
    }

    public function destroy(int $material_id)
    {
        $material = $this->materialService->destroy($material_id);
        if ($material) request()->session()->flash('message', 'Success');
        else request()->session()->flash('error', 'Destroying failed.');
        return redirect()->route('material.list', $material->subject_id);
    }

    public function emptyTrash()
    {
        $this->materialService->emptyTrash();
        return redirect()->route('material.index');
    }
}
