<?php

namespace Game\App\Factories;

use Game\App\Interfaces\StorageInterface;
use Game\App\Storages\FileStorage;
use Game\App\Storages\RedisStorage;

class StorageFactory
{
    public static function make(array $config): StorageInterface
    {
        $storageType = $config['storage'];

        switch ($storageType) 
        {
            case 'file': 
                return new FileStorage($config['stores']['file']); 
                break;
            case 'redis': 
                return new RedisStorage($config['stores']['redis']);
                break;
        }
    }
}