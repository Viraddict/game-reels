<?php

namespace Game\App;

use Exception;
use Game\App\Factories\StorageFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Application
{
    /**
     * Game Container
     *
     * @var Game
     */
    private $game;

    /**
     * App construct
     */
    public function __construct()
    {
        $storage = StorageFactory::make(config('app'));

        $game = (new Game(config('game')))
            ->setStorage($storage);

        $this->game = $game;
    }

    /**
     * Handle http request
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        try {
            $this->transformRequest($request);

            $data = $this->game->executeAction($request);

            return new JsonResponse($data);
        } catch (\Throwable $e) {
            return new JsonResponse(["error" => $e->getMessage()], $e->getCode());
        }

    }

    /**
     * Transform Symfony Json Request 
     *
     * @param Request $request
     *
     * @return void
     */
    private function transformRequest(Request &$request)
    {
        if ($request->getContentType() != 'json' || !$request->getContent()) {
            return;
        }
        
        $data = json_decode($request->getContent(), true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid json body.');
        }
        
        $request->request->replace(is_array($data) ? $data : []);
    }
}