<?php
session_start();
$conn = mysqli_connect("194.104.156.218:3306", "u33231_gDm109Wjaw", "G4QJ5L.qEo+iN5jD@vwbyF@r", "s33231_clase");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
    header("Location: login.php");
    exit;
}

$checker = new \misc\PasswordChecker();
if(!$checker->check($_POST["password"])) {
    echo "Funca";
} else {
    echo "nofunca";
}

if (isset($_POST["login_username"]) && isset($_POST["login_password"])) {
    $username = $_POST["login_username"];
    $password = $_POST["login_password"];
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        $_SESSION["logged_in"] = true;
        $_SESSION["username"] = $username;
        header("Location: home.html");
        exit;
    }
}

echo "<h1>Login</h1>";
echo "<form action='login.php' method='post'>";
echo "<input type='text' name='login_username' placeholder='Username'>";
echo "<input type='password' name='login_password' placeholder='Password'>";
echo "<input type='submit' value='Login'>";
echo "</form>";


mysqli_close($conn);
?>