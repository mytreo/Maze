<?php
require_once('Point.php');

class Maze
{
    const WALL = 'X';
    const OPPORTUNITY = 0;
    const WAY = '*';
    const EXIT_CELL = 'E';
    public $size_x;
    public $size_y;
    public $maze;

    //$type 1 recursive max 21*21, 2
    public function __construct($x = 3, $y = 3, $type = 2)
    {
        $this->size_x = $x;
        $this->size_y = $y;
        $this->maze = $this-> createMazeMatrix($this->size_x, $this->size_y);
        ($type == 1) ? $this->pathFinder(new Point(1, 1), array()) : $this->pathFinder2(new Point(1,1), array());

        for ($i = 0; $i < $this->size_x; $i++) {
            for ($j = 0; $j < $this->size_y; $j++) {
                if ($this->maze[$i][$j] === 0) {
                    $this->maze[$i][$j] = self::WALL;
                }
            }
        }
        $this->maze[1][0] = self::WAY;
    }

    private function createMazeMatrix($size_x, $size_y)
    {
        $simpleMaze = array();
        for ($i = 0; $i < $size_x; $i++) {
            $y_row = array();
            for ($j = 0; $j < $size_y; $j++) {
                if ($i == 0 || $i == ($size_x - 1)) {
                    $y_row[$j] = self::WALL;
                } elseif ($j == 0 || $j == ($size_y - 1) || ($j % 2 == 0)) {
                    $y_row[$j] = self::WALL;
                } else {
                    $y_row[$j] = self::OPPORTUNITY;
                }
            }
            $simpleMaze[$i] = $y_row;
        }
        return $simpleMaze;
    }

    public function print_maze()
    {
        echo "\n";
        for ($i = 0; $i < $this->size_x; $i++) {
            for ($j = 0; $j < $this->size_y; $j++) {
                echo $this->maze[$i][$j];
            }
            echo "\n";
        }
        echo "\n";
    }

    private function setPointAvalaible($point)
    {
        $this->maze[$point->x][$point->y] = self::WAY;
    }

    private function setPointExit($point)
    {
        $this->maze[$point->x][$point->y] = self::EXIT_CELL;
    }

    private function getPointNeightbours($point)
    {
        $neightbourPoints = array();
        $testpoints = array(
            'up' => new Point(($point->x) - 2, ($point->y)),
            'down' => new Point(($point->x) + 2, ($point->y)),
            'left' => new Point(($point->x), ($point->y) - 2),
            'right' => new Point(($point->x), ($point->y) + 2)
        );

        foreach ($testpoints as $testPoint) {
            if ($testPoint->x > 0
                && $testPoint->y > 0
                && $testPoint->x < $this->size_x
                && $testPoint->y < $this->size_y
                && $this->maze[$testPoint->x][$testPoint->y] === 0
            ) {
                $neightbourPoints[] = $testPoint;
            }
        }
        return $neightbourPoints;
    }

    private function setWay($p1, $p2)
    {
        $dX = (($p2->x) - ($p1->x)) / 2;
        $dY = (($p2->y) - ($p1->y)) / 2;
        $wallPoint = new Point($p1->x + $dX, $p1->y + $dY);
        $this->setPointAvalaible($wallPoint);
    }

    private function pathFinder($tmpPoint, $way)
    {
        $way[] = $tmpPoint;
        $this->setPointAvalaible($tmpPoint);
        $neightbours = $this->getPointNeightbours($tmpPoint);
        do {
            if (count($neightbours) == 0) {
                if (count($way) > 1) {
                    array_pop($way);
                    // $this->setPointExit($tmpPoint);
                    $tmpPoint = array_pop($way);
                    return $this->pathFinder($tmpPoint, $way);
                } else {
                    return null;
                }
            } else {
                $neightbour = $neightbours[mt_rand(0, count($neightbours) - 1)];
                $this->setWay($tmpPoint, $neightbour);
                $tmpPoint = $neightbour;
                return $this->pathFinder($tmpPoint, $way);
            }
        } while ($tmpPoint != new Point(1, 1));
    }

    private function pathFinder2($startPoint)
    {
        $way = [];
        $maxWayCount = count($way);
        $tmpPoint = clone $startPoint;
        $maxWayValue = $tmpPoint;
        $way[] = $tmpPoint;
        do {
            $neightbours = $this->getPointNeightbours($tmpPoint);
            while (count($neightbours) != 0) {
                $this->setPointAvalaible($tmpPoint);
                $neightbour = $neightbours[mt_rand(0, count($neightbours) - 1)];
                $this->setWay($tmpPoint, $neightbour);
                $tmpPoint = $neightbour;
                $way[] = $tmpPoint;
                if (count($way) > $maxWayCount) {
                    $maxWayCount = count($way);
                    $maxWayValue = $tmpPoint;
                }
                $this->setPointAvalaible($tmpPoint);
                $neightbours = $this->getPointNeightbours($tmpPoint);
            }
            array_pop($way);
            $tmpPoint = array_pop($way);
        } while (($tmpPoint->x === $startPoint->x) && ($tmpPoint->y === $startPoint->y));

        $this->setPointExit($maxWayValue);
    }

}

?>