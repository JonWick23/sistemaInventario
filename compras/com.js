document.addEventListener('DOMContentLoaded', function() {

    // ELEMENTOS PRINCIPALES
    // Nota: Asegúrate de que en tu compras.php el form tenga id="formularioVenta" (para reutilizar CSS) 
    // O cámbialo aquí a "formularioCompra" si lo cambiaste allá.
    const formulario = document.getElementById('formularioVenta'); 
    const modal = document.getElementById('modalOverlay');
    const btnAbrir = document.getElementById('btnAbrirFormulario');
    const tbody = document.getElementById('tablaCompraBody'); // Tabla PHP de Compras

    // ELEMENTOS DEL MODAL
    const selectProveedor = document.getElementById('nombre_proveedor'); // OJO: ID Cambiado
    const selectArticulo = document.getElementById('nom_articulo');
    const inputPrecioUnitario = document.getElementById('pre_unitario');
    const inputCantidad = document.getElementById('cantidad');
    const btnAnadirProducto = document.getElementById('btnAnadirProducto');
    const carritoBody = document.getElementById('carritoBody'); 

    let carrito = []; 
    let idVentaEdicion = null; // Reutilizamos la variable aunque sea compra

    // ---------------------------------------------------
    // 1. CARGAR SELECTS (PROVEEDORES Y ARTÍCULOS)
    // ---------------------------------------------------
    function cargarListas() {
        // Proveedores (Nuevo archivo)
        fetch('cargar_proveedores.php')
            .then(r => r.json())
            .then(data => {
                if(selectProveedor && !data.error) {
                    selectProveedor.innerHTML = '<option value="">Seleccione Proveedor</option>';
                    data.forEach(p => {
                        const op = document.createElement('option');
                        op.value = p.nombre; op.textContent = p.nombre;
                        selectProveedor.appendChild(op);
                    });
                }
            })
            .catch(e => console.error("Error: No se encuentra cargar_proveedores.php"));

        // Artículos (Nuevo archivo con precios de compra)
        fetch('cargar_articulos_compra.php')
            .then(r => r.json())
            .then(data => {
                if(selectArticulo && !data.error) {
                    selectArticulo.innerHTML = '<option value="">Seleccione Artículo</option>';
                    data.forEach(a => {
                        const op = document.createElement('option');
                        op.value = a.nombre; 
                        op.textContent = `${a.id_productos} - ${a.nombre}`;
                        // OJO: Usamos precio_compra (asegurate que el PHP lo envie asi)
                        op.dataset.precio = a.precio_compra || a.precio_venta || 0; 
                        op.dataset.id = a.id_productos;
                        selectArticulo.appendChild(op);
                    });
                }
            })
            .catch(e => console.error("Error: No se encuentra cargar_articulos_compra.php"));
    }

    cargarListas();

    // ---------------------------------------------------
    // 2. LÓGICA DEL CARRITO
    // ---------------------------------------------------
    
    if (selectArticulo) {
        selectArticulo.addEventListener('change', function() {
            const precio = this.options[this.selectedIndex].dataset.precio;
            if(inputPrecioUnitario) inputPrecioUnitario.value = precio || 0;
        });
    }

    function pintarCarrito() {
        if(!carritoBody) return;
        carritoBody.innerHTML = '';
        if(carrito.length === 0) {
            carritoBody.innerHTML = '<tr><td colspan="5" style="text-align:center">Vacío</td></tr>';
            return;
        }
        carrito.forEach((p, i) => {
            let sub = p.precio * p.cantidad;
            carritoBody.innerHTML += `
                <tr>
                    <td>${p.nombre}</td><td>${p.cantidad}</td><td>$${p.precio}</td><td>$${sub.toFixed(2)}</td>
                    <td><button type="button" class="btn-quitar" data-index="${i}" style="color:red; border:none; cursor:pointer;">X</button></td>
                </tr>`;
        });
    }

    if (btnAnadirProducto) {
        btnAnadirProducto.addEventListener('click', () => {
            const sel = selectArticulo.options[selectArticulo.selectedIndex];
            const id = sel.dataset.id;
            if(!id) return alert("Seleccione un artículo");

            const cant = parseInt(inputCantidad.value) || 1;
            const pre = parseFloat(inputPrecioUnitario.value) || 0;

            const idx = carrito.findIndex(p => String(p.id_articulo) === String(id));
            if(idx !== -1) {
                carrito[idx].cantidad += cant;
            } else {
                carrito.push({ id_articulo: id, nombre: sel.text, cantidad: cant, precio: pre });
            }
            pintarCarrito();
            inputCantidad.value = 1;
        });
    }

    if(carritoBody) {
        carritoBody.addEventListener('click', (e) => {
            if(e.target.classList.contains('btn-quitar')) {
                carrito.splice(e.target.dataset.index, 1);
                pintarCarrito();
            }
        });
    }

    // ---------------------------------------------------
    // 3. GUARDAR COMPRA (AJAX)
    // ---------------------------------------------------
    if (formulario) {
        formulario.addEventListener('submit', (e) => {
            e.preventDefault();
            if(carrito.length === 0) return alert("Carrito vacío");

            const datos = {
                // Enviamos nombre_proveedor (ojo con esto)
                nombre_proveedor: selectProveedor.value, 
                fecha_venta: document.getElementById('fecha_venta').value,
                iva: document.getElementById('iva').value,
                productos: carrito,
                id_venta: idVentaEdicion // Reutilizamos el nombre de variable
            };

            let url = idVentaEdicion ? 'compras_modificar.php' : 'compras_registro.php';

            fetch(url, { method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify(datos) })
            .then(r => r.text())
            .then(res => {
                alert(res.includes("correctamente") || res.includes("success") ? "Guardado" : res);
                window.location.reload(); 
            });
        });
    }

    // ---------------------------------------------------
    // 4. INTERACCIONES DE TABLA
    // ---------------------------------------------------
    if(tbody) {
        tbody.addEventListener('click', (e) => {
            const btnDel = e.target.closest('.btn-eliminar');
            const btnEdit = e.target.closest('.btn-modificar');
            // const btnPdf = e.target.closest('.btn-pdf'); // Si tienes PDF de compras, descomenta

            // ELIMINAR
            if(btnDel) {
                if(!confirm("¿Eliminar compra?")) return;
                let fd = new FormData(); fd.append('id_compra', btnDel.dataset.id);
                
                fetch('compras_bajas.php', { method: 'POST', body: fd })
                .then(r => r.text()).then(m => { alert(m); window.location.reload(); });
            }

            // EDITAR
            if(btnEdit) {
                idVentaEdicion = btnEdit.dataset.id;
                
                fetch(`obtener_detalle_compra.php?id=${idVentaEdicion}`)
                .then(r => r.json())
                .then(d => {
                    // El PHP devuelve "venta" para no romper compatibilidad, pero trae datos de compra
                    if(d.venta) {
                        // Llenamos proveedor (ojo con el nombre del campo que devuelve el PHP)
                        selectProveedor.value = d.venta.nombre_proveedor || d.venta.nombre_cliente; 
                        document.getElementById('fecha_venta').value = d.venta.fecha_venta;
                        
                        carrito = d.productos.map(p => ({
                            id_articulo: p.id, nombre: p.nombre, cantidad: parseInt(p.cantidad), precio: parseFloat(p.precio)
                        }));
                        pintarCarrito();
                        if(modal) modal.style.display = 'flex';
                    }
                });
            }
        });
    }

    // ---------------------------------------------------
    // 5. ABRIR/CERRAR MODAL
    // ---------------------------------------------------
    if(btnAbrir) btnAbrir.addEventListener('click', () => {
        formulario.reset(); carrito = []; idVentaEdicion = null; pintarCarrito();
        if(modal) modal.style.display = 'flex';
    });

    if(modal) modal.addEventListener('click', (e) => {
        if(e.target === modal || e.target.closest('.cerrar-modal')) modal.style.display = 'none';
    });
});