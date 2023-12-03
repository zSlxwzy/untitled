<?php
session_start();
$conn = mysqli_connect("194.104.156.218", "u33231_gDm109Wjaw", "G4QJ5L.qEo+iN5jD@vwbyF@r", "s33231_clase");
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

if (isset($_POST["signup_username"]) && isset($_POST["signup_password"]) && isset($_POST["signup_repeat_password"])) {
    $username = $_POST["signup_username"];
    $password = $_POST["signup_password"];
    $repeatPassword = $_POST["signup_repeat_password"];

    if ($password !== $repeatPassword) {
        echo "Passwords do not match.";
    } else {
        $checkUsernameQuery = "SELECT * FROM users WHERE username='$username'";
        $checkUsernameResult = mysqli_query($conn, $checkUsernameQuery);
        if (mysqli_num_rows($checkUsernameResult) > 0) {
            echo "Username is not available.";
        } else {
            $insertQuery = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
            if (mysqli_query($conn, $insertQuery)) {
                echo "Sign up successful. You can now login.";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    }
}

echo "<h1>Login</h1>";
echo "<form action='login.php' method='post'>";
echo "<input type='text' name='login_username' placeholder='Username'>";
echo "<input type='password' name='login_password' placeholder='Password'>";
echo "<input type='submit' value='Login'>";
echo "</form>";

echo "<h1>Sign Up</h1>";
echo "<form action='login.php' method='post'>";
echo "<input type='text' name='signup_username' placeholder='Username'>";
echo "<input type='password' name='signup_password' placeholder='Password'>";
echo "<input type='password' name='signup_repeat_password' placeholder='Repeat password'>";
echo "<input type='submit' value='Sign Up'>";
echo "</form>";

mysqli_close($conn);
?>