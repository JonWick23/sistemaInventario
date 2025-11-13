// Archivo: ven.js (COMPLETO Y CORREGIDO)

document.addEventListener('DOMContentLoaded', function() {

    // --- SELECCIONAR ELEMENTOS DEL HTML ---
    const formulario = document.getElementById('formularioVenta');
    const tbody = document.getElementById('tablaVentasBody');
    const totalDisplay = document.getElementById('totalVentas'); 
    const modal = document.getElementById('modalOverlay');
    const btnAbrir = document.getElementById('btnAbrirFormulario');
    const btnCerrar = document.getElementById('btnCerrarModal');

    // --- SELECCIONAR ELEMENTOS DEL MODAL ---
    const selectCliente = document.getElementById('nombre_cliente');
    const selectArticulo = document.getElementById('nom_articulo');
    const inputPrecioUnitario = document.getElementById('pre_unitario');
    const inputCantidad = document.getElementById('cantidad');
    const btnAnadirProducto = document.getElementById('btnAnadirProducto');
    const carritoBody = document.getElementById('carritoBody'); // La "mini-tabla"

    // --- VARIABLES GLOBALES ---
    let carrito = []; // Carrito temporal
    let datosVentas = []; // Para la lógica de Editar/Eliminar

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

                    // (Columnas corregidas para tu <thead>)
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

    // --- FUNCIONES PARA LLENAR DROPDOWNS ---
    function cargarClientesDropdown() {
        fetch('cargar_clientes.php') 
            .then(response => response.json())
            .then(data => {
                if (data.error) return;
                selectCliente.innerHTML = '<option value="">1</option>';
                data.forEach(cliente => {
                    const option = document.createElement('option');
                    option.value = cliente.nombre; 
                    option.textContent = cliente.nombre;
                    selectCliente.appendChild(option);
                });
            })
            .catch(error => console.error('Error al cargar clientes:', error));
    }

    function cargarArticulosDropdown() {
        fetch('cargar_articulos.php') 
            .then(response => response.json())
            .then(data => {
                if (data.error) return;
                selectArticulo.innerHTML = '<option value="">2</option>';
                data.forEach(articulo => {
                    const option = document.createElement('option');
                    option.value = articulo.nombre; 
                    option.textContent = `${articulo.id_productos} - ${articulo.nombre}`;
                    option.dataset.precio = articulo.precio_venta; 
                    option.dataset.id = articulo.id_productos; 
                    selectArticulo.appendChild(option);
                });
            })
            .catch(error => console.error('Error al cargar artículos:', error));
    }

    // --- LÓGICA DE AUTOCOMPLETAR PRECIO ---
    if (selectArticulo) {
        selectArticulo.addEventListener('change', function() {
            const precio = this.options[this.selectedIndex].dataset.precio;
            inputPrecioUnitario.value = precio || '';
        });
    }

    // --- LÓGICA DEL CARRITO (MINI-TABLA) ---
    function actualizarCarritoTabla() {
        carritoBody.innerHTML = ''; 
        
        if (carrito.length === 0) {
            carritoBody.innerHTML = '<tr><td colspan="5">Añada productos a la venta...</td></tr>';
            return;
        }

        carrito.forEach((producto, index) => {
            const subtotal = producto.precio * producto.cantidad;
            const row = `
                <tr>
                    <td>${producto.nombre}</td>
                    <td>${producto.cantidad}</td>
                    <td>$${producto.precio.toFixed(2)}</td>
                    <td>$${subtotal.toFixed(2)}</td>
                    <td>
                        <button type="button" class="btn-quitar" data-index="${index}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>
            `;
            carritoBody.innerHTML += row;
        });
    }

    // (CORREGIDO) Evento para "AÑADIR PRODUCTO" (Evita duplicados)
    if (btnAnadirProducto) {
        btnAnadirProducto.addEventListener('click', function() {
            const selectedOption = selectArticulo.options[selectArticulo.selectedIndex];
            const id = selectedOption.dataset.id;
            const nombre = selectedOption.text.split(' - ')[1] || selectedOption.text;
            const precio = selectedOption.dataset.precio;
            const cantidad = parseInt(inputCantidad.value, 10);

            if (!id || id === "") {
                alert("Por favor, seleccione un artículo.");
                return;
            }
            if (isNaN(cantidad) || cantidad <= 0) {
                alert("Por favor, ingrese una cantidad válida.");
                return;
            }

            // CORRECCIÓN: Verifica si el producto ya está en el carrito
            const productoExistente = carrito.find(p => p.id_articulo === id);

            if (productoExistente) {
                // Si existe, suma la cantidad
                productoExistente.cantidad += cantidad;
            } else {
                // Si no existe, lo añade
                carrito.push({
                    id_articulo: id,
                    nombre: nombre,
                    cantidad: cantidad,
                    precio: parseFloat(precio)
                });
            }

            actualizarCarritoTabla();
            selectArticulo.selectedIndex = 0;
            inputCantidad.value = 1;
            inputPrecioUnitario.value = ''; // Limpia el precio
        });
    }

    if (carritoBody) {
        carritoBody.addEventListener('click', function(e) {
            const btnQuitar = e.target.closest('.btn-quitar');
            if (btnQuitar) {
                const index = btnQuitar.dataset.index;
                carrito.splice(index, 1); 
                actualizarCarritoTabla(); 
            }
        });
    }

    // --- LÓGICA PARA REGISTRAR LA VENTA COMPLETA (Envía JSON) ---
    if (formulario) {
        formulario.addEventListener('submit', function(event) {
            event.preventDefault();
            
            if (carrito.length === 0) {
                alert("Debe añadir al menos un producto a la venta.");
                return;
            }

            const datosVenta = {
                nombre_cliente: selectCliente.value,
                fecha_venta: document.getElementById('fecha_venta').value,
                iva: document.getElementById('iva').value,
                productos: carrito 
            };

            fetch('ventas_registro.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(datosVenta)
            })
            .then(response => response.text())
            .then(data => {
                alert(data); 

                if (data.includes("correctamente")) {
                    formulario.reset();
                    carrito = []; 
                    actualizarCarritoTabla(); 
                    cargarVentas(); 
                    if (modal) {
                        modal.style.display = 'none';
                    }
                }
            })
            .catch(error => {
                alert("Hubo un error al conectar con el servidor.");
                console.error('Error en fetch al registrar:', error);
            });
        });
    }

    // --- LÓGICA PARA ABRIR Y CERRAR EL MODAL ---
    if (btnAbrir) {
        btnAbrir.addEventListener('click', () => {
            formulario.reset();
            carrito = []; 
            actualizarCarritoTabla(); 
            
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

    // --- LÓGICA PARA CLICS EN LA TABLA PRINCIPAL (EDITAR/ELIMINAR/PDF) ---
    tbody.addEventListener('click', function(event) {
        
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
        
        // (Nota: La lógica de 'Modificar' es compleja y se omite 
        // hasta que el registro Maestro-Detalle esté estable)
    });

    // --- CARGA INICIAL DE DATOS ---
    cargarVentas();
    cargarClientesDropdown();
    cargarArticulosDropdown();
});