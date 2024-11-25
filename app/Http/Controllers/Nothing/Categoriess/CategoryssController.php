<?php
//
//namespace App\Http\Controllers\Nothing\Categories;
//
//use App\Http\Controllers\Controller;
//use App\Http\Requests\StoreCategoryRequest;
//use App\Services\Category\CategoryService;
//use App\Trait\JsonResponse;
//use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Log;
//
//class CategoryController extends Controller
//{
//    use JsonResponse;
//
//    public function index()
//    {
//        $categories = (new CategoryService())->getCategories(true);
//
//        if (request()->ajax()) {
//            try {
//                return $this->successResponse($categories, 'Category fetch successfully!');
//            } catch (\Throwable $exception) {
//                return $this->errorResponse($exception->getMessage(), $exception);
//            }
//        }
//        return view('admin.NewCategory.allCategories')->with(['categories' => $categories]);
//    }
//
//
//    /**
//     * Store a newly created resource in storage.
//     */
//    public function store(StoreCategoryRequest $request, CategoryService $categoryService)
//    {
//        try {
//            DB::beginTransaction();
//            $category = $categoryService->storeCategory($request->validated());
//            //dd($category);
//            DB::commit();
//
//        } catch (\Throwable $exception) {
//            DB::rollBack();
//            Log::channel('errorlog')->error('An error occured : ' . $exception->getMessage());
//            // dump_And_Die($exception);
//            return $this->errorResponse($exception->getMessage(), $exception);
//        }
//        return $this->successResponse($category, 'Category Created successfully!');
//    }
//
//
//    /**
//     * Display the specified resource.
//     */
//    public function show(string $id)
//    {
//
//    }
//
//    public function edit( $id, CategoryService $categoryService)
//    {
//       $category = $categoryService->getCategoryById($id);
//        try {
//            return $this->successResponse($category, 'Category Created successfully!');
//        } catch (\Throwable $exception) {
//            return $this->errorResponse($exception->getMessage(), $exception);
//        }
//    }
//
//    /**
//     * Update the specified resource in storage.
//     */
//    public function update(StoreCategoryRequest $request,CategoryService $categoryService, string $id)
//    {
//       // $category = $categoryService->getCategoryById($id);
//        try {
//            DB::beginTransaction();
//                $category = $categoryService->updateCategory( $id, $request->validated());
//            DB::commit();
//
//        } catch (\Throwable $exception) {
//            DB::rollBack();
//            Log::channel('errorlog')->error('An error occured : ' . $exception->getMessage());
//            return $this->errorResponse($exception->getMessage(), $exception);
//        }
//        return $this->successResponse($category, 'Category updated successfully!');
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     */
//    public function destroy(string $id, CategoryService $categoryService)
//    {
//        try {
//            DB::beginTransaction();
//            $category = $categoryService->deleteCategory($id);
//            DB::commit();
//
//        } catch (\Throwable $exception) {
//            DB::rollBack();
//            Log::channel('error')->error('An error occurred : ' . $exception->getMessage());
//            return $this->errorResponse($exception->getMessage(), $exception);
//        }
//        return $this->successResponse($category, ' A Category Deleted successfully!');
//    }
//
//}
