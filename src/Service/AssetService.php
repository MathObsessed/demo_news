<?php

namespace App\Service;


use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AssetService {
    private const DIRECTORY = '/images';

    private $projectRootDirectory;

    public function __construct(string $projectRootDirectory) {
        $this->projectRootDirectory = $projectRootDirectory;
    }

    public function fileByName(string $fileName):File {
        return new File($this->filePathByName($fileName));
    }

    public function filePathByName(string $fileName):string {
        return $this->projectRootDirectory.self::DIRECTORY.DIRECTORY_SEPARATOR.$fileName;
    }

    public function handleUpload(UploadedFile $file):string {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->projectRootDirectory.self::DIRECTORY, $fileName);

        return $fileName;
    }
}
