const canvas = document.getElementById('signature-pad');
if (canvas) {
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

    canvas.addEventListener("mousedown", e => { drawing = true; ctx.beginPath(); ctx.moveTo(e.offsetX, e.offsetY); });
    canvas.addEventListener("mouseup", e => { drawing = false; });
    canvas.addEventListener("mousemove", e => { if (drawing) { ctx.lineTo(e.offsetX, e.offsetY); ctx.stroke(); } });

    canvas.addEventListener("touchstart", e => { e.preventDefault(); drawing = true; const t = e.touches[0]; ctx.beginPath(); ctx.moveTo(t.clientX - canvas.getBoundingClientRect().left, t.clientY - canvas.getBoundingClientRect().top); });
    canvas.addEventListener("touchmove", e => { e.preventDefault(); if (drawing) { const t = e.touches[0]; ctx.lineTo(t.clientX - canvas.getBoundingClientRect().left, t.clientY - canvas.getBoundingClientRect().top); ctx.stroke(); } });
    canvas.addEventListener("touchend", e => { drawing = false; });

    document.getElementById('clear-signature')?.addEventListener('click', () => { ctx.clearRect(0, 0, canvas.width, canvas.height); });
}
