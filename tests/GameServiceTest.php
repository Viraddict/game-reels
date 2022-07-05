<?php

namespace Game\App\Tests;

use Game\App\Services\GameService;
use PHPUnit\Framework\TestCase;

final class GameServiceTest extends TestCase
{

    /**
     * Game Service
     *
     * @var GameService
     */
    private  static GameService $service;

    /**
     * Bet in coins
     *
     * @var int
     */
    private static int $bet;

    public static function setUpBeforeClass(): void
    {
        $config = include_once(__DIR__ . '/../src/config/game.php');

        self::$service = new GameService($config);

        self::$bet = 40;
    }

    /**
     * @test
     */
    public function oneLine()
    {
        $reels = [
            [
                6,
                7,
                4,
                8
            ],
            [
                9,
                7,
                6,
                10
            ],
            [
                2,
                7,
                2,
                2
            ],
            [
                9,
                9,
                11,
                6
            ],
            [
                11,
                10,
                10,
                10
            ]
        ];



        $lines = self::$service->generateLines($reels, self::$bet);

        $this->assertEquals($lines, [
            [
                "line" => 0,
                "sym" => 7,
                "n" => 3,
                "pos" => [
                    1,
                    1,
                    1,
                    -1,
                    -1
                ],
                "comb" => [
                    7,
                    7,
                    7,
                    "x",
                    "x"
                ],
                "dir" => "left",
                "mul" => 20,
                "win" => 20
            ]
        ]);
    }

