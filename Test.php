<?php

/**
 * Created by PhpStorm.
 * User: 1
 * Date: 11.04.2016
 * Time: 13:04
 */
class Point
{
    public $x;
    public $y;

    public function __construct($xCoord = 0, $yCoord = 0)
    {
        $this->x = $xCoord;
        $this->y = $yCoord;
    }

    public function __toString()
    {
        return "(" . $this->x . "," . $this->y . ")";
    }
}

class Maze
{
    public $size_x;
    public $size_y;
    public $maze;

    public function __construct($x = 3, $y = 3)
    {
        $this->size_x = $x;
        $this->size_y = $y;
        $this->maze = $this->create_maze($this->size_x, $this->size_y);
    }


    private function create_maze($size_x, $size_y)
    {
        $simpleMaze = array();
        for ($i = 0; $i < $size_x; $i++) {
            $y_row = array();
            for ($j = 0; $j < $size_y; $j++) {
                if ($i == 0 || $i == ($size_x - 1)) {
                    $y_row[$j] = 'X';
                } elseif ($j == 0 || $j == ($size_y - 1) || ($j % 2 == 0)) {
                    $y_row[$j] = 'X';
                } else {
                    $y_row[$j] = 0;
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
        $this->maze[$point->x][$point->y] = '^';
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


    public function pathFinder($tmpPoint, $way)
    {
        echo $tmpPoint . "\n";

        $way[] = $tmpPoint;
        $this->setPointAvalaible($tmpPoint);
        $neightbours = $this->getPointNeightbours($tmpPoint);
        do {
            if (count($neightbours) == 0) {
                if (count($way) > 1) {
                    array_pop($way);
                    $tmpPoint = array_pop($way);
                    return $this->pathFinder($tmpPoint, $way);
                } else {
                    return $way;
                }
            } else {
                $neightbour = $neightbours[mt_rand(0, count($neightbours) - 1)];
                $this->setWay($tmpPoint, $neightbour);
                $tmpPoint = $neightbour;
                return $this->pathFinder($tmpPoint, $way);
            }
        } while ($tmpPoint != new Point(1, 1));
    }
}


$way = array();


$p = new Point(1, 1);
$testMaze = new Maze(11, 11);

$way = $testMaze->pathFinder($p, array());

$testMaze->print_maze();


function pointSort($p1, $p2)
{
    if ($p1->x < $p2->x) {
        return -1;
    } elseif ($p1->x > $p2->x) {
        return 1;
    } elseif ($p1->y < $p2->y) {
        return -1;
    } elseif ($p1->y > $p2->y) {
        return 1;
    } else {
        return 0;
    }
}

/*echo "count = " . count($way) . "\n";
foreach($way as $a) {
    echo $a;
}
uasort($way, "pointSort");
array_unique($way, SORT_REGULAR);
echo "\n";
echo "count = " . count($way) . "\n";
foreach($way as $a) {
        echo $a;
}*/

/*$way[] = $neightbour;
$cnt = count($way);
$testMaze->setWay($way[($cnt - 2)], $way[($cnt - 1)]);

$p = $neightbour;

while (count($neightbours) > 0) {
    echo "i";
    $neightbours = $testMaze->getPointNeightbours($p);
    $neightbour = $neightbours[mt_rand(0, count($neightbours) - 1)];
    $way[] = $neightbour;
    $cnt = count($way);
    $testMaze->setWay($way[($cnt - 2)], $way[($cnt - 1)]);
}
*/


/*





;*/


/* y->
4.4  4.5  4.6
5.4  5.5  5.6
6.4  6.5  6.6
*/


/*
var_dump($p);
$p->x = 8;
var_dump($p);
$testMaze = create_maze(21, 21);
print_maze($testMaze);
echo "\n\n\n";
$testMaze = setPointAvalaible($p, $testMaze);
print_maze($testMaze);*/


?>