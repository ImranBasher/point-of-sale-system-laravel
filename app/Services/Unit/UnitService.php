<?php

namespace App\Services\Unit;

use App\Models\Origin;
use App\Models\Unit;

class UnitService
{
    public function getUnits(
        $paginatePluckOrGet = null,
        $onlyActive = null,
        $onlyParents = null,
        array $relationships = [],
        array $options = [],
        $id = null
    ){
        $query = Unit::query();

        !empty($relationships) ? $query->with($relationships) : $query->with([]);

        if (!is_null($onlyActive)) {
            $query->where('status', $onlyActive);
        }
        if (is_null($paginatePluckOrGet)) {
            return $query->pluck('id', 'name');
        }
        return $paginatePluckOrGet ? $query->paginate(20) : $query->get();
    }

    public function getUnitById($id){
        return Unit::findOrFail($id);
    }

    public function storeUnit(array $payload){
        $payload['created_at'] = now();
        return Unit::query()->create($payload);
    }

    public function updateUnit($id, array $payload){
        $origin = $this->getUnitById($id);
        $payload['updated_at'] = date('Y-m-d H:i:s');
        return $origin->update($payload);
    }

    public function deleteUnit($id)
    {
        $unit = $this->getUnitById($id);

        return $unit->delete();
    }

}
