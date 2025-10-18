<?php
if (isset($_GET['error'])) {
    $error = "Usuario o contraseña incorrecta";
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- optimizado para móviles -->
    <title>Login - SubiTodo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #4a90e2, #50e3c2);
        }

        /* Contenedor centrado estilo app */
        .login-container {
            background: #fff;
            padding: 40px 25px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
            width: 90%;
            max-width: 400px;
            text-align: center;
            animation: fadeIn 0.8s ease-in-out;
        }

        /* Título grande */
        .login-container h1 {
            margin-bottom: 30px;
            color: #333;
            font-size: 30px;
            font-weight: 600;
        }

        /* Inputs grandes y con iconos */
        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group input {
            width: 100%;
            padding: 15px 45px 15px 20px;
            border: 1px solid #ccc;
            border-radius: 15px;
            font-size: 16px;
            transition: 0.3s;
        }

        .input-group input:focus {
            border-color: #4a90e2;
            outline: none;
        }

        .input-group i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 18px;
        }

        /* Botón grande para tocar fácilmente en móvil */
        .login-container button {
            width: 100%;
            padding: 16px;
            background: #4a90e2;
            border: none;
            color: white;
            font-size: 18px;
            border-radius: 15px;
            cursor: pointer;
            transition: 0.3s;
            font-weight: 600;
        }

        .login-container button:hover {
            background: #357ab7;
        }

        /* Mensaje de error */
        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        /* Animación de entrada */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Ajustes para móviles muy pequeños */
        @media (max-width: 360px) {
            .login-container {
                padding: 30px 20px;
                border-radius: 15px;
            }

            .input-group input {
                padding: 14px 40px 14px 15px;
                font-size: 15px;
            }

            .login-container button {
                padding: 14px;
                font-size: 16px;
            }
        }
    </style>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>

    <div class="login-container">
        <h1>Iniciar Sesión</h1>
        <?php if (isset($error)): ?>
            <div class="error-message"><?= $error ?></div>
        <?php endif; ?>
        <form action="verificar_login.php" method="post">
            <div class="input-group">
                <input type="text" name="nombre" placeholder="Usuario" required>
                <i class="fas fa-user"></i>
            </div>
            <div class="input-group">
                <input type="password" name="clave" placeholder="Contraseña" required>
                <i class="fas fa-lock"></i>
            </div>
            <button type="submit">Ingresar</button>
        </form>
    </div>

</body>

</html>