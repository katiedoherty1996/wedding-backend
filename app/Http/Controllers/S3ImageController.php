<?php

namespace App\Http\Controllers;

use Aws\S3\S3Client;

class S3ImageController extends Controller
{
    public function getAllImages()
    {
        // Initialize S3 client
        $s3 = new S3Client([
            'version' => 'latest',
            'region'  => env('AWS_DEFAULT_REGION'),
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        // Retrieve list of objects (images) from S3 bucket
        $objects = $s3->listObjects([
            'Bucket' => env('AWS_BUCKET'),
        ]);

        // Extract image URLs from objects
        $imageUrls = [];
        foreach ($objects['Contents'] as $object) {
            $imageUrls[] = $s3->getObjectUrl(env('AWS_BUCKET'), $object['Key']);
        }

        // Return the image URLs
        return response()->json($imageUrls);
    }
}
