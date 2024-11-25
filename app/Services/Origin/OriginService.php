<?php
namespace app\services\Origin;
use App\Models\Origin;

class OriginService{
    public function getOrigins(
        $paginatePluckOrGet = null,
        $onlyActive = null,
        $onlyParents = null,
        array $relationships = [],
        array $options = [],
        $id = null
    ){
        $query = Origin::query();
        !empty($relationships) ? $query->with($relationships) : $query->with([]);

        if (!is_null($onlyActive)) {
            $query->where('status', $onlyActive);
        }
        if (is_null($paginatePluckOrGet)) {
            return $query->pluck('id', 'name');
        }
        return $paginatePluckOrGet ? $query->paginate(20) : $query->get();
    }

    public function getOriginById($id){
        return Origin::findOrFail($id);
    }

    public function storeOrigin(array $payload){
        $payload['created_at'] = now();
        return Origin::query()->create($payload);
    }

    public function updateOrigin($id, array $payload){
        $origin = $this->getOriginById($id);
        $payload['updated_at'] = date('Y-m-d H:i:s');
        return $origin->update($payload);
    }

    public function deleteOrigin($id){
        $origin = $this->getOriginById($id);
        return $origin->delete();
    }

}
