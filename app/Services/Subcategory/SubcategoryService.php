<?php

namespace App\Services\Subcategory;

use App\Models\Category;
use App\Models\Subcategory;
use App\Trait\FileService;
use Exception;


class SubcategoryService
{
    use FileService;
    protected $position_no = null;
    CONST DESTINATION = "public/subcategories/";

    public function getSubcategories(
        $paginatePluckOrGet = null,
        $onlyActive = null,
        $onlyParents = null,
        array $relationships = [],
        array $options = [],
        $id = null
    ){
        $query = Subcategory::query();

        !empty($relationships) ? $query->with($relationships) : $query->with([]);

        if (!is_null($onlyActive)) {
            $query->where('status', $onlyActive);
        }
        if (is_null($paginatePluckOrGet)) {
            return $query->pluck('id', 'name');
        }
        return $paginatePluckOrGet ? $query->paginate(20) : $query->get();

    }

    public function checkTitle(string $title):bool{

        $cat = Category::where('title', $title)->exist();
        $sub = Subcategory::where('title', $title)->exist();

        if($cat || $sub){
            return false;
        }else{
            return true;
        }
    }


    public function storeSubcategory(array $payload, $filename = null)
    {
        $payload['thumbnail'] = $filename;
        $payload['created_by_id'] = 1; //Auth::id();
        $payload['created_at'] = now();
        $payload['updated_at'] = null;

        return Subcategory::query()->create($payload);
    }

    /**
     * @throws Exception
     */
    public function storeThumbnail($thumbnail)
    {
       return $this->storeSingleImageInSpecificTable($thumbnail, self::DESTINATION, 'subcategory');
    }


    public function getSubcategoryById($id)
    {
        return Subcategory::query()->findOrFail($id);
    }

    public function updateSubcategory($id, array $payload, $filename = null){
        $subcategory = $this->getSubcategoryById($id);
        if($filename){
            $subcategory->thumbnail = $filename;
        }

        $subcategory->update($payload);

//        $subcategory->updated_by_id = 1; //Auth::id();
//        $subcategory->updated_at = now();
        return $subcategory->update();
    }

    public function abc($request)
    {
        $positions  = $request->position_no;
        $this->position_no = $positions;
        return $this;
    }

    public function def()
    {
        dd($this->position_no);
    }


public function deleteSubcategory($id){
        $subcategory = $this->getSubcategoryById($id);
        if(!empty($subcategory->thumbnail)){
            $this->singleFileDelete($subcategory->thumbnail, self::DESTINATION);
        }

        $subcategory->delete();

        return $subcategory;
}
}
