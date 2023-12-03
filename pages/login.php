<?php
$conn = mysqli_connect("localhost", "root", "", "database");
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
if (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
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
echo "<input type='text' name='username' placeholder='Username'>";
echo "<input type='password' name='password' placeholder='Password'>";
echo "<input type='submit' value='Login'>";
echo "</form>";
?>