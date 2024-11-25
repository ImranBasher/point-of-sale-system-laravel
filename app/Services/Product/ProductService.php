<?php

namespace App\Services\Product;
use App\Models\Picture;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductPicture;
use App\Models\User;
use App\Trait\FileService;
use Faker\Core\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductService
{
    use FileService;
    CONST DESTINATION = "public/product/";

    public function getProducts(
        $paginatePluckOrGet = null,
        $onlyActive = null,
        $onlyParents = null,
        array $relationships = [],
        array $options = [],
        $id = null)
    {
        $query = Product::query();

        !empty($relationships) ? $query->with($relationships) : $query->with([]);

        if (!is_null($onlyActive)) {
            $query->where('status', $onlyActive);
        }
        if (is_null($paginatePluckOrGet)) {
            return $query->pluck('id', 'name');
        }
        return $paginatePluckOrGet ? $query->paginate(20) : $query->get();
    }

    public function getAllProducts(){
        return Product::query()->where('status','1')->get();
    }

    public function getAllSuppliers(){
        return User::query()->where('role','2')->get();
    }

    public function makeSlug($slugData)
    {
        // Generate the slug from the name (or any other field)
        $slug = Str::slug($slugData, '-');

        $originalSlug = $slug;
        $counter = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        return $slug;
    }

    public function makeSKU($productTitle){
        $sku = 'SKU-'.strtoupper(substr($productTitle, 0, 3). '-'.rand(1,9999));
        $originalSKU = $sku;

        $counter = 1;
        while(Product::where('sku', $sku)->exists()) {
            $sku = $originalSKU.'-'.$counter;
            $counter++;
        }
        return $sku;
    }
    public function storeProduct(array $payload, string $thumbnail = null){

        $payload['slug']        = $this->makeSlug($payload['title']);
        $payload['sku']         = $this->makeSKU($payload['title']);
        $payload['thumbnail']   = $thumbnail;
        $payload['user_id']     = userId();
        $payload['created_by_id']     = userId();

        return Product::query()->create($payload);
    }

    public function storeProductCategories($productId, array $categoryIds){
        foreach ($categoryIds as $category){
            ProductCategory::query()->create([
                'product_id'    => $productId,
                'category_id'   => $category,
            ]);
        }
    }

    /**
     * @throws \Exception
     */
    function storeProductPicture($images, $slug, $productId){

        foreach ($images as $image) {
           $filePath =  $this->fileUploader($image,self::DESTINATION, $slug);
           $extension =$image->getClientOriginalExtension();
           $fileSize = $image->getSize();

            ProductPicture::query()->create([
               'product_id' => $productId,
               'file_path' => $filePath,
               'extension' => $extension,
               'file_size' => $fileSize,
           ]);

        }
    }
    public function storeThumbnail($thumbnail, $id = null)
    {
        if($id != null){
            $this->singleFileDelete($thumbnail, self::DESTINATION);
        }
        return $this->storeSingleImageInSpecificTable($thumbnail, self::DESTINATION, 'product_thumbnail');
    }

//    public function storeProductImages($images, $product){
//
//        $this->storeMultipleImages($images, self::DESTINATION, $product->slug, $product->id);
//    }





    public function getProductById($id)
    {
        return Product::findOrFail($id);
    }
    public function getRelationalProductById($id, array $relationships = []){

        $product = Product::query();
        !empty($relationships) ? $product->with($relationships) : $product->with([]);
        return $product->find($id);
    }


    public function updateProduct( $id, array $payload, $thumbnail = null){

        $product = $this->getProductById($id);

        if($product != null){

            if(!empty($thumbnail)){
                $payload['thumbnail'] = $thumbnail;
            }

            if($product->title != $payload['title']){

                $payload['slug']        = $this->makeSlug($payload['title']);
                $payload['sku']         = $this->makeSKU($payload['title']);
            }
            $payload['updated_at'] = date('Y-m-d H:i:s');
            $payload['updated_by_id']     = userId();
            return $product->update($payload);
        }

    }

    public function deleteProductImages(array $images){
         foreach($images as $image){
                $this->singleFileDelete($image,self::DESTINATION);
         }
    }


    public function deleteProduct($id){
        $product = $this->getProductById($id);
        if($product != null){
            $productImages = $product->productPictures;
            $imageArray = $productImages->pluck('file_path')->toArray();
            if(is_array($imageArray)){
                $this->deleteProductImages($imageArray);
            }
        }

        if($product != null){
            $productCategory = $product->productCategories;
            $productCategory->delete();
        }

        if($product != null){
            if($product->thumbnail != null){
                $this->singleFileDelete($product->thumbnail, self::DESTINATION);
            }
        }
       return $product->delete();
    }
}
?>
