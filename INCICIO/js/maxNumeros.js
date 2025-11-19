document.addEventListener("DOMContentLoaded", () => {
  const codigoInput = document.querySelector('input[name="codigo_articulo"]');

  if (codigoInput) {
    codigoInput.addEventListener("input", function () {
      // Limitar a 20 caracteres
      if (this.value.length > 20) {
        this.value = this.value.slice(0, 20);
      }
    });
  }
});