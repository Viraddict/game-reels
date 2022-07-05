<?php

namespace Game\App;

use Exception;
use Game\App\Interfaces\StorageInterface;
use Game\App\Services\GameService;
use Symfony\Component\HttpFoundation\Request;

class Game
{
    /**
     * Storage
     *
     * @var StorageInterface
     */
    private StorageInterface $storage;

    /**
     * Current gamer
     *
     * @var Gamer|null
     */
    private ?Gamer $user;

    /**
     * Game config
     *
     * @var array
     */
    private array $config;

    /**
     * Gamer's bet
     *
     * @var int
     */
    private int $bet;

    /**
     * Action
     *
     * @var string
     */
    private string $action;

    /**
     * Game Service 
     *
     * @var GameService
     */
    private GameService $service;


    public function __construct(array $config)
    {
        $this->config = $config;

        $this->service = new GameService($this->config);
    }

    public function executeAction(Request $request)
    {   
        $this->validate($request);

        $this->init($request);

        $actionClass = 'Game\App\Actions\\' . ucfirst($this->action) . 'Action';

        try {
            $action = new $actionClass($this);
            return $action->handle($request);

        } catch (\Throwable $e) {
            throw new Exception("Unknown action.", 500);
        }
        
    }

    private function validate(Request $request)
    {
        if (!$request->request->has('bet')) {
            throw new Exception("Param 'bet' required.", 422);
        }

        if (!$request->request->has('action')) {
            throw new Exception("Param 'action' required.", 422);
        }
        
        if (!in_array($request->get('bet'), $this->config['bets'])) {
            throw new Exception("Param 'bet' has invalid value", 422);
        }

        if (!in_array($request->get('action'), ['init', 'spin'])) {
            throw new Exception("Param 'action' has invalid value", 422);
        }
    }


    /**
     * Init system params
     *
     * @param Request $request
     *
     * @return void
     */
    private function init(Request $request): void
    {
        $this->bet = $request->get('bet');
        $this->action = $request->get('action');

        $sessionUuid = $this->uuid($request->headers->get('User-Agent'), $request->getClientIp());

        $this->user = Gamer::on($this->storage)->find($sessionUuid);

        if (!$this->user) {
            $this->user = Gamer::on($this->storage)->create([
                'id' => $sessionUuid,
                'params' => [
                    'ip' => $request->getClientIp(),
                    'user_agent' => $request->headers->get('User-Agent')
                ]
            ]);
            $this->user->save();
        }

    }

    /**
     * Set Storage 
     *
     * @param StorageInterface $storage
     *
     * @return void
     */
    public function setStorage(StorageInterface $storage): Game
    {
        $this->storage = $storage;

        return $this;
    }

    /**
     * Return current user
     *
     * @return Gamer
     */    
    public function user(): Gamer
    {
        return $this->user;
    }

    /**
     * Return current bet
     *
     * @return int
     */
    public function bet(): int
    {
        return $this->bet;
    }

    /**
     * Return betCoins
     *
     * @return int
     */
    public function betCoins(): int
    {
        return $this->bet * $this->config['betCoins'];
    }

    /**
     * Return game service
     *
     * @return GameService
     */    
    public function service(): GameService
    {
        return $this->service;
    }

    /**
     * Return config variables
     *
     * @return mixed
     */    
    public function config(string $key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }

    /**
     * Make uniq user id
     *
     * @param string[] ...$params
     *
     * @return string
     */
    private function uuid(...$params): string
    {
        return md5(implode($params));
    }


}