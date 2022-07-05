<?php

namespace Game\App\Actions;

use Game\App\Interfaces\ActionInterface;
use Game\App\Responses\InitResponse;
use Game\App\Game;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class InitAction implements ActionInterface
{
    /**
     * Game container
     *
     * @var Game
     */
    private Game $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function handle(Request $request): array
    {
        return [
            "action" => "init",
            "homeURL" => [
                "url" => "javascript:history.back()",
                "show" => true
            ],
            "language" => $this->game->config('language'),
            "currency" => $this->game->config('currency'),
            "gameId" => $this->game->config('gameId'),
            "gameName" => $this->game->config('gameName'),
            "gameConfig" => $this->game->config('gameConfig'),
            "balance" => $this->game->user()->balance(),
            "bets" => $this->game->config('bets'),
            "bet" => $this->game->bet(),
            "betCoins" => $this->game->config('betCoins'),
            "lines" => $this->game->config('lines'),
            "paytable" => $this->game->config('paytable'),
            "reels" => $this->game->service()->generateReelsFrame(4),
            "nReels" => $this->game->service()->generateReelsFrame(6),
            "feature" =>  "basic",
            "nextAction" => "spin"
        ];
    }
}