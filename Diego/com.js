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

    let datosCompras = []; 

    // --- FUNCIÓN PARA CARGAR Y MOSTRAR LAS COMPRAS EN LA TABLA ---
    function cargarCompras() {
        let total_compras_acumulado = 0; // Se inicializa el acumulador
        
        fetch('tabla_compras_actualizar.php')
            .then(response => response.json())
            .then(data => {
                tbody.innerHTML = ''; 

                datosCompras = data; 
                
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
                            <td class="botones_m_e">
                            <button class="btn-modificar" data-id="${compras.id_compra}"><i class="fas fa-pen"></i> Modificar</button>
                            <button class="btn-eliminar" data-id="${compras.id_compra}"><i class="fas fa-trash-alt"></i> Eliminar</button>
                            </td>
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


    // --- LÓGICA PARA REGISTRAR O ACTUALIZAR (Formulario) ---

    if (formulario) {
        formulario.addEventListener('submit', function(event) {
            event.preventDefault();
            
            // (NUEVO) Obtiene la URL de acción (registro o actualización)
            const actionUrl = formulario.getAttribute('action');
            const formData = new FormData(formulario);

            // (NUEVO) Si el campo id_venta está deshabilitado (modo Editar), 
            // lo añadimos manualmente al formData porque los campos 'disabled' no se envían.
            if (document.getElementById('id_compra').readOnly) {
                formData.append('id_compra', document.getElementById('id_compra').value);
            }

            fetch(actionUrl, { // Envía al 'action' que hayamos puesto
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data); 

                if (data.includes("correctamente")) {
                    formulario.reset();
                    cargarCompras(); 
                    if (modal) {
                        modal.style.display = 'none';
                    }
                }
            })
            .catch(error => {
                alert("Hubo un error al conectar con el servidor.");
                console.error('Error en fetch al registrar/actualizar:', error);
            });
        });
    }


    // --- LÓGICA PARA ABRIR Y CERRAR EL MODAL ---

    if (btnAbrir) {
    btnAbrir.addEventListener('click', () => {
        // Asegura que el formulario esté en modo "Registro"
        formulario.reset();
        document.getElementById('id_compra').readOnly = false;
        formulario.setAttribute('action', 'compras_registro.php');
        
        if (modal) {
            modal.style.display = 'flex';
        }
    });
}

// 2. Evento para CERRAR (Maneja la 'X' Y el clic de fondo)
if (modal) {
    modal.addEventListener('click', (e) => {
        
        // Causa 1: Se hizo clic en el fondo (e.target es el div .modal-overlay)
        const clicEnFondo = (e.target === modal);

        // Causa 2: Se hizo clic en la 'X' (e.target es el span .cerrar-modal)
        const clicEnCerrar = e.target.closest('.cerrar-modal');

        if (clicEnFondo || clicEnCerrar) {
            modal.style.display = 'none';
        }
    });
}


    // --- LÓGICA PARA EDITAR O ELIMINAR (Clic en la Tabla) ---
    tbody.addEventListener('click', function(event) {
    
        // 1. Lógica para EDITAR
        const btnEditar = event.target.closest('.btn-modificar');
        if (btnEditar) {
            const id = btnEditar.getAttribute('data-id');
            
            // CORRECCIÓN 1: La variable debe llamarse 'compraParaEditar'
            const compraParaEditar = datosCompras.find(v => v.id_compra == id);

            // CORRECCIÓN 2: Usar la variable correcta 'compraParaEditar'
            if (compraParaEditar) { 
                // (IMPORTANTE) Pone el 'action' para ACTUALIZAR
                formulario.setAttribute('action', 'modificar_compras.php'); 

                // Rellenar el formulario
                document.getElementById('id_compra').value = compraParaEditar.id_compra;
                document.getElementById('id_compra').readOnly = true; 
                
                document.getElementById('id_articulo').value = compraParaEditar.id_articulo;
                document.getElementById('id_proveedor').value = compraParaEditar.id_proveedor;
                
                // CORRECCIÓN 3: El ID del input es 'nom_articulo'
                document.getElementById('nom_articulo').value = compraParaEditar.nombre_articulo; 
                
                document.getElementById('cantidad').value = compraParaEditar.cantidad;
                document.getElementById('pre_unitario').value = compraParaEditar.precio_unitario;
                document.getElementById('total').value = compraParaEditar.total;
                document.getElementById('fecha_compra').value = compraParaEditar.fecha_compra;

                modal.style.display = 'flex';
            }
        }

        // 2. Lógica para ELIMINAR (Tu código existente se ve bien)
        const btnEliminar = event.target.closest('.btn-eliminar');
        if (btnEliminar) {
            if (!confirm('¿Estás seguro de que deseas eliminar esta compra?')) {
                return; 
            }
            
            const idParaEliminar = btnEliminar.getAttribute('data-id');
            const formData = new FormData();
            formData.append('id_compra', idParaEliminar); // Asegúrate que el PHP de bajas espere 'id_compra'

            fetch('compras_bajas.php', { 
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data); 
                cargarCompras(); 
            })
            .catch(error => {
                alert('Error al conectar con el servidor.');
                console.error('Error en fetch al eliminar:', error);
            });
        }
    });

    


    // --- CARGA INICIAL DE DATOS ---
    cargarCompras();
});