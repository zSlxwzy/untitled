<?php
// Verificar si se ha enviado el formulario de login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login-submit'])) {
    // Conectar a la base de datos MySQL
    $conn = mysqli_connect('localhost', 'usuario', 'contraseña', 'nombre_bd');

    // Verificar si la conexión fue exitosa
    if (!$conn) {
        die('Error al conectar a la base de datos: ' . mysqli_connect_error());
    }

    // Obtener los valores del formulario de login
    $email = $_POST['login-email'];
    $password = $_POST['login-password'];

    // Consulta SQL para verificar las credenciales de login
    $sql = "SELECT * FROM usuarios WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    // Verificar si se encontró un usuario con las credenciales proporcionadas
    if (mysqli_num_rows($result) == 1) {
        // Usuario autenticado, redirigir a la página de inicio
        header('Location: home.html');
        exit();
    } else {
        // Credenciales inválidas, mostrar mensaje de error
        $loginError = "Credenciales inválidas. Por favor, inténtalo de nuevo.";
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
}

// Verificar si se ha enviado el formulario de sign up
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup-submit'])) {
    // Conectar a la base de datos MySQL
    $conn = mysqli_connect('localhost', 'usuario', 'contraseña', 'nombre_bd');

    // Verificar si la conexión fue exitosa
    if (!$conn) {
        die('Error al conectar a la base de datos: ' . mysqli_connect_error());
    }

    // Obtener los valores del formulario de sign up
    $email = $_POST['signup-email'];
    $password = $_POST['signup-password'];
    $confirmPassword = $_POST['signup-password-confirm'];

    // Verificar si las contraseñas coinciden
    if ($password !== $confirmPassword) {
        $signupError = "Las contraseñas no coinciden. Por favor, inténtalo de nuevo.";
    } else {
        // Consulta SQL para insertar el nuevo usuario en la base de datos
        $sql = "INSERT INTO usuarios (email, password) VALUES ('$email', '$password')";
        $result = mysqli_query($conn, $sql);

        // Verificar si la inserción fue exitosa
        if ($result) {
            header('Location: home.html');
            exit();
        } else {
            // Error al registrar el usuario, mostrar mensaje de error
            $signupError = "Error al registrar el usuario. Por favor, inténtalo de nuevo.";
        }
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="eng">
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="style/login.css">
</head>
<body>
<section class="forms-section">
    <h1 class="section-title"></h1>
    <div class="forms">
        <div class="form-wrapper is-active">
            <button type="button" class="switcher switcher-login">
                Login
                <span class="underline"></span>
            </button>
            <form class="form form-login" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <fieldset>
                    <legend>Please, enter your email and password for login.</legend>
                    <div class="input-block">
                        <label for="login-email">E-mail</label>
                        <input id="login-email" type="email" name="login-email" required>
                    </div>
                    <div class="input-block">
                        <label for="login-password">Password</label>
                        <input id="login-password" type="password" name="login-password" required>
                    </div>
                </fieldset>
                <button type="submit" name="login-submit" class="btn-login">Login</button>
                <?php if (isset($loginError)) { ?>
                    <p><?php echo $loginError; ?></p>
                <?php } ?>
            </form>
        </div>
        <div class="form-wrapper">
            <button type="button" class="switcher switcher-signup">
                Sign Up
                <span class="underline"></span>
            </button>
            <form class="form form-signup" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <fieldset>
                    <legend>Please, enter your email, password and password confirmation for sign up.</legend>
                    <div class="input-block">
                        <label for="signup-email">E-mail</label>
                        <input id="signup-email" type="email" name="signup-email" required>
                    </div>
                    <div class="input-block">
                        <label for="signup-password">Password</label>
                        <input id="signup-password" type="password" name="signup-password" required>
                    </div>
                    <div class="input-block">
                        <label for="signup-password-confirm">Confirm password</label>
                        <input id="signup-password-confirm" type="password" name="signup-password-confirm" required>
                    </div>
                </fieldset>
                <button type="submit" name="signup-submit" class="btn-signup">Continue</button>
                <?php if (isset($signupError)) { ?>
                    <p><?php echo $signupError; ?></p>
                <?php } ?>
            </form>
        </div>
    </div>
</section>
<script>
    const switchers = [...document.querySelectorAll('.switcher')]
    switchers.forEach(item => {
        item.addEventListener('click', function() {
            switchers.forEach(item => item.parentElement.classList.remove('is-active'))
            this.parentElement.classList.add('is-active')
        })
    })
</script>
</body>
</html>
