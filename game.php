<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Helper function to print debug information (optional)
function debug_output($data) {
    file_put_contents('debug.log', print_r($data, true), FILE_APPEND);
}

// Handle dice rolling for each round
if (isset($_SESSION['users']) && isset($_SESSION['rounds'])) {
    $current_round = $_SESSION['current_round'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['roll_dice'])) {
        foreach ($_SESSION['users'] as &$user) {
            $dice_roll = rand(1, 6);
            $user['dice'][] = $dice_roll;
            $user['total_sum'] += $dice_roll;
        }

        $_SESSION['current_round']++;

        // Debug output
        debug_output($_SESSION);

        if ($_SESSION['current_round'] > $_SESSION['rounds']) {
            // All rounds completed, show results
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
    }
}

// Display results if all rounds are completed
if (isset($_SESSION['users']) && $_SESSION['current_round'] > $_SESSION['rounds']) {
    $users = $_SESSION['users'];
    usort($users, function($a, $b) {
        return $b['total_sum'] - $a['total_sum'];
    });

    $highestSum = $users[0]['total_sum'];
    $winners = array_filter($users, function($user) use ($highestSum) {
        return $user['total_sum'] == $highestSum;
    });

    session_destroy(); // Clear the session after determining the winner
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Dice Game Results</title>
        <link rel="stylesheet" href="style1.css" type="text/css" media="all">
        <link rel="shortcut icon" type="image/x-icon" href="slike/money.png">
        <script>
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 10000);
        </script>
    </head>
    <body>
        <div class="container">
            <div class="title">
                <h1>Final Results</h1>
            </div>
            <?php foreach ($users as $user): ?>
                <div class="user">
                    <h2><?php echo htmlspecialchars($user['name'] . ' ' . $user['surname']); ?></h2>
                    <p>Address: <?php echo htmlspecialchars($user['address']); ?></p>
                    <p>Total Dice Sum: <?php echo $user['total_sum']; ?></p>
                    <p>Rolls:</p>
                    <ul>
                        <?php foreach ($user['dice'] as $roll): ?>
                            <li>
                                <img src="slike/dice<?php echo $roll; ?>.png" alt="Dice <?php echo $roll; ?>">
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>

            <div class="clearfix"></div>

            <div class="title" id="winner">
                <h2>Winner<?php echo count($winners) > 1 ? 's' : ''; ?></h2>
                <?php foreach ($winners as $winner): ?>
                    <div class="Wizpis"><h3><p><?php echo htmlspecialchars($winner['name'] . ' ' . $winner['surname']); ?></p></h3></div>
                <?php endforeach; ?>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit();
}

// Display current round if the game is ongoing
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dice Game</title>
    <link rel="stylesheet" href="style1.css" type="text/css">
</head>
<body>
    <div class="container">
        <div class="title">
            <h1>Round <?php echo $_SESSION['current_round']; ?></h1>
        </div>
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['roll_dice'])): ?>
            <?php foreach ($_SESSION['users'] as $user): ?>
                <div class="user">
                    <h2><?php echo htmlspecialchars($user['name'] . ' ' . $user['surname']); ?></h2>
                    <p>Dice: <img src="slike/dice<?php echo end($user['dice']); ?>.png" alt="Dice <?php echo end($user['dice']); ?>"></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="button-container">
            <form method="post">
                <button type="submit" name="roll_dice">Roll Dice</button>
            </form>
        </div>
    </div>
</body>
</html>






