<?php

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

//uasort($examplPointArray, "pointSort");
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
?>