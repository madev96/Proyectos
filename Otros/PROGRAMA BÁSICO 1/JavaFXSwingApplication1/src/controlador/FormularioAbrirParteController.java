package controlador;

import java.io.IOException;
import java.net.URL;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.Alert.AlertType;
import javafx.scene.control.Button;
import javafx.scene.control.ComboBox;
import javafx.scene.control.DatePicker;

import javafx.scene.control.TextField;
import javafx.stage.Stage;
import org.apache.pdfbox.pdmodel.PDDocument;
import org.apache.pdfbox.pdmodel.PDPage;
import org.apache.pdfbox.pdmodel.PDPageContentStream;

public class FormularioAbrirParteController implements Initializable {

    @FXML
    private ComboBox<String> nombreConductor;
    @FXML
    private ComboBox<String> grua;
    @FXML
    private ComboBox<String> turno;
    @FXML
    private Button btnNo;
    @FXML
    private DatePicker diaParte;
    @FXML
    private TextField horaParte;
    @FXML
    private TextField minParte;

    String url = "jdbc:mysql://localhost:3306/partes_bd";
    String usuario = "root";
    String contraseña = "";

    ObservableList<String> conductoresLista = FXCollections.observableArrayList("Sin conductor", "Alex", "Andrei", "Antonio", "Cipri", "Gabi", "Javi", "Jesús", "Juanjo", "Manu", "Marius", "Rober");
    ObservableList<String> gruaLista = FXCollections.observableArrayList("Sin grúa", "03", "44", "59");
    ObservableList<String> turnoLista = FXCollections.observableArrayList("Sin turno", "Mañana", "Tarde", "Noche", "Mañana-Tarde", "Tarde-Noche");

    @Override
    public void initialize(URL url, ResourceBundle rb) {
        nombreConductor.setItems(conductoresLista);
        grua.setItems(gruaLista);
        turno.setItems(turnoLista);

        turno.setValue("Sin turno");
        nombreConductor.setValue("Sin conductor");
        grua.setValue("Sin grúa");
    }

    @FXML
    private void guardarDatos() {
        String idConductor = nombreConductor.getValue();
        String idGrua = grua.getValue();
        String idTurno = turno.getValue();
        String diaTurno = diaParte.getValue().toString();
        String horaTurno = horaParte.getText();
        String minTurno = minParte.getText();
        

        try (Connection conexión = DriverManager.getConnection(url, usuario, contraseña)) {
            String sql = "INSERT INTO Partes (idConductor, idGrua, idTurno, diaTurno, horaTurno, minTurno) VALUES (?, ?, ?, ?, ?, ?)";
            PreparedStatement declaración = conexión.prepareStatement(sql);

            declaración.setString(1, idConductor);
            declaración.setString(2, idGrua);
            declaración.setString(3, idTurno);
            declaración.setString(4, diaTurno);
            declaración.setString(5, horaTurno);
            declaración.setString(6, minTurno);

            int filasInsertadas = declaración.executeUpdate();
            if (filasInsertadas > 0) {
                System.out.println("Datos insertados correctamente.");
            } else {
                System.out.println("No se pudo insertar los datos.");
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    public static void generarPDF(String idConductor, String idGrua, String idTurno, String diaTurno, String horaTurno, String minTurno) {
        // Crear un nuevo documento PDF
        try (PDDocument document = new PDDocument()) {
            PDPage page = new PDPage();
            document.addPage(page);

            // Crear un contenido de página
            try (PDPageContentStream contentStream = new PDPageContentStream(document, page)) {
                contentStream.beginText();
                contentStream.newLineAtOffset(50, 750);
                contentStream.showText("Informe del parte");
                contentStream.newLineAtOffset(0, -20);
                contentStream.showText("Conductor: " + idConductor);
                contentStream.newLineAtOffset(0, -20);
                contentStream.showText("Grua: " + idGrua);
                contentStream.newLineAtOffset(0, -20);
                contentStream.showText("Turno: " + idTurno);
                contentStream.newLineAtOffset(0, -20);
                contentStream.showText("Día del Parte: " + diaTurno);
                contentStream.newLineAtOffset(0, -20);
                contentStream.showText("Hora del Parte: " + horaTurno);
                contentStream.newLineAtOffset(0, -20);
                contentStream.showText("Minutos del Parte: " + minTurno);
                contentStream.newLineAtOffset(0, -20);
                contentStream.endText();
            }

            // Guardar el PDF en un archivo
            String rutaPDF = "Informe.pdf"; // Puedes cambiar la ruta si es necesario
            document.save(rutaPDF);
            System.out.println("PDF generado correctamente en: " + rutaPDF);
        } catch (IOException e) {
            e.printStackTrace();
            System.err.println("Error al generar el PDF: " + e.getMessage());
        }
    }


    @FXML
    private void imprimirYGuardar(ActionEvent event) {
        try {
            guardarDatos(); // Llama a la función para guardar datos

            String idConductor = nombreConductor.getValue();
            String idGrua = grua.getValue();
            String idTurno = turno.getValue();
            String diaTurno = diaParte.getValue().toString();
            String horaTurno = horaParte.getText();
            String minTurno = minParte.getText();

            generarPDF(idConductor, idGrua, idTurno, diaTurno, horaTurno, minTurno); // Llama a la función para generar el PDF

            // Si todo se ejecuta correctamente, mostrar un mensaje de éxito
            Alert alert = new Alert(AlertType.INFORMATION);
            alert.setTitle("Éxito");
            alert.setHeaderText(null);
            alert.setContentText("El parte se ha guardado y el PDF se ha generado correctamente.");
            alert.showAndWait();
        } catch (Exception e) {
            // Manejar excepciones
            Alert alert = new Alert(AlertType.ERROR);
            alert.setTitle("Error");
            alert.setHeaderText(null);
            alert.setContentText("Se ha producido un error inesperado: " + e.getMessage());
            alert.showAndWait();
        }
    }

    @FXML
    public void closeWindows() {
        try {
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/vista/MenuVista.fxml"));
            Parent root = loader.load();
            Scene scene = new Scene(root);
            Stage stage = new Stage();
            stage.setScene(scene);
            stage.show();
            Stage myStage = (Stage) this.btnNo.getScene().getWindow();
            myStage.close();
        } catch (IOException ex) {
            Logger.getLogger(MenuController.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
}
