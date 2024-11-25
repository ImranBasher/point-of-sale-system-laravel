<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Services\Product\ProductService;
use App\Trait\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    use JsonResponse;

    public function index()
    {
        $products = (new ProductService())->getProducts(true,null, null,['categories', 'brand', 'productPictures']);

        $pro = $products;
        $textFile = $pro[4]->thumbnail;

        if(request()->ajax()) {
            try{
                return $this->successResponse($products,'Product fetch successfully!');
            }catch (\Throwable $exception) {
                return $this->errorResponse($exception->getMessage(), $exception);
            }
        }
        return view('admin.products.index', compact('textFile'))->with(['products' => $products]);
    }
    public function create(){

    }
    public function show($id){

    }

    public function store(StoreProductRequest $request , ProductService $productService)
    {
        //    dd($request);
        try {
            DB::beginTransaction();
            // store thumbnail
            $thumbnail  = '';
            if($request->hasFile('thumbnail')){
                $thumbnail = $productService->storeThumbnail($request->file('thumbnail'));
            }

            // store product
            $product = $productService->storeProduct( $request->validated(), $thumbnail);

            // Store product-categories
            if (!empty($request->category_id)) {
                $productService->storeProductCategories($product->id, $request->category_id);
            }

            // store product Images
            if($request->hasFile('images')){
                $productService->storeProductPicture($request->file('images'), $product->slug, $product->id);
            }

            DB::commit();

            return $this->successResponse(
                $product,
                'A product Added successfully!'
            );
        }catch (\Throwable $exception) {
            DB::rollBack();
            Log::channel('error log')->error('An error occurred : ' . $exception->getMessage());
            return $this->errorResponse($exception->getMessage(), $exception);
        }

    }

    public function edit(string $id, ProductService $productService)
    {
        $product = $productService->getRelationalProductById($id, ['categories', 'brand', 'productPictures']);
        try {
            return $this->successResponse($product, 'A product found successfully!');
        } catch (\Throwable $exception) {
            return $this->errorResponse($exception->getMessage(), $exception);
        }
    }

    public function update(StoreProductRequest $request, ProductService $productService, string $id)
    {
        try {
            DB::beginTransaction();
            $product = $productService->getProductById($id);

            $thumbnail  = '';
            if($request->hasFile('thumbnail') && ($product->thumbnail != $request->file('thumbnail')->getClientOriginalName()) ){
                $thumbnail = $productService->storeThumbnail($request->file('thumbnail') , $id);
            }

            $product = $productService->updateProduct($id, $request->validated(), $thumbnail);

//            if(!
//            ){
//
//            }
//            if($request->hasFile('remove_images')){
//                $productService->deleteProductImages($request->file('remove_images'));
//            }
            if($product){
                if($request->hasFile('images')){
                    $productService->storeProductPicture($request->file('images'), $product->slug, $product->id);
                }
            }

            DB::commit();
        }
        catch (\Throwable $exception) {
            DB::rollBack();
            Log::channel('error log')->error('An error occurred : ' . $exception->getMessage());
            return $this->errorResponse($exception->getMessage(), $exception);
        }
        return $this->successResponse($product, 'A product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, ProductService $productService)
    {
        try{
          // dd($id);
            DB::beginTransaction();
            $product = $productService->deleteProduct($id);
            DB::commit();
        }catch (\Throwable $exception) {
            DB::rollBack();
            Log::channel('error log')->error('An error occurred : ' . $exception->getMessage());
            return $this->errorResponse($exception->getMessage(), $exception);
        }
        return $this->successResponse($product, 'A product deleted successfully!');
    }
}
