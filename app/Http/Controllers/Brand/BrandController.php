<?php

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;

use App\Services\Brand\BrandService;

use App\Trait\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    use JsonResponse;
    public function index()
    {
        $brands = (new BrandService())->getBrands(true);

        if (request()->ajax()) {
            try {
                return $this->successResponse($brands, 'Brand fetched successfully!');
            } catch (\Throwable $exception) {
                return $this->errorResponse($exception->getMessage(), $exception);
            }
        }
        return view('admin.brand.brands')->with(['brands' => $brands]);
    }



    public function store(StoreBrandRequest $request, BrandService $brandService)
    {
        try {
            DB::beginTransaction();
            $brand = $brandService->storeBrand($request->validated());
            //dd($category);
            DB::commit();

        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::channel('error')->error('An error occurred : ' . $exception->getMessage());
            // dump_And_Die($exception);
            return $this->errorResponse($exception->getMessage(), $exception);
        }
        return $this->successResponse($brand, 'Brand Created successfully!');
    }

    public function edit( $id, BrandService $brandService)
    {
        $brand = $brandService->getBrandById($id);
        try {
            return $this->successResponse($brand, 'A Brand fetched successfully!');
        } catch (\Throwable $exception) {
            return $this->errorResponse($exception->getMessage(), $exception);
        }
    }


    public function update(StoreBrandRequest $request,BrandService $brandService, string $id)
    {
        // $category = $categoryService->getCategoryById($id);
        try {
            DB::beginTransaction();
            $brand = $brandService->updateBrand( $id, $request->validated());
            DB::commit();

        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::channel('error')->error('An error occurred : ' . $exception->getMessage());
            return $this->errorResponse($exception->getMessage(), $exception);
        }
        return $this->successResponse($brand, 'Brand updated successfully!');
    }

    public function destroy(string $id, BrandService $brandService)
    {
        try {
            DB::beginTransaction();
            $brand = $brandService->deleteBrand($id);
            DB::commit();

        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::channel('error')->error('An error occurred : ' . $exception->getMessage());
            return $this->errorResponse($exception->getMessage(), $exception);
        }
        return $this->successResponse($brand, ' A Brand Deleted successfully!');
    }

}
