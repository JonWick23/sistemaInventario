function generarPDF() {
    const elementoPrincipal = document.getElementById('tabla1');

    if (!elementoPrincipal) {
        console.error("No se encontró el contenedor de la tabla principal (tabla1).");
        return;
    }

    const MARGEN_MM = 20;
    const pdf = new jspdf.jsPDF('p', 'mm', 'a4');
    
    const pdfAnchoTotal = pdf.internal.pageSize.getWidth();
    const pdfAltoTotal = pdf.internal.pageSize.getHeight();
    const anchoDisponible = pdfAnchoTotal - (MARGEN_MM * 2);

    html2canvas(elementoPrincipal, { 
        scale: 2, 
        useCORS: true,
        ignoreElements: function(element) {
            if (element.classList.contains('acciones') || element.classList.contains('celda-acciones') || element.classList.contains('paginacion')) {
                return true;
            }
            return false;
        }
        // ----------------------------------------------
    }).then(canvasPrincipal => {
        
        const imgDataPrincipal = canvasPrincipal.toDataURL('image/jpeg', 1.0);
        const imgAlturaPrincipal = (canvasPrincipal.height * anchoDisponible) / canvasPrincipal.width;
        
        let alturaRestante = imgAlturaPrincipal;
        let posicionY = MARGEN_MM; 

        pdf.addImage(imgDataPrincipal, 'JPEG', MARGEN_MM, posicionY, anchoDisponible, imgAlturaPrincipal);
        
        alturaRestante -= (pdfAltoTotal - MARGEN_MM);

        while (alturaRestante > 0) {
            posicionY = -(imgAlturaPrincipal - alturaRestante) + MARGEN_MM;
            pdf.addPage();
            pdf.addImage(imgDataPrincipal, 'JPEG', MARGEN_MM, posicionY, anchoDisponible, imgAlturaPrincipal);
            alturaRestante -= pdfAltoTotal;
        }

        pdf.save('compras.pdf');
    });
}