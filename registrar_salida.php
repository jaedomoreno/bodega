<?php
session_start();
if (!isset($_SESSION['usuario'])) header("Location: login.php");
include 'conexion.php';
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/menu.php'; ?>

<div class="contenido">
    <h2>🚚 Registrar Salida de Productos</h2>

    <form action="guardar_salida.php" method="post" enctype="multipart/form-data" onsubmit="return enviarFirma()">
        <label>Código de boleta:</label>
        <input type="text" name="codigo_boleta" required>
        <label>Chofer:</label>
        <input type="text" name="chofer" required>

        <h3>Productos</h3>
        <button type="button" onclick="iniciarEscaneo()">📷 Escanear código</button>
        <video id="preview" style="width:100%; max-width:400px; display:none; border-radius:10px; margin-top:10px;"></video>

        <table id="productos">
            <tr>
                <td><input type="text" id="codigoInput" name="codigos[]" placeholder="Código de producto" required></td>
                <td><input type="text" name="descripciones[]" placeholder="Descripción" required></td>
            </tr>
        </table>
        <button type="button" onclick="agregarProducto()">Agregar producto</button>


        <h3>Firma del chofer</h3>
        <canvas id="signature-pad"></canvas>
        <input type="hidden" name="firma" id="firma">
        <button type="button" id="clear-signature">Limpiar firma</button>

        <button type="submit">Guardar salida</button>
    </form>
</div>

<script>
    // Agregar fila
    function agregarProducto() {
        const tabla = document.getElementById("productos");
        const row = tabla.insertRow();
        row.innerHTML = '<td><input type="text" name="codigos[]" placeholder="Código de producto" required></td>' +
            '<td><input type="text" name="descripciones[]" placeholder="Descripción" required></td>';
    }

    // Firma digital
    const canvas = document.getElementById('signature-pad');
    const ctx = canvas.getContext('2d');
    let drawing = false;

    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        ctx.scale(ratio, ratio);
        ctx.lineWidth = 2;
        ctx.lineCap = "round";
    }
    resizeCanvas();
    window.addEventListener("resize", resizeCanvas);

    canvas.addEventListener("mousedown", e => {
        drawing = true;
        ctx.beginPath();
        ctx.moveTo(e.offsetX, e.offsetY);
    });
    canvas.addEventListener("mouseup", e => {
        drawing = false;
    });
    canvas.addEventListener("mousemove", e => {
        if (drawing) {
            ctx.lineTo(e.offsetX, e.offsetY);
            ctx.stroke();
        }
    });

    canvas.addEventListener("touchstart", e => {
        e.preventDefault();
        drawing = true;
        const t = e.touches[0];
        ctx.beginPath();
        ctx.moveTo(t.clientX - canvas.getBoundingClientRect().left, t.clientY - canvas.getBoundingClientRect().top);
    });
    canvas.addEventListener("touchmove", e => {
        e.preventDefault();
        if (drawing) {
            const t = e.touches[0];
            ctx.lineTo(t.clientX - canvas.getBoundingClientRect().left, t.clientY - canvas.getBoundingClientRect().top);
            ctx.stroke();
        }
    });
    canvas.addEventListener("touchend", e => {
        drawing = false;
    });

    document.getElementById('clear-signature').addEventListener('click', () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    });

    // Enviar firma
    function enviarFirma() {
        document.getElementById('firma').value = canvas.toDataURL('image/png');
        return true;
    }
</script>

<!-- Librería ZXing -->
<script src="https://unpkg.com/@zxing/library@latest"></script>
<script>
    let selectedDeviceId = null;
    const codeReader = new ZXing.BrowserMultiFormatReader();
    const videoElement = document.getElementById('preview');

    async function iniciarEscaneo() {
        try {
            const devices = await codeReader.listVideoInputDevices();
            if (devices.length === 0) {
                alert("No se encontró cámara");
                return;
            }

            selectedDeviceId = devices[0].deviceId; // usa la cámara trasera si está disponible
            videoElement.style.display = "block";

            await codeReader.decodeFromVideoDevice(selectedDeviceId, videoElement, (result, err) => {
                if (result) {
                    document.getElementById('codigoInput').value = result.text;
                    detenerEscaneo();
                }
            });
        } catch (error) {
            console.error(error);
            alert("Error al iniciar la cámara");
        }
    }

    function detenerEscaneo() {
        codeReader.reset();
        videoElement.style.display = "none";
    }
</script>

</body>

</html>