<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UploadController extends Controller
{
    public function showUploadForm()
    {
        return view('form');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,pdf|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // Store the original file
            $path = Storage::disk('minio')->putFileAs('uploads', $file, $fileName);
            
            // Generate thumbnail if it's an image
            if (in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif'])) {
                $image = Image::make($file);
                $image->fit(200, 200);
                
                $thumbnailName = 'thumb_' . $fileName;
                
                // Convert the image to a stream and store it
                $imageStream = $image->stream();
                Storage::disk('minio')->put('thumbnails/' . $thumbnailName, $imageStream->__toString());
                
                return redirect()->back()->with('success', 'File uploaded successfully. Original: ' . $path . ', Thumbnail: thumbnails/' . $thumbnailName);
            }
            
            return redirect()->back()->with('success', 'File uploaded successfully: ' . $path);
        }
        
        return redirect()->back()->with('error', 'File upload failed');
    }
}
