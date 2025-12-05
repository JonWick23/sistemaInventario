function abrirEditar(id, codigo, nombre, categoria, cantidad, compra, venta, proveedor, fecha, ubicacion, estado) {
            document.getElementById("modalEditar").style.display = "flex";

            document.getElementById("edit_id").value = id;
            document.getElementById("edit_codigo").value = codigo;
            document.getElementById("edit_nombre").value = nombre;
            document.getElementById("edit_categoria").value = categoria;
            document.getElementById("edit_cantidad").value = cantidad;
            document.getElementById("edit_precio_compra").value = compra;
            document.getElementById("edit_precio_venta").value = venta;
            document.getElementById("edit_proveedor").value = proveedor;
            document.getElementById("edit_fecha").value = fecha;
            document.getElementById("edit_ubicacion").value = ubicacion;
            document.getElementById("edit_estado").value = estado;
        }

        document.getElementById("btnCerrarEditar").onclick = function() {
            document.getElementById("modalEditar").style.display = "none";
        };