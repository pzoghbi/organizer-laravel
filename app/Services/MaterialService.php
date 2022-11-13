<?php


namespace App\Services;

use App\Models\Material;
use App\Models\Subject;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MaterialService
{
    /**
     * Returns subject categories for materials
     *
     * @return Subject collection
     */
    public function index()
    {
        $material_groups = Material::where('user_id', auth()->id())->pluck('subject_id')->toArray();
        return Subject::where('user_id', auth()->id())->whereIn('id', $material_groups)->get();
    }

    public function getRecentMaterials(){
        return auth()->user()->recentMaterials();
    }

    public function listBySubject($subject_id)
    {
        // Authorize Subject
        $subjects = auth()->user()->subjects()->pluck('id')->toArray();
        abort_unless(
            in_array($subject_id, $subjects),
            403,
            'You do not have the permission to view this subject resource.'
        );

        $materials = auth()->user()->materials()->where('subject_id', $subject_id)->get();
        return $materials;
    }

    public function show($material)
    {
        $this->authorize($material->id);
        $this->updateLastVisited($material);
        $material->save();
        return $material;
    }

    public function store($data)
    {
        $material = new Material();

        // todo make file upload optional
        Log::debug($data);
        // Permanent data
        $material->user_id = auth()->id();
        $file = $data['file'];
        $material->path = $file->store('materials');

        $material->name = $file->getClientOriginalName();
        $material->subject_id = $data['subject_id'];

        // Failsafing non-required fields
        $material->details = isset($data['details']) ? $data['details'] : null;
        $material->categories = implode(",", isset($data['categories']) ? $data['categories'] : []);
        $this->updateLastVisited($material);

        Log::debug($material);
        $material->save();
    }

    public function edit($material)
    {
        $this->authorize($material->id);
        $this->updateLastVisited($material);
        $material->save();
        return $material;
    }

    public function update($material, $data)
    {
        $this->authorize($material->id);

        $material->name = $data['file-name'];
        $material->details = $data['details'];
        $material->subject_id = $data['subject_id'];
        $material->categories = implode(",", isset($data['categories']) ? $data['categories'] : []);
        $this->updateLastVisited($material);

        $material->save();
        return $material;
    }

    public function softDelete($material)
    {
        $this->authorize($material->id);
        return Material::destroy($material->id);
    }

    public function restore($material_id)
    {
        $this->authorize($material_id, 'You have no permission to this material resource.');
        $material = Material::onlyTrashed()->where('id', $material_id)->firstOrFail();
        $this->updateLastVisited($material);
        if ($material->restore()) return $material;
        else return false;
    }

    /**
     * Permanently delete material resource
     * and delete the file from the disk
     *
     * @param $material_id
     * @return Material
     */
    public function destroy($material_id)
    {
        $this->authorize($material_id);
        $material = Material::onlyTrashed()->where('id', $material_id)->first();
        $material->forceDelete();
        Storage::delete($material->path);
        return $material;
    }

    // todo put in queue
    public function emptyTrash()
    {
        $materials = auth()->user()->trashedMaterials();
        foreach ($materials as $material) {
            $this->destroy($material->id);
        }
    }

    public function updateLastVisited($material)
    {
        $material->visited_at = now();
    }

    function authorize($material_id, $message = null)
    {
        $materials = Material::withTrashed()->where('user_id', auth()->id())->pluck('id')->toArray();
        abort_unless(in_array($material_id, $materials), 403, $message ?: null);
    }
}
