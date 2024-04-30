package controlador;

import java.io.IOException;
import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.pdmodel.PDPage;
import org.apache.pdfbox.pdmodel.PDPageContentStream;
import org.apache.pdfbox.pdmodel.common.PDRectangle;


public class GeneradorPDF {
    public static void generarPDF(String conductor, String grua, String turno, String rutaPDF) {
        try {
            // Crear un nuevo documento PDF
            PDDocument document = new PDDocument();
            PDPage page = new PDPage(PDRectangle.A4); // Usar formato A4
            document.addPage(page);

            // Crear un contenido de página para escribir en el PDF
            try (PDPageContentStream contentStream = new PDPageContentStream(document, page)) {
                // Configurar posición de inicio del texto en la página
                float x = 50;
                float y = PDRectangle.A4.getHeight() - 50; // Ajustar la posición en función del formato

                // Escribir los datos en el PDF utilizando la fuente por defecto
                contentStream.beginText();
                contentStream.setFont(null , 12); // Usar la fuente 

                contentStream.newLineAtOffset(x, y);
                contentStream.showText("Conductor: " + conductor);
                contentStream.newLineAtOffset(0, -20);
                contentStream.showText("Grúa: " + grua);
                contentStream.newLineAtOffset(0, -20);
                contentStream.showText("Turno: " + turno);
                contentStream.endText();
            }

            // Guardar el PDF en un archivo
            document.save(rutaPDF);
            document.close();
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
}
