<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ImageUploadInterface
{
    public function upload(UploadedFile $file): string;
}
