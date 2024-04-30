package controlador;

import java.io.IOException;
import java.net.URL;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
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
import javafx.scene.control.Button;
import javafx.scene.control.ComboBox;
import javafx.scene.control.DatePicker;
import javafx.scene.control.TextField;
import javafx.stage.Stage;

public class FormularioAbrirParteController implements Initializable {

    @FXML
    private ComboBox<String> nombreConductor;
    @FXML
    private ComboBox<String> grua;
    @FXML
    private ComboBox<String> turno;
    @FXML
    private DatePicker diaUParte;
    @FXML
    private TextField horaUParte;
    @FXML
    private TextField minUParte;
    @FXML
    private Button btnNo;

    String url = "jdbc:mysql://localhost:3306/partes_bd";
    String usuario = "root";
    String contraseña = "";

    ObservableList<String> conductoresLista = FXCollections.observableArrayList("", "Alex", "Andrei", "Antonio",
            "Cipri", "Gabi", "Javi", "Jesús", "Juanjo", "Manu", "Marius", "Rober");
    ObservableList<String> gruaLista = FXCollections.observableArrayList("", "03", "44", "59");
    ObservableList<String> turnoLista = FXCollections.observableArrayList("", "Mañana", "Tarde", "Noche",
            "Mañana-Tarde", "Tarde-Noche");

    @Override
    public void initialize(URL url, ResourceBundle rb) {
        nombreConductor.setItems(conductoresLista);
        grua.setItems(gruaLista);
        turno.setItems(turnoLista);

        turno.setValue("");
        nombreConductor.setValue("");
        grua.setValue("");
    }

    public void guardarDatos() {
        String idConductor = nombreConductor.getValue().toString();
        String idGrua = grua.getValue().toString();
        String idTurno = turno.getValue().toString();
        java.sql.Date diaParte = java.sql.Date.valueOf(diaUParte.getValue());
        String horaParte = horaUParte.getText();
        String minParte = minUParte.getText();

        LocalDateTime fechaHoraActual = LocalDateTime.now();
        String fechaHoraActualStr = fechaHoraActual.format(DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:ss"));

        try (Connection conexión = DriverManager.getConnection(url, usuario, contraseña)) {
            String sql = "INSERT INTO Partes (idConductor, idGrua, idTurno, FechaYHoraApertura, diaParte, horaParte, minParte) VALUES (?, ?, ?, ?, ?, ?, ?)";
            PreparedStatement declaración = conexión.prepareStatement(sql);

            declaración.setString(1, idConductor);
            declaración.setString(2, idGrua);
            declaración.setString(3, idTurno);
            declaración.setString(4, fechaHoraActualStr);
            declaración.setDate(5, diaParte);
            declaración.setString(6, horaParte);
            declaración.setString(7, minParte);

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
}