    /**
     * @test
     */
    public function fiveLines()
    {
        $reels = [
            [
                2,
                2,
                2,
                2
            ],
            [
                11,
                7,
                2,
                2
            ],
            [
                2,
                2,
                7,
                2
            ],
            [
                7,
                5,
                11,
                7
            ],
            [
                11,
                9,
                11,
                7
            ]
        ];


        $lines = self::$service->generateLines($reels, self::$bet);

        $this->assertEquals($lines, [
                [
               "line" => 1,
               "sym" => 2,
               "n" => 2,
               "pos" => [
                   2,
                   2,
                   -1,
                   -1,
                   -1
               ],
               "comb" => [
                   2,
                   2,
                   "x",
                   "x",
                   "x"
               ],
               "dir" => "left",
               "mul" => 4,
               "win" => 4
           ],
            [
               "line" => 3,
               "sym" => 2,
               "n" => 3,
               "pos" => [
                   3,
                   3,
                   3,
                   -1,
                   -1
               ],
               "comb" => [
                   2,
                   2,
                   2,
                   "x",
                   "x"
               ],
               "dir" => "left",
               "mul" => 40,
               "win" => 40
           ],
            [
               "line" => 4,
               "sym" => 2,
               "n" => 3,
               "pos" => [
                   1,
                   2,
                   3,
                   -1,
                   -1
               ],
               "comb" => [
                   2,
                   2,
                   2,
                   "x",
                   "x"
               ],
               "dir" => "left",
               "mul" => 40,
               "win" => 40
           ],
            [
               "line" => 7,
               "sym" => 2,
               "n" => 2,
               "pos" => [
                   3,
                   3,
                   -1,
                   -1,
                   -1
               ],
               "comb" => [
                   2,
                   2,
                   "x",
                   "x",
                   "x"
               ],
               "dir" => "left",
               "mul" => 4,
               "win" => 4
           ],
            [
               "line" => 9,
               "sym" => 2,
               "n" => 3,
               "pos" => [
                   2,
                   3,
                   3,
                   -1,
                   -1
               ],
               "comb" => [
                   2,
                   2,
                   2,
                   "x",
                   "x"
               ],
               "dir" => "left",
               "mul" => 40,
               "win" => 40
           ],
            [
               "line" => 11,
               "sym" => 2,
               "n" => 3,
               "pos" => [
                   3,
                   2,
                   1,
                   -1,
                   -1
               ],
               "comb" => [
                   2,
                   2,
                   2,
                   "x",
                   "x"
               ],
               "dir" => "left",
               "mul" => 40,
               "win" => 40
           ],
            [
               "line" => 13,
               "sym" => 2,
               "n" => 2,
               "pos" => [
                   2,
                   3,
                   -1,
                   -1,
                   -1
               ],
               "comb" => [
                   2,
                   2,
                   "x",
                   "x",
                   "x"
               ],
               "dir" => "left",
               "mul" => 4,
               "win" => 4
           ],
            [
               "line" => 15,
               "sym" => 2,
               "n" => 3,
               "pos" => [
                   3,
                   2,
                   3,
                   -1,
                   -1
               ],
               "comb" => [
                   2,
                   2,
                   2,
                   "x",
                   "x"
               ],
               "dir" => "left",
               "mul" => 40,
               "win" => 40
           ],
            [
               "line" => 16,
               "sym" => 2,
               "n" => 3,
               "pos" => [
                   1,
                   2,
                   1,
                   -1,
                   -1
               ],
               "comb" => [
                   2,
                   2,
                   2,
                   "x",
                   "x"
               ],
               "dir" => "left",
               "mul" => 40,
               "win" => 40
           ],
            [
               "line" => 19,
               "sym" => 2,
               "n" => 2,
               "pos" => [
                   3,
                   2,
                   -1,
                   -1,
                   -1
               ],
               "comb" => [
                   2,
                   2,
                   "x",
                   "x",
                   "x"
               ],
               "dir" => "left",
               "mul" => 4,
               "win" => 4
           ],
            [
               "line" => 21,
               "sym" => 2,
               "n" => 3,
               "pos" => [
                   2,
                   2,
                   1,
                   -1,
                   -1
               ],
               "comb" => [
                   2,
                   2,
                   2,
                   "x",
                   "x"
               ],
               "dir" => "left",
               "mul" => 40,
               "win" => 40
           ],
            [
               "line" => 23,
               "sym" => 2,
               "n" => 3,
               "pos" => [
                   2,
                   2,
                   3,
                   -1,
                   -1
               ],
               "comb" => [
                   2,
                   2,
                   2,
                   "x",
                   "x"
               ],
               "dir" => "left",
               "mul" => 40,
               "win" => 40
           ],
            [
               "line" => 24,
               "sym" => 2,
               "n" => 2,
               "pos" => [
                   1,
                   2,
                   -1,
                   -1,
                   -1
               ],
               "comb" => [
                   2,
                   2,
                   "x",
                   "x",
                   "x"
               ],
               "dir" => "left",
               "mul" => 4,
               "win" => 4
           ],
            [
               "line" => 27,
               "sym" => 2,
               "n" => 2,
               "pos" => [
                   3,
                   3,
                   -1,
                   -1,
                   -1
               ],
               "comb" => [
                   2,
                   2,
                   "x",
                   "x",
                   "x"
               ],
               "dir" => "left",
               "mul" => 4,
               "win" => 4
           ],
            [
               "line" => 29,
               "sym" => 2,
               "n" => 3,
               "pos" => [
                   3,
                   2,
                   1,
                   -1,
                   -1
               ],
               "comb" => [
                   2,
                   2,
                   2,
                   "x",
                   "x"
               ],
               "dir" => "left",
               "mul" => 40,
               "win" => 40
           ],
            [
               "line" => 31,
               "sym" => 2,
               "n" => 3,
               "pos" => [
                   3,
                   3,
                   3,
                   -1,
                   -1
               ],
               "comb" => [
                   2,
                   2,
                   2,
                   "x",
                   "x"
               ],
               "dir" => "left",
               "mul" => 40,
               "win" => 40
           ],
            [
               "line" => 33,
               "sym" => 2,
               "n" => 3,
               "pos" => [
                   2,
                   3,
                   3,
                   -1,
                   -1
               ],
               "comb" => [
                   2,
                   2,
                   2,
                   "x",
                   "x"
               ],
               "dir" => "left",
               "mul" => 40,
               "win" => 40
           ],
            [
               "line" => 35,
               "sym" => 2,
               "n" => 2,
               "pos" => [
                   3,
                   2,
                   -1,
                   -1,
                   -1
               ],
               "comb" => [
                   2,
                   2,
                   "x",
                   "x",
                   "x"
               ],
               "dir" => "left",
               "mul" => 4,
               "win" => 4
           ],
            [
               "line" => 37,
               "sym" => 2,
               "n" => 2,
               "pos" => [
                   2,
                   3,
                   -1,
                   -1,
                   -1
               ],
               "comb" => [
                   2,
                   2,
                   "x",
                   "x",
                   "x"
               ],
               "dir" => "left",
               "mul" => 4,
               "win" => 4
           ],
            [
               "line" => 39,
               "sym" => 2,
               "n" => 3,
               "pos" => [
                   3,
                   2,
                   1,
                   -1,
                   -1
               ],
               "comb" => [
                   2,
                   2,
                   2,
                   "x",
                   "x"
               ],
               "dir" => "left",
               "mul" => 40,
               "win" => 40
           ]
        ]);
    }
}