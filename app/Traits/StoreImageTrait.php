<?php 
namespace App\Traits;
 
use Illuminate\Http\Request;
 
trait StoreImageTrait {
 
    /**
     * Does very basic image validity checking and stores it. Redirects back if somethings wrong.
     * @Notice: This is not an alternative to the model validation for this field.
     *
     * @param Request $request
     * @return $this|false|string
     */
    public function verifyAndStoreImage( Request $request, $fieldname = 'image', $directory = 'unknown' ,$croped_file = '') 
    {
        if($file = $request->file($fieldname)){
            $response = image_save($request, $directory, $fieldname);
            if ($response['status']) {
                return  $response['link'];
            }
            return '';
            // if(isset($request->cropped_upload_image) && $request->cropped_upload_image){
            //     $image_parts = explode(";base64,", $request->cropped_upload_image);
            //     $image_type_aux = explode("image/", $image_parts[0]);
            //     $image_type = $image_type_aux[1];
            //     $image_base64 = base64_decode($image_parts[1]);
            //     $imageName = uniqid() .time(). '.'.$image_type;
            //      file_put_contents('./'.config("global.upload_path").'/'.$directory.'/'.$imageName, $image_base64);
                
            //     return $imageName;
            // } else {
            //     $dir = config('global.upload_path')."/".$directory;
            //     $imageName = uniqid().time().".".$file->getClientOriginalExtension();
            //     $request->$fieldname->move($dir, $imageName);
                
            //     // $response = image_upload($request,'product',$fieldname);
            //     // if($response['status']){
            //     //     $imageName = $response['link'];
            //     // }
            //     // dd($imageName );
            //     return $imageName;

            // }
        }

        if(isset($croped_file) && $croped_file){
            $image_parts = explode(";base64,", $croped_file);
            // dd($request->{$fieldname});
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $imageName = uniqid() .time(). '.'.$image_type;
            file_put_contents('./'.config("global.upload_path").'/'.$directory.'/'.$imageName, $image_base64);
            return $imageName;
        }
 
        return null;
 
    }
    // public function verifyAndStoreVideo(Request $request, $fieldname = 'product_video', $directory) 
    // {
    //     // Handle video uploads
    //     if ($file = $request->file($fieldname)) {
    //         // Generate unique file name for the video
    //         $videoName = time() . '_' . $file->getClientOriginalName();
    
    //         // Use image_save function to store the video file in the specified directory
    //         $response = image_save($request, $directory, $fieldname);
    
    //         if ($response['status']) {
    //             return $response['link']; // Return the link to the uploaded video
    //         }
    
    //         return null;
    //     }
    //     return null;
    // }

    public function generateThumbnailPlaceholder($thumbnailLocalPath)
    {
        // Create a blank image (200x200 pixels, white background)
        $image = imagecreatetruecolor(200, 200);
        $white = imagecolorallocate($image, 255, 255, 255); // white background
        $black = imagecolorallocate($image, 0, 0, 0); // black color for the play button
        $gray = imagecolorallocate($image, 169, 169, 169); // gray color for background
    
        // Fill the background with white color
        imagefill($image, 0, 0, $white);
    
        // Draw a gray circle to represent the video player button (optional)
        imagefilledellipse($image, 100, 100, 120, 120, $gray);
    
        // Draw the "Play" triangle (video icon)
        $playTriangle = [
            85, 60,  // Left point
            85, 140, // Bottom point
            140, 100 // Right point
        ];
        imagefilledpolygon($image, $playTriangle, 3, $black); // Draw the triangle
    
        // Optionally, add text on top of the thumbnail (such as "Video")
        $font = 5; // Font size
        $text = "Video";
        $textWidth = imagefontwidth($font) * strlen($text);
        $textHeight = imagefontheight($font);
        $textX = (imagesx($image) - $textWidth) / 2;
        $textY = (imagesy($image) - $textHeight) / 2 + 50;
        imagestring($image, $font, $textX, $textY, $text, $black);
    
        // Save the image
        imagejpeg($image, $thumbnailLocalPath);
    
        // Free up memory
        imagedestroy($image);
    }
    

    public function verifyAndStoreVideo(Request $request, $fieldname = 'product_video', $directory)
    {
        if ($file = $request->file($fieldname)) {
            // 1. Save uploaded video TEMPORARILY to local storage
            $originalName = $file->getClientOriginalName();
            $tempVideoName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $tempVideoPath = storage_path('app/temp/' . $tempVideoName);
            $file->move(storage_path('app/temp'), $tempVideoName);

            // 2. Check if the directory exists for video and thumbnail
            $directoryPath = storage_path('app/' . $directory);
            if (!is_dir($directoryPath)) {
                // If directory does not exist, create it with proper permissions
                mkdir($directoryPath, 0777, true); // 0777 grants full access to all users
            }

            // 3. Generate thumbnail using ffmpeg
            $thumbnailName = 'thumb_' . time() . '.jpg';
            $thumbnailLocalPath = $directoryPath . '/' . $thumbnailName;
            $ffmpegCommand = "ffmpeg -i \"$tempVideoPath\" -ss 00:00:01 -vframes 1 \"$thumbnailLocalPath\"";

            // Execute the command and check if thumbnail was generated
            exec($ffmpegCommand);

            // 4. If thumbnail generation failed, create a placeholder
            if (!file_exists($thumbnailLocalPath)) {
                $this->generateThumbnailPlaceholder($thumbnailLocalPath);
            }

            // 5. Upload video to S3 using image_save
            $videoFile = new \Illuminate\Http\UploadedFile($tempVideoPath, $tempVideoName, null, null, true);
            $videoRequest = new Request();
            $videoRequest->files->set($fieldname, $videoFile);
            $videoResponse = image_save($videoRequest, $directory, $fieldname);

            // 6. Upload thumbnail to S3 using image_save
            $thumbLink = null;
            if (file_exists($thumbnailLocalPath)) {
                $thumbnailFile = new \Illuminate\Http\UploadedFile($thumbnailLocalPath, $thumbnailName, 'image/jpeg', null, true);
                $thumbRequest = new Request();
                $thumbRequest->files->set('thumbnail', $thumbnailFile);
                $thumbResponse = image_save($thumbRequest, $directory, 'thumbnail');
                $thumbLink = $thumbResponse['link'] ?? null;

                // Optional: Delete thumbnail from temp
                \File::delete($thumbnailLocalPath);
            }

            // Optional: Delete video from temp
            \File::delete($tempVideoPath);

            return [
                'video' => $videoResponse['link'] ?? null,
                'thumbnail' => $thumbLink,
            ];
        }

        return null;
    }

    
    

 
}