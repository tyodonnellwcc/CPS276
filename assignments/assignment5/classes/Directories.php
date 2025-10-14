<?php
class Directories {
    private $directoryName;
    private $fileContent;
    private $basePath = "directories";

    public function __construct($directoryName, $fileContent) {
        $this->directoryName = $directoryName;
        $this->fileContent = $fileContent;
    }

    public function createDirectoryAndFile() {
        $targetPath = $this->basePath . "/" . $this->directoryName;

        if (file_exists($targetPath)) {
            return [
                'status' => 'error',
                'message' => "A directory already exists with that name."
            ];
        }

        if (!mkdir($targetPath, 0777, true)) {
            return [
                'status' => 'error',
                'message' => "Error: Directory could not be created."
            ];
        }

        $filePath = $targetPath . "/readme.txt";
        if (file_put_contents($filePath, $this->fileContent) === false) {
            return [
                'status' => 'error',
                'message' => "Error: File could not be created or written to."
            ];
        }

        return [
            'status' => 'success',
            'message' => "File and directory created successfully."
        ];
    }
}
?>