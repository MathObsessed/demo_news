<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadService {
    private $webRootDirectory;
    private $imagesDirectory;

    public function __construct(string $webRootDirectory, string $imagesDirectory) {
        $this->webRootDirectory = $webRootDirectory;
        $this->imagesDirectory = $imagesDirectory;
    }

    public function moveUploadedImage(UploadedFile $file):string {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->webRootDirectory.$this->imagesDirectory, $fileName);

        return $this->imagesDirectory.DIRECTORY_SEPARATOR.$fileName;
    }
}
