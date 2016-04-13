<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <meta charset="UTF-8">
    <title>Maze Generator</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
<h1>MAZE GENERATOR</h1>
<form action="index.php" method="post">
    <input type="number" name="x" min="5" placeholder="x value" required value="21">
    <input type="number" name="y" min="5" placeholder="y value" required value="=21">
    <input type="submit">
</form>
<hr>
<?php
require_once('Maze.php');
$x=($_POST['x'] == null)?21:$_POST['x'] ;
$y=($_POST['y'] == null)?21:$_POST['y'] ;
$testMaze2 = new Maze($x, $y, 2);
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