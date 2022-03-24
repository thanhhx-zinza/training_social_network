<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait Post
{

    public function handleImageOld($imageNew, $imageOld, $arrImageDeleted)
    {
        $imageDeleted = [];
        $arrElement = [];
        if (isset($imageNew) && count($imageNew) > 0) {
            $imageNew = $this->storeImage($imageNew);
        }
        if (isset($arrImageDeleted) && count($arrImageDeleted) > 0) {
            foreach ($imageOld as $key => $img) {
                if (!in_array($key, $arrImageDeleted)) {
                    array_push($imageDeleted, $img);
                    array_push($arrElement, $key);
                }
            }
            foreach ($arrElement as $key) {
                unset($imageOld[$key]);
            }
            if (count($imageDeleted) > 0) {
                foreach ($imageDeleted as $image) {
                    Storage::delete('images-post/'.$image);
                }
            }
        }
        if (empty($imageNew)) {
            $data = json_encode($imageOld, JSON_FORCE_OBJECT);
        } else {
            foreach ($imageNew as $image) {
                if (!in_array($image, $imageOld)) {
                    array_push($imageOld, $image);
                }
            }
            $data = json_encode($imageOld, JSON_FORCE_OBJECT);
        }
        return $data;
    }

    public function storeImage($images)
    {
        $arrImages = [];
        foreach ($images as $image) {
            $imageName = uniqid().'.'.$image->extension();
            $image->storeAs('images-post', $imageName, 'public');
            array_push($arrImages, $imageName);
        }
        return $arrImages;
    }
}
