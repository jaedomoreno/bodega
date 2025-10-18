<nav class="menu">
    <div class="hamburger"></div>
    <div class="menu-items" id="menuItems">
        <p>👋 Bienvenido, <?= $_SESSION['usuario'] ?></p>
        <a href="index.php">Inicio 🏠</a>
        <a href="registrar_salida.php">Registrar salida 📤</a>
        <a href="gestionar_chofer.php">Gestionar Choferes 👨‍✈️</a>
        <a href="gestionar_producto.php">Gestionar productos 📦</a>
        <a href="listar_salidas.php">Historial 📄</a>
        <a href="logout.php">Cerrar sesión 🔒</a>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.querySelector('.hamburger');
    const menuItems = document.getElementById('menuItems');
    const contenido = document.querySelector('.contenido');

    function toggleMenu(e){
        e.preventDefault();
        menuItems.classList.toggle('active');
        document.body.classList.toggle('menu-abierto');

        if(menuItems.classList.contains('active')){
            const altura = menuItems.scrollHeight;
            // margen extra 30px
            contenido.style.marginTop = (altura + 30) + 'px';
        } else {
            contenido.style.marginTop = '';
        }
    }

    hamburger.addEventListener('click', toggleMenu);
    hamburger.addEventListener('touchstart', toggleMenu);
});
</script>
