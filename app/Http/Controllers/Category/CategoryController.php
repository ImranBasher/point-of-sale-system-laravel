<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\Category\CategoryService;
use App\Trait\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    use JsonResponse;

    public function index()
    {
        $categories = (new CategoryService())->getCategories(true, null, null, ['parentCategory']); // Adjust method as per your service implementation

        if (request()->ajax()) {
            try {
                return $this->successResponse($categories, 'Category fetched successfully.');
            } catch (\Exception $exception) {
                return $this->errorResponse($exception->getMessage(), $exception);
            }
        }
        return view('admin.categories.index')->with(['categories' => $categories]); // Ensure this view exists
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
    public function store(StoreCategoryRequest $request, CategoryService $categoryService)
    {
        try {
            DB::beginTransaction();

            if ($categoryService->checkTitle($request->title)) {
                $filename = '';
                if ($request->hasFile('thumbnail')) {
                    $filename = $categoryService->storeThumbnail($request->file('thumbnail'));
                }
                $category = $categoryService->storeCategory($request->validated(), $filename);
                DB::commit();

                return $this->successResponse($category, 'Category added successfully!');
            }
            return $this->errorResponse("Title already exists.");
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
    public function edit(string $id, CategoryService $categoryService)
    {
        try {
            // Fetch the category by ID using the service
            $category = $categoryService->getCategoryById($id);

            // Return a success response with the category data
            return $this->successResponse($category, 'Category found successfully!');
        } catch (\Throwable $exception) {
            Log::channel('error log')->error('An error occurred: ' . $exception->getMessage());
            return $this->errorResponse($exception->getMessage(), $exception);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category, CategoryService $categoryService)
    {
        try {
            DB::beginTransaction();

            $filename = '';

            if ($request->hasFile('thumbnail')) {
                $filename = $categoryService->storeThumbnail($request->file('thumbnail'));
            }

            $category = $categoryService->updateCategory($category->id, $request->validated(), $filename);

            DB::commit();
            return $this->successResponse($category, 'Category updated successfully!');
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::channel('error log')->error('An error occurred: ' . $exception->getMessage());
            return $this->errorResponse($exception->getMessage(), $exception);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, CategoryService $categoryService)
    {
        try {
            DB::beginTransaction();

            // Delete the category using the service
            $deleteCategory = $categoryService->deleteCategory($id);

            DB::commit(); // Commit after the deletion is successful

            return $this->successResponse($deleteCategory, 'Category deleted successfully!');
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::channel('error log')->error('An error occurred: ' . $exception->getMessage());
            return $this->errorResponse($exception->getMessage(), $exception);
        }
    }

}
