<?php
namespace App\Services\Category;

use App\Models\Category;
use App\Trait\FileService;

class CategoryService{

    use FileService;

    CONST DESTINATION = "public/categories/";

    public function getCategories(
        $paginatePluckOrGet = null,
        $onlyActive = null,
        $onlyParents = null,
        array $relationships = [],
        array $options = [],
        $id = null)
    {
        $query = Category::query();

        !empty($relationships) ? $query->with($relationships) : $query->with([]);

        if(!is_null($onlyActive)){
            $query->where('status', $onlyActive);
        }
        if(is_null($paginatePluckOrGet)){
            return $query->pluck('id','name');
        }
        return $paginatePluckOrGet ? $query->paginate(10) : $query->get();
    }

    public function getCategoryById($id){
        return  Category::findOrFail($id);
    }

    public function checkTitle(string $title): bool {
        $cat = Category::where('title', $title)->exists();
        return $cat ? false : true;
    }

    public function storeCategory(array $payload, $filename = null)
    {
        // Set additional payload attributes
        $payload['thumbnail'] = $filename;
        $payload['created_by_id'] = 1; // Auth::id();
        $payload['created_at'] = now();
        $payload['updated_at'] = null;

        // Create and return a new category record
        return Category::query()->create($payload);
    }

    /**
     * @throws \Exception
     */
//    public function storeThumbnail($thumbnail)
//    {
//        return $this->storeSingleImageInSpecificTable($thumbnail, self::DESTINATION, 'category');
//    }

    public function storeThumbnail($thumbnail)
    {
        return $this->uploadFile($thumbnail, self::DESTINATION);
    }



    public function updateCategory($id, array $payload, $filename = null)
    {
        $category = $this->getCategoryById($id);

        if ($filename) {
            $payload['thumbnail'] = $filename;
        }
        $payload['updated_by_id'] = 1; // Use Auth::id()
        $payload['updated_at'] = now();
        $category->update($payload);

        return $category;
    }


    public function deleteCategory($id)
    {
        $category = $this->getCategoryById($id);
        if (!empty($category->thumbnail)) {
            $this->singleFileDelete($category->thumbnail, self::DESTINATION);
        }
        $category->delete();

        return $category;
    }



















}
