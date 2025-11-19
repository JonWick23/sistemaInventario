document.addEventListener("DOMContentLoaded", function () {
  const codigoInput = document.getElementById("codigo_articulo");

  codigoInput.addEventListener("change", function () {
    const codigo = codigoInput.value.trim();

    if (codigo !== "") {
      fetch(`buscar_producto.php?codigo_articulo=${codigo}`)
        .then((response) => response.json())
        .then((data) => {
          if (!data.error) {
            document.getElementById("nombre").value = data.nombre;
            document.getElementById("categoria").value = data.categoria;
            document.getElementById("cantidad").value = data.cantidad;
            document.getElementById("precio_compra").value = data.precio_compra;
            document.getElementById("precio_venta").value = data.precio_venta;
            document.getElementById("proveedor").value = data.proveedor;
            document.getElementById("fecha_ingreso").value = data.fecha_ingreso;
            document.getElementById("ubicacion").value = data.ubicacion;
            document.getElementById("estado").value = data.estado;
          } else {
            alert("⚠️ Producto no encontrado.");
            // Limpia los campos si no existe
            document.querySelectorAll("input[type=text], input[type=number], input[type=date]").forEach(input => {
              if (input.id !== "codigo_articulo") input.value = "";
            });
          }
        })
        .catch((error) => console.error("Error al buscar producto:", error));
    }
  });
});
