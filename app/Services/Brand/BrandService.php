<?php

namespace App\Services\Brand;
use App\Models\Brand;


class BrandService{
    public function getBrands(
        $paginatePluckOrGet = null,
        $onlyActive = null,
        $onlyParents = null,
        array $relationships = [],
        array $options = [],
        $id = null)
    {
        $query = Brand::query();

        !empty($relationships) ? $query->with($relationships) : $query->with([]);

        if(!is_null($onlyActive)){
            $query->where('status', $onlyActive);
        }
        if(is_null($paginatePluckOrGet)){
            return $query->pluck('id','name');
        }
        return $paginatePluckOrGet ? $query->paginate(10) : $query->get();
    }

    public function getBrandById($id){
        return Brand::findOrFail($id);
    }

    public function storeBrand(array $payloads){
        $payloads['created_at'] = date('Y-m-d H:i:s');
        $payloads['updated_at'] = null;
        return Brand::query()->create($payloads);
    }

    public function updateBrand($id, array $payloads){

        $brands = $this->getBrandById($id);
        $payloads['updated_at'] = date('Y-m-d H:i:s');

        return $brands->update($payloads);
    }
    public function deleteBrand($id){
        $categories = $this->getBrandById($id);
        return $categories->delete();
    }

}


