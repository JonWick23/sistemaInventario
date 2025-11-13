// Archivo: ven.js (COMPLETO)

document.addEventListener('DOMContentLoaded', function() {

    // --- SELECCIONAR ELEMENTOS DEL HTML ---
    const formulario = document.getElementById('formularioVenta');
    const tbody = document.getElementById('tablaVentasBody');
    const totalDisplay = document.getElementById('totalVentas'); 
    const modal = document.getElementById('modalOverlay');
    const btnAbrir = document.getElementById('btnAbrirFormulario');
    const btnCerrar = document.getElementById('btnCerrarModal');

    // (NUEVO) Seleccionar los dropdowns del formulario
    const selectCliente = document.getElementById('nombre_cliente');
    const selectArticulo = document.getElementById('nom_articulo');
    // (NUEVO) Seleccionar campos que se autocompletarán
    const inputPrecioUnitario = document.getElementById('pre_unitario');

    let datosVentas = []; 

    // --- FUNCIÓN PARA CARGAR Y MOSTRAR LAS VENTAS EN LA TABLA ---
    function cargarVentas() {
        let total_ventas_acumulado = 0;
        
        fetch('tabla_actualizar.php') 
            .then(response => response.json())
            .then(data => {
                tbody.innerHTML = ''; 
                datosVentas = data; 
                
                data.forEach(venta => {
                    const totalVenta = parseFloat(venta.total);
                    
                    if (!isNaN(totalVenta)) {
                        total_ventas_acumulado += totalVenta;
                    }

                    // (CORREGIDO) Columnas para coincidir con tu <thead> de Ventas
                    const row = `
                        <tr>
                            <td>${venta.id_ventas}</td>
                            <td>${venta.id_cliente}</td>
                            <td>${venta.nombre_cliente}</td>
                            <td>$${parseFloat(venta.subtotal).toFixed(2)}</td>
                            <td>$${parseFloat(venta.iva).toFixed(2)}</td>
                            <td>$${parseFloat(venta.total).toFixed(2)}</td>
                            <td>${venta.fecha_venta}</td>
                            <td class="celda-acciones">
                                <button class="btn-modificar" data-id="${venta.id_ventas}"><i class="fas fa-pen"></i></button>
                                <button class="btn-eliminar" data-id="${venta.id_ventas}"><i class="fas fa-trash-alt"></i></button>
                                <button class="btn-pdf" data-id="${venta.id_ventas}"><i class="fas fa-file-pdf"></i></button>
                            </td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });
                
                if (totalDisplay) {
                    totalDisplay.innerHTML = `$${total_ventas_acumulado.toFixed(2)}`;
                }
            })
            .catch(error => {
                console.error('Error en fetch al cargar ventas:', error);
            });
    }

    // --- (NUEVO) FUNCIONES PARA LLENAR DROPDOWNS ---
    function cargarClientesDropdown() {
        fetch('cargar_clientes.php') // (Debes crear este archivo PHP)
            .then(response => response.json())
            .then(data => {
                selectCliente.innerHTML = '<option value="">Seleccione un cliente...</option>';
                data.forEach(cliente => {
                    const option = document.createElement('option');
                    option.value = cliente.nombre; // El formulario envía el NOMBRE
                    option.textContent = cliente.nombre;
                    selectCliente.appendChild(option);
                });
            })
            .catch(error => console.error('Error al cargar clientes:', error));
    }

    function cargarArticulosDropdown() {
        fetch('cargar_articulos.php') // (Debes crear este archivo PHP)
            .then(response => response.json())
            .then(data => {
                selectArticulo.innerHTML = '<option value="">Seleccione un artículo...</option>';
                data.forEach(articulo => {
                    const option = document.createElement('option');
                    option.value = articulo.nombre; // El formulario envía el NOMBRE
                    option.textContent = articulo.nombre;
                    option.dataset.precio = articulo.precio_venta; // Guardamos el precio
                    selectArticulo.appendChild(option);
                });
            })
            .catch(error => console.error('Error al cargar artículos:', error));
    }

    // --- (NUEVO) LÓGICA DE AUTOCOMPLETAR PRECIO ---
    if (selectArticulo) {
        selectArticulo.addEventListener('change', function() {
            const precio = this.options[this.selectedIndex].dataset.precio;
            inputPrecioUnitario.value = precio || '';
        });
    }

    // --- LÓGICA PARA REGISTRAR O ACTUALIZAR (Formulario) ---
    if (formulario) {
        formulario.addEventListener('submit', function(event) {
            event.preventDefault();
            
            const actionUrl = formulario.getAttribute('action');
            const formData = new FormData(formulario);

            if (document.getElementById('id_venta_hidden')) {
                formData.append('id_venta', document.getElementById('id_venta_hidden').value);
            }

            fetch(actionUrl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data); 

                if (data.includes("correctamente")) {
                    formulario.reset();
                    cargarVentas(); 
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
            formulario.reset();
            const idVentaInput = document.getElementById('id_venta_hidden');
            if (idVentaInput) idVentaInput.remove();
            
            formulario.setAttribute('action', 'ventas_registro.php');
            if (modal) {
                modal.style.display = 'flex';
            }
        });
    }

    if (modal) {
        modal.addEventListener('click', (e) => {
            const clicEnFondo = (e.target === modal);
            const clicEnCerrar = e.target.closest('.cerrar-modal');
            if (clicEnFondo || clicEnCerrar) {
                modal.style.display = 'none';
            }
        });
    }

    // --- LÓGICA PARA CLICS EN LA TABLA (EDITAR/ELIMINAR/PDF) ---
    tbody.addEventListener('click', function(event) {
        
        // Lógica para EDITAR
        const btnEditar = event.target.closest('.btn-modificar');
        if (btnEditar) {
            const id = btnEditar.getAttribute('data-id');
            const ventaParaEditar = datosVentas.find(v => v.id_ventas == id);

            if (ventaParaEditar) {
                formulario.reset();
                formulario.setAttribute('action', 'modificar_ventas.php'); // (Debes crear este PHP)

                // (Añadimos un campo oculto para enviar el ID de la VENTA)
                const idInput = document.createElement('input');
                idInput.type = 'hidden';
                idInput.id = 'id_venta_hidden';
                idInput.name = 'id_venta';
                idInput.value = ventaParaEditar.id_ventas;
                formulario.appendChild(idInput);
                
                // Rellenar los campos que sí existen en el modal
                selectCliente.value = ventaParaEditar.nombre_cliente;
                // (Nota: Faltan los campos de cantidad, iva y fecha_venta en la tabla)
                
                modal.style.display = 'flex';
            }
        }

        // Lógica para ELIMINAR
        const btnEliminar = event.target.closest('.btn-eliminar');
        if (btnEliminar) {
            if (!confirm('¿Estás seguro de que deseas eliminar esta venta?')) return;
            
            const idParaEliminar = btnEliminar.getAttribute('data-id');
            const formData = new FormData();
            formData.append('id_venta', idParaEliminar);

            fetch('ventas_bajas.php', { // (Debes crear este PHP)
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data); 
                cargarVentas(); 
            })
            .catch(error => {
                alert('Error al conectar con el servidor.');
                console.error('Error en fetch al eliminar:', error);
            });
        }
        
        // Lógica para PDF
        const btnPDF = event.target.closest('.btn-pdf');
        if (btnPDF) {
            const id = btnPDF.getAttribute('data-id');
            window.open(`generar_ticket_venta.php?id=${id}`, '_blank'); // (Debes crear este PHP)
        }
    });

    // --- CARGA INICIAL DE DATOS ---
    cargarVentas();
    cargarClientesDropdown();
    cargarArticulosDropdown();
});