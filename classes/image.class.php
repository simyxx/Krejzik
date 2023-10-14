<?php

class Image
{
    public function cropImage($originalFileName, $croppedFileName, $maxWidth, $maxHeight)
    {
        $imageType = 1;
        if (file_exists($originalFileName)) {
            if ($_FILES['file']['type'] == "image/jpeg") {

                $originalImage = imagecreatefromjpeg($originalFileName);
                $originalWidth = imagesx($originalImage);
                $originalHeight = imagesy($originalImage);
                if ($originalHeight > $originalWidth) {
                    // Nastav šířka = max. šířka
                    $ratio = $maxWidth / $originalWidth;
                    $newWidth = $maxWidth;
                    $newHeight = $originalHeight * $ratio;
                } else {
                    // Nastav šířka = max. šířka
                    $ratio = $maxHeight / $originalHeight;
                    $newHeight = $maxHeight;
                    $newWidth = $originalWidth * $ratio;
                }

            } else if ($_FILES['file']['type'] == "image/png") {
                $imageType = 2;
                $originalImage = imagecreatefrompng($originalFileName);
                $originalWidth = imagesx($originalImage);
                $originalHeight = imagesy($originalImage);
                if ($originalHeight > $originalWidth) {
                    // Nastav šířka = max. šířka
                    $ratio = $maxWidth / $originalWidth;
                    $newWidth = $maxWidth;
                    $newHeight = $originalHeight * $ratio;
                } else {
                    // Nastav šířka = max. šířka
                    $ratio = $maxHeight / $originalHeight;
                    $newHeight = $maxHeight;
                    $newWidth = $originalWidth * $ratio;
                }
            } else if ($_FILES['file']['type'] == "image/gif") {
                $imageType = 3;
                $originalImage = imagecreatefromgif($originalFileName);
                $originalWidth = imagesx($originalImage);
                $originalHeight = imagesy($originalImage);
                if ($originalHeight > $originalWidth) {
                    // Nastav šířka = max. šířka
                    $ratio = $maxWidth / $originalWidth;
                    $newWidth = $maxWidth;
                    $newHeight = $originalHeight * $ratio;
                } else {
                    // Nastav šířka = max. šířka
                    $ratio = $maxHeight / $originalHeight;
                    $newHeight = $maxHeight;
                    $newWidth = $originalWidth * $ratio;
                }
            }
        }
        $newImage = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($newImage, $originalImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

        imagedestroy($originalImage);

        if ($newHeight > $newWidth) {
            $difference = ($newHeight - $newWidth);
            $y = round($difference / 2);
            $x = 0;
        } else {
            $difference = ($newWidth - $newHeight);
            $y = 0;
            $x = round($difference / 2);
        }
        $newCroppedImage = imagecreatetruecolor($maxWidth, $maxHeight);
        imagecopyresampled($newCroppedImage, $newImage, 0, 0, $x, $y, $maxWidth, $maxHeight, $maxWidth, $maxHeight);
        imagedestroy($newImage);
        switch ($imageType) {
            case 1:
                imagejpeg($newCroppedImage, $croppedFileName, 90);
                break;
            case 2:
                imagepng($newCroppedImage, $croppedFileName, 9);
                break;
            case 3:
                imagegif($newCroppedImage, $croppedFileName);
                break;
        }
        imagedestroy($newCroppedImage);
    }
}