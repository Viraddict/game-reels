<?php

namespace Game\App\Actions;

use Game\App\Game;
use Game\App\Interfaces\ActionInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class SpinAction implements ActionInterface
{
    /**
     * Game container
     *
     * @var Game
     */
    private $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }

    public function handle(Request $request): array
    {
        $this->game->user()->decrementBalance($this->game->betCoins());

        $reels = $this->game->service()->generateReelsFrame();
        $lines = $this->game->service()->generateLines($reels, $this->game->betCoins());

        $totalWin = 0;

        array_walk($lines, function ($value) use (&$totalWin) { 
            $totalWin =  $totalWin + $value['win']; 
        });

        $this->game->user()->incrementBalance($totalWin);

        $this->game->user()->save();

        return [
            "action" => "spin",
            "bet" => $this->game->bet(),
            "lines" => $lines,
            "win" => $totalWin,
            "totalWin" => $totalWin,
            "winSyms" => 0,
            "reels" => $reels,
            "nReels" => $this->game->service()->generateReelsFrame(6),
            "feature" => "basic",
            "nextAction" => "spin",
            "balance" => $this->game->user()->balance()
        ];
    }
}