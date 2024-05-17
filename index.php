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
    $_SESSION['users'] = $_POST['users'];
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
</head>
<body>
    <h1>Enter User Details and Number of Rounds</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div>
            <label for="user1_name">User 1 Name:</label>
            <input type="text" id="user1_name" name="users[0][name]" required>
            <label for="user1_surname">User 1 Surname:</label>
            <input type="text" id="user1_surname" name="users[0][surname]" required>
            <label for="user1_address">User 1 Address:</label>
            <input type="text" id="user1_address" name="users[0][address]" required>
        </div>
        <div>
            <label for="user2_name">User 2 Name:</label>
            <input type="text" id="user2_name" name="users[1][name]" required>
            <label for="user2_surname">User 2 Surname:</label>
            <input type="text" id="user2_surname" name="users[1][surname]" required>
            <label for="user2_address">User 2 Address:</label>
            <input type="text" id="user2_address" name="users[1][address]" required>
        </div>
        <div>
            <label for="user3_name">User 3 Name:</label>
            <input type="text" id="user3_name" name="users[2][name]" required>
            <label for="user3_surname">User 3 Surname:</label>
            <input type="text" id="user3_surname" name="users[2][surname]" required>
            <label for="user3_address">User 3 Address:</label>
            <input type="text" id="user3_address" name="users[2][address]" required>
        </div>
        <div>
            <label for="rounds">Number of Rounds:</label>
            <input type="number" id="rounds" name="rounds" min="1" required>
        </div>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
