<?php
namespace App\Trait;

use App\Models\Picture;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
trait FileService
{

    public function fileRename()
    {
        // Example : _abc_corporation_2024_05_05_

        return "_final_pos_".date("Y-m-d_H-i-s")."_";
    }

    public function uploadFile(
        $file,
        $filePath
    )
    {
        // 1. Get File Extension
        $extension = $file->getClientOriginalExtension();

        if($extension == "svg"){
            $extension = "svg";
        }

        // 3. Generate File Name
        $fileName = $this->fileRename().rand(1111,9999).".".$extension; // _abc_corporation_2024_05_05_2345.webp

        // 4. Create Image Manager Instance
        // create image manager with desired driver
        $manager = new ImageManager(
            new Driver()
        );

        // 5. Read the Uploaded File
        $image = $manager->read($file);

        // 6. Resize the Image   $image->resize(null, 800); $image->resize(1200, 800);
        $image->resize(height: 800);

        // 7. Encode the Image to WebP      Consider making the encoding format dynamic based on the file type, for instance: $encoded = $image->encode($extension == 'svg' ? 'svg' : 'webp');
        $encoded = $image->toWebp();

        $finalSavingDestination = null;


        // 8. Save the Image to Destination
        // Save to destination
        $encoded->save($filePath . '/' . $fileName); // xyz/123abc.webp

        return $fileName;
    }


//    public function uploadFile1($file, $filePath)
//    {
//        // Step 1: Get File Extension
//        $extension = $file->getClientOriginalExtension();
//
//        // Step 2: Handle File Name Generation
//        $fileName = $this->fileRename() . rand(1111, 9999) . '.' . $extension;
//
//        // Step 3: Create Image Manager Instance (Specify Driver)
//        $manager = new ImageManager(
//            new Driver()
//        );
//
//        // Step 4: Read the Uploaded File
//        $image = $manager->read($file);
//
//        // Step 5: Resize Image (Keep Proportions)
//        $image->resize(1200, 800); // You can adjust the width and height accordingly
//
//        // Step 6: Encode Image (WebP by default)
//        $encoded =  $image->toWebp();  // or use $extension for dynamic format
//
//        // Step 7: Ensure Path Exists and Save the Image
//        if (!file_exists($filePath)) {
//            mkdir($filePath, 0755, true);
//        }
//        $encoded->save($filePath . '/' . $fileName);
//    }














    function storeMultipleImages($images, $destination, $slug, $productId){

        foreach ($images as $image) {
            $this->storeSingleImage($image,$destination, $slug, $productId);
        }
    }

    function storeSingleImage($image, $destination, $slug, $productId){
        $getPath = $this->fileUploader($image, $destination, $slug);
        $picture['filename'] = $getPath;
        $picture['product_id'] = $productId;
        $picture['created_at'] = date('Y-m-d H:i:s');
        $picture['updated_at'] = null;

        Picture::query()->create($picture);
    }


    /**
     * @throws \Exception
     */
    function storeSingleImageInSpecificTable($image, $destination, $slug){
        return $this->fileUploader($image, $destination, $slug);

    }

    function fileUploader($image, $destination, $slug){
        /**
         * $image->getRealPath(): This function returns the absolute path to the file as it is stored on the server in a temporary directory. It is useful when you need to work with the actual file on disk, as it provides the most accurate location. However, this function can return false if the file does not exist, so you should check for that.
         *
         * $image->getPathname(): This function returns the path to the file within the PHP temporary directory, and it is the standard way to retrieve the file's temporary location. It is often used for tasks like moving the file to another location or reading its contents.
         *
         * Which One to Use?
         * Use $image->getPathname() when you want to get the current temporary location of the uploaded file and move or read it.
         * Use $image->getRealPath() when you want the absolute path of the uploaded file, especially when working with filesystem functions that require absolute paths.
         */
        // $temp_name = $image->getRealPath();
        $temp_name = $image->getPathname();

        if(file_exists($temp_name)){
            $extension = $image->getClientOriginalExtension();
            $fileRename = $this->fileRename1($extension, $slug);
            $image->storeAs($destination, $fileRename);
            return $fileRename;
        }else{
            throw new \Exception("File upload error");
        }
    }

    public function fileRename1($extension,$slug){
        $randomNumber = uniqid(rand(),true);
        return $slug.'-'.$randomNumber.'.'.$extension;
    }


    public function singleFileDelete($image, $destination){
        $picture = Picture::query()->findOrFail($image);
        $filePath = $destination.$picture->filename;
        if(file_exists($filePath)){
            unlink($filePath);
        }
        $picture->delete();
    }








}
