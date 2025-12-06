document.addEventListener('DOMContentLoaded', function() {

    // ELEMENTOS PRINCIPALES
    const formulario = document.getElementById('formularioCompras'); 
    const modal = document.getElementById('modalOverlay');
    const btnAbrir = document.getElementById('btnAbrirFormulario');
    const tbody = document.getElementById('tablaCompraBody');

    // ELEMENTOS DEL MODAL
    const selectProveedor = document.getElementById('nombre_proveedor');
    const selectArticulo = document.getElementById('nom_articulo');
    const inputPrecioUnitario = document.getElementById('pre_unitario');
    const inputCantidad = document.getElementById('cantidad');
    const btnAnadirProducto = document.getElementById('btnAnadirProducto');
    const carritoBody = document.getElementById('carritoBody'); 

    let carrito = []; 
    let idVentaEdicion = null; 

    function cargarListas() {
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
            });

        fetch('cargar_articulos_compra.php')
            .then(r => r.json())
            .then(data => {
                if(selectArticulo && !data.error) {
                    selectArticulo.innerHTML = '<option value="">Seleccione Artículo</option>';
                    data.forEach(a => {
                        const op = document.createElement('option');
                        op.value = a.nombre; 
                        op.textContent = `${a.id_productos} - ${a.nombre}`;
                        op.dataset.precio = a.precio_compra || a.precio_venta || 0; 
                        op.dataset.id = a.id_productos;
                        selectArticulo.appendChild(op);
                    });
                }
            });
    }
    cargarListas();

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
            
            // Validación básica
            const id = sel.dataset.id;
            if(!id) return alert("Seleccione un artículo");

            const cant = parseInt(inputCantidad.value) || 1;
            const pre = parseFloat(inputPrecioUnitario.value) || 0;

            const nombreLimpio = sel.value; 

            const idx = carrito.findIndex(p => String(p.id_articulo) === String(id));
            
            if(idx !== -1) {
                carrito[idx].cantidad += cant;
            } else {
                carrito.push({ 
                    id_articulo: id, 
                    nombre: nombreLimpio, //variable limpia
                    cantidad: cant, 
                    precio: pre 
                });
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

    if (formulario) {
        formulario.addEventListener('submit', (e) => {
            e.preventDefault();
            if(carrito.length === 0) return alert("Carrito vacío");

            const datos = {
                nombre_proveedor: selectProveedor.value, 
                fecha_venta: document.getElementById('fecha_venta').value,
                iva: document.getElementById('iva').value,
                productos: carrito,
                id_venta: idVentaEdicion 
            };

            let url = idVentaEdicion ? 'modificar_compras.php' : 'compras_registro.php';

            fetch(url, { method: 'POST', headers: {'Content-Type': 'application/json'}, body: JSON.stringify(datos) })
            .then(r => r.text())
            .then(res => {
                alert(res.includes("correctamente") || res.includes("success") ? "Guardado" : res);
                window.location.reload(); 
            });
        });
    }

    if(tbody) {
        tbody.addEventListener('click', (e) => {
            const btnDel = e.target.closest('.btn-eliminar');
            const btnEdit = e.target.closest('.btn-modificar');

            if(btnDel) {
                if(!confirm("¿Eliminar compra?")) return;
                let fd = new FormData(); fd.append('id_compra', btnDel.dataset.id);
                
                fetch('compras_bajas.php', { method: 'POST', body: fd })
                .then(r => r.text()).then(m => { alert(m); window.location.reload(); });
            }

            if(btnEdit) {
                idVentaEdicion = btnEdit.dataset.id;
                fetch(`obtener_detalle_compra.php?id=${idVentaEdicion}`)
                .then(r => r.json())
                .then(d => {
                    if(d.venta) {
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

    if(btnAbrir) btnAbrir.addEventListener('click', () => {
        formulario.reset(); carrito = []; idVentaEdicion = null; pintarCarrito();
        if(modal) modal.style.display = 'flex';
    });

    if(modal) modal.addEventListener('click', (e) => {
        if(e.target === modal || e.target.closest('.cerrar-modal')) modal.style.display = 'none';
    });
});