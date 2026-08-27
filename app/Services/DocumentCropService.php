<?php

namespace App\Services;

use App\Models\CropTemplate;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\ImageManager;

class DocumentCropService
{
    protected ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(
            new Driver()
        );
    }

    public function generateCrops(
        string $imagePath,
        int $mrcId
    ): void {
        $sourcePath = Storage::disk('public')->path($imagePath);

        $templates = CropTemplate::all();

        foreach ($templates as $template) {

            // Load the ORIGINAL image for every crop.
            $image = $this->manager->decodePath($sourcePath);

            /*
             * Debug information while we are testing.
             */
            logger()->info('Generating crop', [
                'field' => $template->field_name,
                'image_width' => $image->width(),
                'image_height' => $image->height(),
                'x' => $template->x,
                'y' => $template->y,
                'width' => $template->width,
                'height' => $template->height,
            ]);

            /*
             * Make sure the crop fits inside the original.
             */
            if (
                $template->x < 0 ||
                $template->y < 0 ||
                $template->width <= 0 ||
                $template->height <= 0 ||
                ($template->x + $template->width) > $image->width() ||
                ($template->y + $template->height) > $image->height()
            ) {
                throw new \RuntimeException(
                    "Invalid crop coordinates for field: " .
                    $template->field_name .
                    " | Image: " .
                    $image->width() . "x" . $image->height()
                );
            }

            /*
             * Crop the original image.
             */
            $crop = $image->crop(
                $template->width,
                $template->height,
                $template->x,
                $template->y
            );

            /*
             * Encode as JPEG.
             */
            $encoded = $crop->encode(
                new JpegEncoder(quality: 90)
            );

            $outputPath =
                "documents/{$mrcId}/crops/" .
                "{$template->field_name}.jpg";

            Storage::disk('public')->put(
                $outputPath,
                $encoded
            );
        }
    }
}