document.addEventListener('DOMContentLoaded', function() {

    // --- SELECCIONAR ELEMENTOS DEL HTML ---
    const formulario = document.getElementById('formularioCompras');
    const tbody = document.getElementById('tablaCompraBody');
    // SELECCIÓN CLAVE: Asume que el TH tiene el ID 'totalCompras'
    const totalDisplay = document.getElementById('totalCompras'); 

    // --- SELECCIONAR ELEMENTOS DEL MODAL ---
    const modal = document.getElementById('modalOverlay'); // El fondo oscuro
    const btnAbrir = document.getElementById('btnAbrirFormulario'); // El botón para abrir
    const btnCerrar = document.getElementById('btnCerrarModal'); // La 'X' para cerrar

    // --- FUNCIÓN PARA CARGAR Y MOSTRAR LAS COMPRAS EN LA TABLA ---
    function cargarCompras() {
        let total_compras_acumulado = 0; // Se inicializa el acumulador
        
        fetch('tabla_compras_actualizar.php')
            .then(response => response.json())
            .then(data => {
                tbody.innerHTML = ''; 
                
                data.forEach(compras => {
                    
                    // CORRECCIÓN CLAVE: Convertir a número (parseFloat) y sumar
                    const totalCompra = parseFloat(compras.total);
                    
                    if (!isNaN(totalCompra)) {
                        total_compras_acumulado += totalCompra;
                    }
                    
                    // Renderizado de filas de datos
                    const row = `
                        <tr>
                            <td>${compras.id_compra}</td>
                            <td>${compras.id_articulo}</td>
                            <td>${compras.id_proveedor}</td>
                            <td>${compras.nombre_articulo}</td>
                            <td>${compras.cantidad}</td>
                            <td>$${compras.precio_unitario}</td>
                            <td>$${compras.total}</td>
                            <td>${compras.fecha_compra}</td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });
                
                // 3. ACTUALIZACIÓN FINAL EN EL TH (elementos)
                if (totalDisplay) {
                    // Usamos toFixed(2) para el formato básico de moneda.
                    totalDisplay.innerHTML = `$${total_compras_acumulado.toFixed(2)}`;
                }
            })
            .catch(error => {
                alert('Error: No se pudieron cargar los datos de las compras.');
                console.error('Error en fetch al cargar compra:', error);
            });
    }

    // --- LÓGICA PARA REGISTRAR UNA NUEVA VENTA ---
    formulario.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const formData = new FormData(formulario);

        fetch('compras_registro.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data);

            if (data.includes("correctamente")) {
                formulario.reset();
                cargarCompras(); // Llama a cargarCompras para refrescar la tabla Y el total
            }
        })
        .catch(error => {
            alert("Hubo un error al conectar con el servidor para registrar la venta.");
            console.error('Error en fetch al registrar venta:', error);
        });
    });

    // --- LÓGICA PARA ABRIR Y CERRAR EL MODAL ---

    // Evento para ABRIR
    if (btnAbrir) {
        btnAbrir.addEventListener('click', () => {
            if (modal) {
                modal.style.display = 'flex';
            }
        });
    }

    // Evento para CERRAR (con la 'X')
    if (btnCerrar) {
        btnCerrar.addEventListener('click', () => {
            if (modal) {
                modal.style.display = 'none';
            }
        });
    }

    // Evento para CERRAR (clic afuera)
    if (modal) {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) { // Si se hizo clic en el fondo (overlay)
                modal.style.display = 'none'; 
            }
        });
    }

    // --- CARGA INICIAL DE DATOS ---
    cargarCompras();
});