<?php

namespace Game\App\Interfaces;

interface StorageInterface
{
    public function find(string $key): array;

    public function save(string $key, array $data): bool;

    public function has(string $key): bool;

}