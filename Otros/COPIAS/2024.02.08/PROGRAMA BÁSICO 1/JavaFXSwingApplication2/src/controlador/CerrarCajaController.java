package controlador;

import java.io.IOException;
import java.net.URL;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.stage.Stage;

public class CerrarCajaController implements Initializable {

    @FXML
    private Button btnSi;
    @FXML
    private Button btnNo;

    @Override
    public void initialize(URL url, ResourceBundle rb) {
    }

    @FXML
    private void handleBtnSiClick() throws IOException {
        try {
            // Configurar la conexión a la base de datos
            String url = "jdbc:mysql://localhost:3306/cajas_bd";
            String usuario = "admin";
            String contraseña = ",.Manudev,.77";

            // Valores adecuados para usuario, turno y otras propiedades
            String nombreUsuario = "Conductor";
            String nombreTurno = "Mañana-Tarde";

            try (Connection conexión = DriverManager.getConnection(url, usuario, contraseña)) {
                // Consulta SQL para obtener el ID más alto
                String obtenerUltimoIdSql = "SELECT MAX(id) FROM Cajas";
                try (PreparedStatement obtenerIdDeclaración = conexión.prepareStatement(obtenerUltimoIdSql)) {
                    try (ResultSet resultSet = obtenerIdDeclaración.executeQuery()) {
                        if (resultSet.next()) {
                            int ultimoId = resultSet.getInt(1);

                            // Consulta SQL para actualizar la columna fechaDeCierre del registro con el ID más alto
                            String actualizarSql = "UPDATE Cajas SET fechaDeCierre = ? WHERE id = ?";
                            try (PreparedStatement actualizarDeclaración = conexión.prepareStatement(actualizarSql)) {
                                actualizarDeclaración.setString(1, obtenerFechaDeCierreYHoraActual());
                                actualizarDeclaración.setInt(2, ultimoId);
                                actualizarDeclaración.executeUpdate();
                            }
                        }
                    }
                }

                // Consulta SQL para insertar una nueva fila con la fecha de apertura y fecha de cierre vacía
                String nuevaCajaSql = "INSERT INTO Cajas (usuario, turno, fechaDeApertura, fechaDeCierre) VALUES (?, ?, ?, NULL)";
                try (PreparedStatement nuevaCajaDeclaración = conexión.prepareStatement(nuevaCajaSql)) {
                    nuevaCajaDeclaración.setString(1, nombreUsuario);
                    nuevaCajaDeclaración.setString(2, nombreTurno);
                    nuevaCajaDeclaración.setString(3, obtenerFechaDeAperturaYHoraActual());
                    nuevaCajaDeclaración.executeUpdate();
                }
            }

            // Cierra la ventana actual
            Stage stage = (Stage) btnSi.getScene().getWindow();
            stage.close();

            // Abre la ventana del menú principal
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/vista/MenuVista.fxml"));
            Parent root = loader.load();
            Scene scene = new Scene(root);
            Stage menuStage = new Stage();
            menuStage.setScene(scene);
            menuStage.show();
        } catch (SQLException e) {
            Logger.getLogger(CerrarCajaController.class.getName()).log(Level.SEVERE, null, e);
        }
    }

    private String obtenerFechaDeCierreYHoraActual() {
        LocalDateTime now = LocalDateTime.now();
        DateTimeFormatter formatter = DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:ss");
        return now.format(formatter);
    }

    private String obtenerFechaDeAperturaYHoraActual() {
        LocalDateTime now = LocalDateTime.now();
        DateTimeFormatter formatter = DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:ss");
        return now.format(formatter);
    }

    public void closeWindows() {
        try {
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/vista/MenuVista.fxml"));
            Parent root = loader.load();
            Scene scene = new Scene(root);
            Stage stage = new Stage();
            stage.setScene(scene);
            stage.show();

            Stage myStage = (Stage) btnNo.getScene().getWindow();
            myStage.close();
        } catch (IOException ex) {
            Logger.getLogger(MenuController.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
}

