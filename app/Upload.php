<?php

namespace App;

use Psr\Http\Message\UploadedFileInterface;

class Upload
{
    protected string $path;

    protected array $formats = [];

    public function __construct(?string $path = null)
    {
        if ($path) {
            $this->path = $path;
        }
    }

    /**
     * @param UploadedFileInterface $file
     * @param null|string $oldFile
     * @param null|string $filename
     * @return null|string
     */
    public function upload(UploadedFileInterface $file, ?string $oldFile = null, ?string $filename = null): ?string
    {
        if ($file->getError() === UPLOAD_ERR_OK) {
            $this->deleteFile($oldFile);
            $targetPath = $this->AddCopySuffix(
                $this->path .
                DIRECTORY_SEPARATOR .
                ($filename ?: $file->getClientFilename())
            );
            $dirname = pathinfo($targetPath, PATHINFO_DIRNAME);
            if (!file_exists($dirname)) {
                mkdir($dirname, 777, true);
            }
            $file->moveTo($targetPath);
            $this->generateFormats($targetPath);
            return pathinfo($targetPath)['basename'];
        }
        return null;
    }

    public function deleteFile(?string $oldFile): void
    {
        if ($oldFile) {
            $oldFile = $this->path . DIRECTORY_SEPARATOR . $oldFile;
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
            foreach ($this->formats as $format => $s) {
                $oldFileWithFormat = $this->getPathWithSuffix($oldFile, $format);
                if (file_exists($oldFileWithFormat)) {
                    unlink($oldFileWithFormat);
                }
            }
        }
    }

    private function addCopySuffix(string $targetPath): string
    {
        if (file_exists($targetPath)) {
            return $this->AddCopySuffix($this->getPathWithSuffix($targetPath, 'copy'));
        }
        return $targetPath;
    }

    private function getPathWithSuffix(string $path, string $suffix): string
    {
        $info = pathinfo($path);
        return $info['dirname'] .
            DIRECTORY_SEPARATOR .
            $info['filename'] .
            '_' . $suffix . '.' .
            $info['extension'];
    }

}