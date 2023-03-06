<?php

namespace App\Http\Controllers\V1;

use App\Models\Album;
use Illuminate\Support\Str;
use App\Models\ImageManipulation;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResizeImageRequest;
use App\Http\Requests\UpdateImageManipulationRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class ImageManipulationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function resize(ResizeImageRequest $request)
    {
        $all = $request->all();
        $image = $all['image'];
        unset($all['image']);
        $data = [
            'image' => ImageManipulation::TYPE_RESIZE,
            'data' => json_encode($all),
            'user_id' => null,
        ];

        if(isset($all['album_id'])) {

            //TODO

            $data['album_id'] = $all['album_id'];
        }

        $dir = 'images/' . Str::random() . '/';
        $absolutePath = public_path($dir);
        File::makeDirectory($absolutePath);

        if($image instanceof UploadedFile) {
            $data['name'] = $image->getClientOriginalName();
            $filename = pathinfo($data['name'], PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();

            $image->move($absolutePath, $data['name']);
        } else {
            $data['name'] = pathinfo($image, PATHINFO_BASENAME);
            $filename = pathinfo($image, PATHINFO_FILENAME);
            $extension = pathinfo($$image, PATHINFO_EXTENSION);

            copy($image, $absolutePath . $data['name']);
        }
        $data['path'] = $dir . $data['name'];
    }

    public function show(ImageManipulation $imageManipulation)
    {
        //
    }
    public function byAlbum(Album $album) {

    }
    public function destroy(ImageManipulation $imageManipulation)
    {
        //
    }
}
