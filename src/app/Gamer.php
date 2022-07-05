<?php

namespace Game\App;

use Game\App\Interfaces\StorageInterface;

class Gamer
{
    /**
     * Start gamer balance
     */
    public const START_BALANCE = 10000;

    /**
     * Storage for saving user data
     *
     * @var StorageInterface
     */
    private StorageInterface $storage;

    /**
     * Uniq user id
     *
     * @var string|null
     */
    private ?string $id = null;

    /**
     * User balance
     *
     * @var int
     */
    private int $balance = 0;

    /**
     * Custom params 
     *
     * @var array
     */
    private array $params = [];


    public function __construct(array $attributes = [])
    {
        if (!empty($attributes)) {
            $this->id = $attributes['id'] ?? null;
            $this->balance = $attributes['balance'] ?? self::START_BALANCE;
            $this->params = $attributes['params'] ?? [];
        }
    }

    /**
     * Get id attribute
     *
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * Get balance attribute
     *
     * @return int
     */
    public function balance(): int 
    {
        return $this->balance;
    }

    /**
     * Init storage 
     *
     * @param StorageInterface $storage
     *
     * @return void
     */
    public function setStorage(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Begin instance on a given storage.
     *
     * @param  StorageInterface|null  $storage
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function on($storage = null)
    {
        $instance = new static;

        $instance->setStorage($storage);

        return $instance;
    }

    /** 
     * Serialize instance's attributes to array
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id(),
            'balance' => $this->balance(),
            'params' => [
                'ip' => $this->params['ip'],
                'user_agent' => $this->params['user_agent']
            ]
        ];
    }

    /**
     * Increment balance
     *
     * @param int $amount
     *
     * @return void
     */
    public function incrementBalance(int $amount)
    {
        $this->balance += abs($amount);
    }

    /**
     * Decrement balance
     *
     * @param int $amount
     *
     * @return void
     */
    public function decrementBalance(int $amount)
    {
        $this->balance -= abs($amount);
    }


    /**
     * Find gamer in storage
     *
     * @param string $id
     *
     * @return self|null
     */
    public function find(string $id)
    {
        $instance = null;
        if ($attributes = $this->storage->find($id)) {
            $instance = new static($attributes);

            $instance->setStorage($this->storage);
        }

        return $instance;
    }


    /**
     * Save changes into storage
     *
     * @return self
     */
    public function create(array $attributes): Gamer
    {
        $instance = new static($attributes);

        $instance->setStorage($this->storage);

        $instance->save();
        
        return $instance;
    }

    /**
     * Save changes into storage
     *
     * @return bool
     */
    public function save(): bool
    {
        return $this->storage->save($this->id(), $this->toArray());
    }



}