<?php 

class BaseDto {
    protected function validateRequired(array $data, string $key, string $fieldName): mixed {
        if (!isset($data[$key]) || empty(trim($data[$key]))) {
            throw new Exception("Vui lòng điền {$fieldName}.");
        }
        return $data[$key];
    }

    protected function validateFileUpload(array $files, string $key, string $fieldName): array {
        if (!isset($files[$key]) || !is_array($files[$key]) || empty($files[$key]['name'])) {
            throw new Exception("Vui lòng upload {$fieldName}.");
        }
        return $files[$key];
    }
}