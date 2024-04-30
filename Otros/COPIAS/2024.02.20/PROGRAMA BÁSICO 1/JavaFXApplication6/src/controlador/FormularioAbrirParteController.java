/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/javafx/FXMLController.java to edit this template
 */
package controlador;
import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.Button;
import javafx.scene.control.ComboBox;
import javafx.stage.Stage;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import javafx.scene.control.DatePicker;
import javafx.scene.control.TextField;

/**
 * FXML Controller class
 *
 * @author 996ma
 */

public class FormularioAbrirParteController implements Initializable {
    
    @FXML
    private ComboBox nombreConductor;
    @FXML
    private ComboBox grua;
    @FXML
    private ComboBox turno;
    @FXML
    private DatePicker dpDia;
    @FXML
    private TextField tfHora;
    @FXML
    private TextField tfMin;
    @FXML
    private Button btnNo;
    
    String url = "jdbc:mysql://localhost:3306/partes_bd";
    String usuario = "root";
    String contraseña = "";
    
    ObservableList<String> conductoresLista = FXCollections.observableArrayList("Sin conductor", "Alex", "Andrei", "Antonio", "Cipri", "Gabi", "Javi", "Jesús", "Juanjo", "Manu","Marius","Rober");
    ObservableList<String> gruaLista = FXCollections.observableArrayList("Sin grúa","03", "44", "59");
    ObservableList<String> turnoLista = FXCollections.observableArrayList("Sin turno","Mañana", "Tarde", "Noche", "Mañana-Tarde", "Tarde-Noche");
    
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // Para poner los títulos de los desplegables.
        nombreConductor.setItems(conductoresLista);
        grua.setItems(gruaLista);
        turno.setItems(turnoLista);
        
    /*    // Para que me salgan por defecto        
        turno.setValue("Sin turno");
        nombreConductor.setValue("Sin conductor");
        grua.setValue("Sin grúa");*/
    }
    
    // Guardar datos en MySQL
    public void guardarDatos() {
          String idConductor = nombreConductor.getValue() != null ? nombreConductor.getValue().toString() : "";
    String idGrua = grua.getValue() != null ? grua.getValue().toString() : "";
    String idTurno = turno.getValue() != null ? turno.getValue().toString() : "";
    String fechaParte = dpDia.getValue() != null ? dpDia.getValue().toString() : "";
    String horaParte = tfHora.getText();
    String minParte = tfMin.getText();

    // Verificar que todos los campos obligatorios estén completos
    if (idConductor.isEmpty() || idGrua.isEmpty() || idTurno.isEmpty() || fechaParte.isEmpty() || horaParte.isEmpty() || minParte.isEmpty()) {
        // Mostrar un mensaje de error indicando cuál campo falta
        String mensaje = "\t\t\t\t¡Se te olvidaba!\n";
        if (idConductor.isEmpty()) {
            mensaje += "- Nombre\n";
        }
        if (idGrua.isEmpty()) {
            mensaje += "- Grúa\n";
        }
        if (idTurno.isEmpty()) {
            mensaje += "- Turno\n";
        }
        if (fechaParte.isEmpty()) {
            mensaje += "- Fecha\n";
        }
        if (horaParte.isEmpty()) {
            mensaje += "- Hora\n";
        }
        if (minParte.isEmpty()) {
            mensaje += "- Minutos\n";
        }
        // Mostrar el mensaje de error en una ventana de alerta
        mostrarMensajeError("Error al abrir parte", mensaje);
        return;
    }

    // Validar el formato de la fecha
    SimpleDateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd");
    dateFormat.setLenient(false); // No permite fechas inválidas
    try {
        dateFormat.parse(fechaParte);
    } catch (ParseException e) {
        mostrarMensajeError("Error en la fecha", "Formato de fecha incorrecto. Use yyyy-MM-dd.");
        return;
    }

    // Validar el formato de la hora y los minutos
    try {
        int hora = Integer.parseInt(horaParte);
        int minuto = Integer.parseInt(minParte);

        // Verificar que la hora y los minutos estén en un rango válido
        if (hora < 0 || hora > 23 || minuto < 0 || minuto > 59) {
            mostrarMensajeError("Error en hora o minutos", "La hora debe estar entre 0 y 23, y los minutos entre 0 y 59.");
            return;
        }
    } catch (NumberFormatException e) {
        mostrarMensajeError("Error en hora o minutos", "Ingrese valores numéricos para la hora y los minutos.");
        return;
    }
        
        // Obtener la fecha y hora actual
        LocalDateTime fechaHoraActual = LocalDateTime.now();
        // Formatear la fecha y hora actual como una cadena
        String fechaHoraActualStr = fechaHoraActual.format(DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:ss"));
        
        try (Connection conexión = DriverManager.getConnection(url, usuario, contraseña)) {
            String sql = "INSERT INTO Partes (idConductor, idGrua, idTurno, FechaYHoraApertura, diaParte, horaParte, minParte) VALUES (?, ?, ?,?, ?, ?, ?)";
            PreparedStatement declaración = conexión.prepareStatement(sql);
            
            // Aquí deberías asegurarte de que las columnas en la tabla Partes sean de tipo VARCHAR
            declaración.setString(1, idConductor);
            declaración.setString(2, idGrua);
            declaración.setString(3, idTurno);
            declaración.setString(4, fechaHoraActualStr);
            declaración.setString(5, dpDia.getValue().toString());
            declaración.setString(6, tfHora.getText());
            declaración.setString(7, tfMin.getText());
            
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
    
    private void mostrarMensajeError(String titulo, String mensaje) {
        Alert alert = new Alert(Alert.AlertType.ERROR);
        alert.setTitle(titulo);
        alert.setHeaderText(null);
        alert.setContentText(mensaje);
        alert.showAndWait();
    }
}
