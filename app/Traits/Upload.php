<?php

namespace App\Traits;

trait Upload
{
    public function addImage($file, $path)
    {
        do {
            $name = str_random(4) . '-' . $file->getClientOriginalName();
        } while (
            file_exists(config($path) . '/image' . $name)
        );
        $file->move(config($path), $name);
        
        return $name;
    }

    public function removeImage($name, $path)
    {
        if (file_exists(config($path) . '/image' . $name))
            unlink(config($path) . '/image' .$name);
    }
}
