<?php

namespace Game\App\Services;

class GameService
{
    /**
     * Letter for passing combination
     */
    private const COMBINATION_PASS = "x";

    /**
     * Position for passing combination
     */
    private const POSITION_PASS = -1;

    /**
     * Wild Symbol
     *
     * @var mixed
     */
    private $wildSym = null;

    /**
     * Dictionary symbols combinations 
     *
     * @var array
     */
    private $symCombinations = [];

    /**
     * Game's reels
     *
     * @var array
     */
    private $reels;

    /**
     * Game's lines
     *
     * @var array
     */
    private $lines;


    /**
     * Construct
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->betCoins = $config['betCoins'];

        $this->reels = $config['reels'];
        $this->lines = $config['lines'];

        $this->wildSym = $config['wildSym'] ?? null;

        $this->symCombinations = $this->makeSymDictionary($config['paytable']);
    }

    /**
     * Generate randomly frame sized $frameSize in game's reels 
     *
     * @param int $frameSize - Frame size 
     *
     * @return int[]
     */
    public function generateReelsFrame(int $frameSize = 4)
    {
        $reels = [];

        foreach ($this->reels as $i => $reel) {
            $reelCount = count($reel);
            $frameStart = random_int(0, $reelCount - 1);
            
            $frame = array_slice($reel, $frameStart, $frameSize);

            if ($frameStart + $frameSize > $reelCount) {
                $frame = array_merge(
                    $frame,
                    array_slice($reel, 0, $frameSize - ($reelCount - $frameStart))
                );
            }
            $reels[$i] = $frame;
        }

        return $reels;
    }


    /**
     * Check lines by frame reels and check by paytable
     *
     * @param array $reels
     *
     * @return array
     */
    public function generateLines(array $reels, int $betInCoins)
    {
        $lines = [];

        foreach ($this->lines as $iLine => $line)
        {
            $lineCnt = count($line);
            $comb = array_fill(0, $lineCnt, self::COMBINATION_PASS);
            $pos = array_fill(0, $lineCnt, self::POSITION_PASS);
            $sym = -1;
            $n = 0;

            foreach($line as $iReel => $iPos) {
                if (isset($reels[$iReel][$iPos])) {
                    if ($sym === -1) {
                        $sym = $reels[$iReel][$iPos];
                    }

                    if ($reels[$iReel][$iPos] === $sym 
                        || ($this->wildSym 
                            && $reels[$iReel][$iPos] === $this->wildSym)
                    ) {
                        $n++;
                        $comb[$iReel] = $reels[$iReel][$iPos];
                        $pos[$iReel] = $iPos;
                    } else {
                        break;
                    }
                }
            }

            // check combination by symCombinations
            if (isset($this->symCombinations[$sym][$n])) {
                $mul = $this->symCombinations[$sym][$n];

                $lines[] = [
                    'line' => $iLine,
                    'sym' => $sym,
                    'n' => $n,
                    'pos' => $pos,
                    'comb' => $comb,
                    'dir' => "left",
                    'mul' => $mul,
                    'win' => $this->calculateWin($mul, $betInCoins)
                ];
            } 
        }

        return $lines;
    }


    /**
     * Make Dictionary from paytables 
     *
     * @param array $paytable
     *
     * @return array
     */    
    private function makeSymDictionary(array $paytable)
    {
        $symDictionary = [];

        foreach ($paytable as $combination) {
            $sym = $combination["sym"];
            $n = $combination["n"];

            if (!isset($symDictionary[$sym])) {
                $symDictionary[$sym] = [];
            }

            $symDictionary[$sym][$n] = $combination["mul"];
        }

        return $symDictionary;
    }

    /**
     * Calculate win by line combination
     *
     * @param int $mul
     *
     * @return int
     */
    private function calculateWin(int $mul, int $betInCoins): int
    {
        return (int) (round($betInCoins / count($this->lines)) * $mul);
    }
}