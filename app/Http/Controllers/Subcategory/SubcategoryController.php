<?php

namespace App\Http\Controllers\Subcategory;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubcategoryRequest;
use App\Http\Requests\UpdateSubcategoryRequest;
use App\Models\Subcategory;
use App\Services\Subcategory\SubcategoryService;
use App\Trait\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubcategoryController extends Controller
{
    use JsonResponse;
    public function index()
    {
        $subcategories = (new SubcategoryService())->getSubcategories(true, null, null, ['category']);

        if(request()->ajax()){
            try{
                return $this->successResponse($subcategories, 'Subcategory fetch successfully.');
            }catch(\Exception $exception){
                return $this->errorResponse($exception->getMessage(), $exception);
            }
        }
        return view('admin.subcategories.index')->with(['subcategories' => $subcategories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubcategoryRequest $request, SubcategoryService $subcategoryService)
    {
        try {
            DB::beginTransaction();

            if($subcategoryService->checkTitle($request->title)){
                $filename ='';
                if ($request->hasFile('thumbnail')) {
                    $filename =   $subcategoryService->storeThumbnail($request->file('thumbnail'));
                }
                $subcategory = $subcategoryService->storeSubcategory($request->validated(), $filename);
                DB::commit();

                return $this->successResponse($subcategory, 'Subcategory added successfully!');
            }
            return $this->errorResponse("Tttle Already exist");
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::channel('error log')->error('An error occurred: ' . $exception->getMessage());
            return $this->errorResponse($exception->getMessage(), $exception);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, SubcategoryService $subcategoryService)
    {
        try {
            // Fetch the subcategory by ID using the service
            $subcategory = $subcategoryService->getSubcategoryById($id);

            // Return a success response with the subcategory data
            return $this->successResponse($subcategory, 'A subcategory found successfully!');
        } catch (\Throwable $exception) {
            // Return an error response in case of any exceptions
            return $this->errorResponse($exception->getMessage(), $exception);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubcategoryRequest $request, Subcategory $subcategory, SubcategoryService $subcategoryService)
    {
        try {
            DB::beginTransaction();

//            $data = $request->only('title', 'subcategory_ids', 'thumbnail');
//            $subcategoryService
//                ->abc($request)
//                ->def();
            // Update subcategory
            // Handle thumbnail upload if present

            $filename = '';

            if ($request->hasFile('thumbnail')) {
                $filename = $subcategoryService->storeThumbnail($request->file('thumbnail'));
            }
            $subcategory = $subcategoryService->updateSubcategory($subcategory->id, $request->validated(), $filename);

            DB::commit();
            return $this->successResponse($subcategory, 'Subcategory updated successfully!');
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::channel('error log')->error('An error occurred: ' . $exception->getMessage());
            return $this->errorResponse($exception->getMessage(), $exception);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, SubcategoryService $subcategoryService)
    {
        try{
            DB::beginTransaction();
            $deleteSubcategory = $subcategoryService->deleteSubcategory($id);
            DB::commit();
            return $this->successResponse($deleteSubcategory, 'Subcategory updated successfully!');
        }catch(\Throwable $exception){
            DB::rollBack();
            Log::channel('error log')->error('An error occurred: ' . $exception->getMessage());
            return $this->errorResponse($exception->getMessage(), $exception);
        }
    }
}
