<?php

namespace Model;

class ImageLoader
{
    public static function loadImage($image): string
    {
        $uploadDir = "D:/nginx-1.22.1/sites/user_list_components/public/img/uploads/";
        $imgName = uniqid() . "." . pathinfo($image['name'])['extension'];
        $uploadDir = $uploadDir . $imgName;
        $path = '/img/uploads/';
        $img = $path . $imgName;

        move_uploaded_file($image['tmp_name'], $uploadDir);

        return $img;
    }
}