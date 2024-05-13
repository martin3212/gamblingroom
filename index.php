<!DOCTYPE html>
<html>
    <head>
        <title>Gambling room</title>
        <link rel="stylesheet" href="style.css" type="text/css" media="all">
        <link rel="shorcut icon" type="image/x-icon" href="slike/money.png">
    </head>
    <body class="background">
        <div class="okvir">
            

            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="submit" name="roll_dice" value="Roll the Dice">
            </form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['roll_dice'])) {
    function rollDice() {
        return rand(1, 6);
    }

    $players = array(
        "Player 1",
        "Player 2",
        "Player 3"
    );

    $results = array();

    foreach ($players as $player) {
        $roll = rollDice();
        $results[$player] = $roll;
        echo "$player rolled: $roll<br>";
    }

    // Finding the winner
    arsort($results);
    $winner = key($results);
    $winningRoll = current($results);

    echo "<br>$winner wins with a roll of $winningRoll!<br>";

    // Display all rolls
    echo "<br>Rolls Summary:<br>";
    foreach ($results as $player => $roll) {
        echo "$player rolled: $roll<br>";
    }
}
?>

        </div>
    </body>
</html>