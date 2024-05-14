<!DOCTYPE html>
<html>
    <head>
        <title>Gambling room</title>
        <link rel="stylesheet" href="style.css" type="text/css" media="all">
        <link rel="shortcut icon" type="image/x-icon" href="slike/money.png">
    </head>
    <body class="background">
        <div class="okvir">
            <div class="naslov"><div class="slika1"></div><div class="dice"><h1>Dice Roll</h1></div><div class="slika2"></div></div>
            <form class="vpis" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="rounds">Number of Rounds:</label>
                <input type="number" id="rounds" name="rounds" min="1" required><br>
                <label for="player1">Player 1:</label>
                <input type="text" id="player1" name="players[]" required><br>
                <label for="player2">Player 2:</label>
                <input type="text" id="player2" name="players[]" required><br>
                <label for="player3">Player 3:</label>
                <input type="text" id="player3" name="players[]" required><br>
                <input type="submit" name="roll_dice" value="Roll the Dice">
            </form>

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['roll_dice'])) {
                function rollDice() {
                    return rand(1, 6);
                }

                if(isset($_POST['players']) && is_array($_POST['players'])) {
                    $players = $_POST['players'];
                } else {
                    // Default player names
                    $players = array("Player 1", "Player 2", "Player 3");
                }

                $rounds = isset($_POST['rounds']) ? intval($_POST['rounds']) : 1;

                $results = array();
                $totals = array();

                foreach ($players as $player) {
                    $totals[$player] = 0; // Initialize total score for each player
                }
                echo "<div class='game-results'>";
                for ($i = 1; $i <= $rounds; $i++) {
                    echo "<h3>Round $i</h3>";
                    foreach ($players as $player) {
                        $roll = rollDice();
                        $results[$player][$i] = $roll;
                        $totals[$player] += $roll;
                        echo "$player rolled: $roll<br>";
                    }
                }

                // Finding the winner
                arsort($totals);
                $winner = key($totals);
                $winningScore = current($totals);

                echo "<br>$winner wins with a total score of $winningScore!<br>";

                // Display total scores for each player
                echo "<br>Total Scores:<br>";
                foreach ($totals as $player => $score) {
                    echo "$player: $score<br>";
                }
                echo "</div>";
            }
            ?>
        </div>
    </body>
</html>