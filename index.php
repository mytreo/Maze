<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Maze Generator</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
<?php
require_once('Maze.php');
$testMaze2 = new Maze(21, 21, 2);
?>
<div class="main">
    <br>
    <?php
    for ($i = 0; $i < $testMaze2->size_x; $i++) {
        for ($j = 0; $j < $testMaze2->size_y; $j++) {
            if ($testMaze2->maze[$i][$j] == 'X') {
                echo "<div class=\"wall block\"></div>";
            } elseif ($testMaze2->maze[$i][$j] == '*') {
                echo "<div class=\"way block\"></div>";
            } else {
                echo "<div class=\"exit block\"></div>";
            }
        }
        echo "<br>";
    } ?>
</div>
</body>
</html>