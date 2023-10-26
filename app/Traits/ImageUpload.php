<?php

namespace App\Traits;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
trait ImageUpload {
    public function simpleImageUpload($image, $path)
    {

        try {
            $file = strtolower(Str::random(15) . '.' . $image->getClientOriginalExtension());
            $image->move(public_path($path), $file);
            return $path . $file;
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()]);
        }
    }
    public function deleteSingleImage($img, $path)
    {
        try {
            $img_path = $img;
            $full_path = public_path($img_path);
            if (File::exists($full_path)) {
                File::delete($full_path);
                Log::info("[" . Carbon::now() . "] Deleted [Single] Image Using Trait.");
                Log::info("[" . Carbon::now() . "] Path: " . $full_path);
            }
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()]);
        }
    }
}
