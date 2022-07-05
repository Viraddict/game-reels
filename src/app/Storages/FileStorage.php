<?php

namespace Game\App\Storages;

use Game\App\Interfaces\StorageInterface;

class FileStorage implements StorageInterface
{
    private $cachePath;

    public function __construct(array $config)
    {
        $this->cachePath = rtrim($config['path'], '/') . '/';
    }

    public function find(string $key): array
    {   
        $path = $this->fullpath($key);

        if (file_exists($path)) {
            $entity = file_get_contents($path);

            return json_decode($entity, true);
        }

        return [];
    }

    public function save(string $key, array $data): bool
    {
        $path = $this->fullpath($key);

        return file_put_contents($path, json_encode($data));
    }

    public function has(string $key): bool
    {   
        $path = $this->fullpath($key);

        return file_exists($path);
    }

    private function fullpath(string $key): string
    {
        return $this->cachePath . $key;
    }
}