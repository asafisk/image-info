<?php


namespace App\Http\Controllers;

use App\Services\ImageService;
use Illuminate\Http\Request;

/**
 * Class ImageController
 * @package App\Http\Controllers
 */
class ImageController extends Controller
{
    /**
     * @param ImageService $service
     * @throws \Exception
     */
    public function __invoke(Request $request, ImageService $service)
    {

        $this->validate($request, [
            'image' => 'required|image',
        ]);

        //$service->fetchImage();

        $info = $service->storeImage($request)
            ->imageInfo()
            ->extractProperties();
        $service->removeImage();

        return $info;
    }
}
