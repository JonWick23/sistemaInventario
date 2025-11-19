const modal = document.getElementById('modalOverlay');
        const btnAbrir = document.getElementById('btnAbrirFormulario');
        const btnCerrar = document.getElementById('btnCerrarModal');

        btnAbrir.addEventListener('click', () => modal.style.display = 'flex');
        btnCerrar.addEventListener('click', () => modal.style.display = 'none');
        window.addEventListener('click', e => { if (e.target === modal) modal.style.display = 'none'; });