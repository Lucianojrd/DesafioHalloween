<section id="login" class="section">
            <h2>Iniciar Sesión</h2>
            <form action="procesar_login.php" method="POST">
                <label for="login-username">Nombre de Usuario:</label>
                <input type="text" id="login-username" name="login-username" required>

                <label for="login-password">Contraseña:</label>
                <input type="password" id="login-password" name="login-password" required>

                <button type="submit">Iniciar Sesión</button>
            </form>
        </section>