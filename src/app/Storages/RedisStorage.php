<?php

namespace Game\App\Storages;

use Game\App\Interfaces\StorageInterface;
use Predis\Client;
use Predis\Response\Status;

class RedisStorage implements StorageInterface
{

    private Client $client;

    public function __construct(array $config)
    {
        $this->client = new Client($config);
    }

    public function find(string $key): array
    {  
        $entity = $this->client->get($key);

        return $entity ? json_decode($entity, true) : [];
    }

    public function save(string $key, array $data): bool
    {
        $status = $this->client->set($key, json_encode($data));
        
        return true;
    }

    public function has(string $key): bool
    {   
        return (bool) $this->client->exists($key);
    }
}