<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploaderService
{
    private string $targetDirectory;

    public function __construct(string $targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function getUploadedFileName(UploadedFile $image){
        $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        return $originalFilename.'-'.$image->guessExtension();

    }
    public function upload(UploadedFile $image,string $fileName)
    {
        $image->move(
            $this->getTargetDirectory(),
            $fileName
        );
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }

    public function getFile(string $fileName): string
{
    // dd($this->getTargetDirectory() . DIRECTORY_SEPARATOR . $fileName);

    $filePath = $this->getTargetDirectory() . DIRECTORY_SEPARATOR . $fileName;

    if (!file_exists($filePath)) {
        throw new \Exception('File not found: ' . $fileName);
    }

    return '/uploads/' . $fileName;
}

}
