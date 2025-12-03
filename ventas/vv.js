document.addEventListener('DOMContentLoaded', function() {
    const formulario = document.getElementById('formularioVenta');
    const modal = document.getElementById('modalOverlay');
    const btnAbrir = document.getElementById('btnAbrirFormulario');
    const tbody = document.getElementById('tablaVentasBody');

    const selectCliente = document.getElementById('nombre_cliente');
    const selectArticulo = document.getElementById('nom_articulo');
    const inputPrecioUnitario = document.getElementById('pre_unitario');
    const inputCantidad = document.getElementById('cantidad');
    const btnAnadirProducto = document.getElementById('btnAnadirProducto');
    const carritoBody = document.getElementById('carritoBody'); 

    let carrito = []; 
    let idVentaEdicion = null; 

    function cargarListas() {
        // CARGAR CLIENTES
        fetch('cargar_clientes.php')
            .then(r => r.json())
            .then(data => {
                if(selectCliente && !data.error) {
                    selectCliente.innerHTML = '<option value="">Seleccione Cliente</option>';
                    data.forEach(c => {
                        const op = document.createElement('option');
                        op.value = c.nombre; op.textContent = c.nombre;
                        selectCliente.appendChild(op);
                    });
                }
            })
            .catch(e => console.error("Falta archivo cargar_clientes.php"));

        // CARGAR ARTICULOS
        fetch('cargar_articulos.php')
            .then(r => r.json())
            .then(data => {
                if(selectArticulo && !data.error) {
                    selectArticulo.innerHTML = '<option value="">Seleccione Artículo</option>';
                    data.forEach(a => {
                        const op = document.createElement('option');
                        op.value = a.nombre; 
                        op.textContent = `${a.id_productos} - ${a.nombre}`;
                        // Guardamos datos clave en el HTML
                        op.dataset.precio = a.precio_venta; 
                        op.dataset.id = a.id_productos;
                        selectArticulo.appendChild(op);
                    });
                }
            })
            .catch(e => console.error("Falta archivo cargar_articulos.php"));
    }

    cargarListas();

    if (selectArticulo) {
        selectArticulo.addEventListener('change', function() {
            const precio = this.options[this.selectedIndex].dataset.precio;
            if(inputPrecioUnitario) inputPrecioUnitario.value = precio || 0;
        });
    }

    // BOTÓN AÑADIR
    if (btnAnadirProducto) {
        btnAnadirProducto.addEventListener('click', function() {
            const selectedOption = selectArticulo.options[selectArticulo.selectedIndex];

            if (!selectedOption || selectArticulo.value === "") { 
                alert("Seleccione un artículo válido."); return; 
            }

            const id = selectedOption.dataset.id;
            const nombre = selectedOption.text.split(' - ')[1] || selectedOption.text;
            const precio = parseFloat(inputPrecioUnitario.value) || 0;
            const cantidad = parseInt(inputCantidad.value);

            if (isNaN(cantidad) || cantidad <= 0) { 
                alert("Ingrese una cantidad válida."); return; 
            }

            // EXISTE O NO
            const indice = carrito.findIndex(p => String(p.id_articulo) === String(id));

            if (indice !== -1) {
                let cantActual = parseInt(carrito[indice].cantidad);
                carrito[indice].cantidad = cantActual + cantidad;
            } else {
                carrito.push({
                    id_articulo: id,
                    nombre: nombre,
                    cantidad: cantidad,
                    precio: precio
                });
            }
            actualizarCarritoTabla(); 

            selectArticulo.selectedIndex = 0;
            inputCantidad.value = 1;
            inputPrecioUnitario.value = ''; 
        });
    }

    function actualizarCarritoTabla() {
        if(!carritoBody) return;
        carritoBody.innerHTML = ''; 
        
        if (carrito.length === 0) {
            carritoBody.innerHTML = '<tr><td colspan="5" style="text-align:center;">Carrito vacío</td></tr>';
            return;
        }

        carrito.forEach((p, i) => {
            const subtotal = p.precio * p.cantidad;
            carritoBody.innerHTML += `
                <tr>
                    <td>${p.nombre}</td>
                    <td>${p.cantidad}</td>
                    <td>$${p.precio.toFixed(2)}</td>
                    <td>$${subtotal.toFixed(2)}</td>
                    <td>
                        <button type="button" class="btn-quitar" data-index="${i}" style="background:red; color:white; border:none; cursor:pointer; border-radius:3px;">X</button>
                    </td>
                </tr>
            `;
        });
    }

    // ELIMINAR COSAS DEL CARRO
    if (carritoBody) {
        carritoBody.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-quitar')) {
                carrito.splice(e.target.dataset.index, 1); 
                actualizarCarritoTabla(); 
            }
        });
    }

    if (formulario) {
        formulario.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (carrito.length === 0) { alert("El carrito está vacío."); return; }

            const datos = {
                nombre_cliente: selectCliente.value,
                fecha_venta: document.getElementById('fecha_venta').value,
                iva: document.getElementById('iva').value,
                productos: carrito,
                id_venta: idVentaEdicion 
            };

            let url = (idVentaEdicion !== null) ? 'modificar.php' : 'ventas_registro.php';

            fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(datos)
            })
            .then(r => r.text())
            .then(res => {
                alert(res.includes("correctamente") || res.includes("success") ? "Operación Exitosa" : res);
                window.location.reload(); 
            })
            .catch(error => { console.error(error); alert("Error de conexión"); });
        });
    }

    //BOTONOES DE ACTUALIZAR, ELIMINAR O PDF
    if(tbody) {
        tbody.addEventListener('click', function(e) {
            const btnDel = e.target.closest('.btn-eliminar');
            const btnEdit = e.target.closest('.btn-modificar');
            const btnPdf = e.target.closest('.btn-pdf');

            // ELIMINAR
            if (btnDel) {
                if (!confirm('¿Eliminar venta?')) return;
                const fd = new FormData();
                fd.append('id_venta', btnDel.dataset.id);

                fetch('ventas_bajas.php', { method: 'POST', body: fd })
                .then(r => r.text())
                .then(msg => { alert(msg); window.location.reload(); });
            }
            
            // EDITAR
            if (btnEdit) {
                idVentaEdicion = btnEdit.dataset.id;
                
                fetch(`obtener_detalle_venta.php?id=${idVentaEdicion}`)
                    .then(r => r.json())
                    .then(data => {
                        if(data.venta) {
                            selectCliente.value = data.venta.nombre_cliente;
                            document.getElementById('fecha_venta').value = data.venta.fecha_venta;
                            
                            // Llenar carrito con datos existentes
                            carrito = data.productos.map(p => ({
                                id_articulo: p.id, 
                                nombre: p.nombre,
                                cantidad: parseInt(p.cantidad),
                                precio: parseFloat(p.precio)
                            }));
                            actualizarCarritoTabla();
                            if (modal) modal.style.display = 'flex';
                        }
                    });
            }

            // PDF
            if (btnPdf) {
                window.open(`generar_ticket_venta.php?id=${btnPdf.dataset.id}`, '_blank'); 
            }
        });
    }

    //FUNCIONES DEL MODAL
    if (btnAbrir) {
        btnAbrir.addEventListener('click', () => {
            formulario.reset();
            carrito = []; 
            idVentaEdicion = null; 
            actualizarCarritoTabla(); 
            if (modal) modal.style.display = 'flex';
        });
    }

    if (modal) {
        modal.addEventListener('click', (e) => {
            if (e.target === modal || e.target.closest('.cerrar-modal')) {
                modal.style.display = 'none';
            }
        });
    }
});