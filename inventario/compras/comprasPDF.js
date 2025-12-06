function generarPDF() {
    const elementoPrincipal = document.getElementById('tabla1');

    if (!elementoPrincipal) {
        console.error("No se encontró la tabla.");
        return;
    }

    const valTotalVentas = document.getElementById('kpi_total_compras') ? document.getElementById('kpi_total_compras').innerText : "0";
    const valMontoTotal = document.getElementById('kpi_monto_total') ? document.getElementById('kpi_monto_total').innerText : "$0.00";
    const valPromedio = document.getElementById('kpi_promedio') ? document.getElementById('kpi_promedio').innerText : "$0.00";

    const MARGEN_IZQUIERDO = 15;
    const MARGEN_DERECHO = 15;
    
    const INICIO_TABLA = 100; 
    
    const pdf = new jspdf.jsPDF('p', 'mm', 'a4');
    const anchoPagina = pdf.internal.pageSize.getWidth();
    const altoPagina = pdf.internal.pageSize.getHeight();

    // Paleta de Colores
    const verde = [59, 92, 74];
    const azulBrand = [37, 99, 235];    
    const grisOscuro = [30, 41, 59];    
    const grisClaro = [100, 116, 139]; 
    const fondoGris = [248, 250, 252]; 

    // =======
    pdf.setFillColor(...verde);
    pdf.rect(0, 0, 8, altoPagina, 'F');

    // Título
    pdf.setFont("helvetica", "bold");
    pdf.setFontSize(24);
    pdf.setTextColor(...grisOscuro);
    pdf.text("REPORTE DE COMPRAS", MARGEN_IZQUIERDO, 25);

    // Datos Empresa
    pdf.setFontSize(10);
    pdf.setTextColor(...azulBrand);
    pdf.text("EMPRESA UPZ", MARGEN_IZQUIERDO, 35);
    
    pdf.setFont("helvetica", "normal");
    pdf.setTextColor(...grisClaro);
    pdf.text("RFC: DEV-880120-SW1 | Tel: (555) 123-4567", MARGEN_IZQUIERDO, 40);

    const cajaX = anchoPagina - 60;
    pdf.setFillColor(241, 245, 249);
    pdf.roundedRect(cajaX, 15, 45, 20, 3, 3, 'F');
    pdf.setFontSize(8);
    pdf.text("FECHA DE EMISIÓN", cajaX + 5, 22);
    pdf.setFontSize(11);
    pdf.setFont("helvetica", "bold");
    pdf.setTextColor(...grisOscuro);
    pdf.text(new Date().toLocaleDateString(), cajaX + 5, 30);


    // CUADROS
    const startY_Cuadros = 50;
    const gap = 5; 
    const anchoDisponible = anchoPagina - MARGEN_IZQUIERDO - MARGEN_DERECHO;
    const anchoCuadro = (anchoDisponible - (gap * 2)) / 3; 
    const altoCuadro = 30;

    function dibujarKPI(x, titulo, valor, iconoTexto) {
        pdf.setDrawColor(220, 220, 220);
        pdf.setFillColor(255, 255, 255);
        pdf.roundedRect(x, startY_Cuadros, anchoCuadro, altoCuadro, 2, 2, 'FD');
        
        // Línea superior de color (decoración)
        pdf.setFillColor(...verde);
        pdf.rect(x, startY_Cuadros, anchoCuadro, 2, 'F');

        pdf.setFontSize(8);
        pdf.setFont("helvetica", "bold");
        pdf.setTextColor(...grisClaro);
        pdf.text(titulo, x + 5, startY_Cuadros + 10);

        pdf.setFontSize(14);
        pdf.setFont("helvetica", "bold");
        pdf.setTextColor(...grisOscuro);
        pdf.text(valor, x + 5, startY_Cuadros + 22);
    }

    // 3 cuadros
    let currentX = MARGEN_IZQUIERDO;
    
    dibujarKPI(currentX, "TOTAL COMPRAS", valTotalVentas);
    currentX += anchoCuadro + gap;

    dibujarKPI(currentX, "MONTO TOTAL", valMontoTotal);
    currentX += anchoCuadro + gap;

    dibujarKPI(currentX, "PROMEDIO / COMPRA", valPromedio);

    html2canvas(elementoPrincipal, { 
        scale: 2, 
        useCORS: true,
        ignoreElements: (element) => {
            return element.classList.contains('acciones') || 
                   element.classList.contains('celda-acciones') || 
                   element.classList.contains('paginacion');
        }
    }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const imgAncho = anchoPagina - MARGEN_IZQUIERDO - MARGEN_DERECHO;
        const imgAlto = (canvas.height * imgAncho) / canvas.width;
        
        let alturaRestante = imgAlto;
        let posicionY = INICIO_TABLA;

        pdf.addImage(imgData, 'PNG', MARGEN_IZQUIERDO, posicionY, imgAncho, imgAlto);
        
        let espacioUsado = altoPagina - INICIO_TABLA - 10;
        alturaRestante -= espacioUsado;

        while (alturaRestante > 0) {
            pdf.addPage();
            
            pdf.setFillColor(...azulBrand);
            pdf.rect(0, 0, 8, altoPagina, 'F');

            pdf.setFontSize(8);
            pdf.setTextColor(...grisClaro);
            pdf.text("Reporte de Ventas - Continuación", MARGEN_IZQUIERDO, 15);

            let margenSuperiorNuevo = 20;
            let desplazamiento = -(imgAlto - alturaRestante) + margenSuperiorNuevo;
            
            pdf.addImage(imgData, 'PNG', MARGEN_IZQUIERDO, desplazamiento, imgAncho, imgAlto);
            
            alturaRestante -= (altoPagina - (margenSuperiorNuevo * 2));
        }

        pdf.save('Reporte_Compras.pdf');
    });
}