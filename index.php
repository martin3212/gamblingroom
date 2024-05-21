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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['users']) && isset($_POST['rounds'])) {
    $_SESSION['users'] = array_values($_POST['users']); // Ensure indexed array
    $_SESSION['rounds'] = (int)$_POST['rounds'];
    $_SESSION['current_round'] = 1;

    // Initialize dice rolls for each user
    foreach ($_SESSION['users'] as &$user) {
        $user['dice'] = [];
        $user['total_sum'] = 0;
    }

    // Debug output
    debug_output($_SESSION);

    // Redirect to game page to handle gameplay
    header('Location: game.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dice Game</title>
    <link rel="stylesheet" href="style.css" type="text/css" media="all">
    <link rel="shortcut icon" type="image/x-icon" href="slike/money.png">
</head>
<body>
<div class="obrazec">
    <div class="naslov"><div class="naslov1"><h1>Dice Roll</h1></div></div>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="oseba1">
            <label for="user1_name"><h5>User 1 Name:</h5></label>
            <input type="text" id="user1_name" name="users[0][name]" required><br>
            <label for="user1_surname"><h5>User 1 Surname:</h5></label>
            <input type="text" id="user1_surname" name="users[0][surname]" required><br>
            <label for="user1_address"><h5>User 1 Address:</h5></label>
            <input type="text" id="user1_address" name="users[0][address]" required>
        </div>
        <div class="oseba2">
            <label for="user2_name"><h5>User 2 Name:</h5></label>
            <input type="text" id="user2_name" name="users[1][name]" required><br>
            <label for="user2_surname"><h5>User 2 Surname:</h5></label>
            <input type="text" id="user2_surname" name="users[1][surname]" required><br>
            <label for="user2_address"><h5>User 2 Address:</h5></label>
            <input type="text" id="user2_address" name="users[1][address]" required>
        </div>
        <div class="oseba3">
            <label for="user3_name"><h5>User 3 Name:</h5></label>
            <input type="text" id="user3_name" name="users[2][name]" required><br>
            <label for="user3_surname"><h5>User 3 Surname:</h5></label>
            <input type="text" id="user3_surname" name="users[2][surname]" required><br>
            <label for="user3_address"><h5>User 3 Address:</h5></label>
            <input type="text" id="user3_address" name="users[2][address]" required>
        </div>
        <div class="rounds">
            <div class="Nrounds">
            <label for="rounds"><h5>Number of Rounds:</h5></label>
            <input type="number" id="rounds" name="rounds" min="1" required><br>
            </div>
        </div>
        <div class="button"><button id="play" type="submit">Play</button></div>
    </form>
    
    <div id="clear"></div>
</div>    
</body>
</html>


