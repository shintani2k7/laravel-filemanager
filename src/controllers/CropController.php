<?php namespace Unisharp\Laravelfilemanager\controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Intervention\Image\Facades\Image;

/**
 * Class CropController
 * @package Unisharp\Laravelfilemanager\controllers
 */
class CropController extends LfmController {

    /**
     * Show crop page
     *
     * @return mixed
     */
    public function getCrop()
    {
        $working_dir = Input::get('working_dir');
        $image = Input::get('img');

        return View::make('laravel-filemanager::crop')
            ->with('img', parent::getUrl() . $image)
            ->with('working_dir', $working_dir)
            ->with('image', $image);
    }


    /**
     * Crop the image (called via ajax)
     */
    public function getCropimage()
    {
        $image = Input::get('img');
        $dataX = Input::get('dataX');
        $dataY = Input::get('dataY');
        $dataHeight = Input::get('dataHeight');
        $dataWidth = Input::get('dataWidth');

        // crop image
        $image = Image::make(public_path() . $image);
        $image->crop($dataWidth, $dataHeight, $dataX, $dataY)
            ->save(public_path() . $image);

        // make new thumbnail
        $thumb_img = Image::make(public_path() . $image);
        $thumb_img->fit(200, 200)
            ->save(parent::getPath('thumb') . parent::getFileName($image));
    }

}
