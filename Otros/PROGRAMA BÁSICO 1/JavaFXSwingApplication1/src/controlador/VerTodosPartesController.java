/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/javafx/FXMLController.java to edit this template
 */
package controlador;

import java.io.IOException;
import java.net.URL;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
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
import javafx.scene.control.Button;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.stage.Stage;

public class VerTodosPartesController implements Initializable {

    @FXML
    private Button btnVolver;
    @FXML
    private Button btnCerrar;
    @FXML
    private TableView<Parte> tabla;
    @FXML
    private TableColumn<Parte, String> colConductor;
    @FXML
    private TableColumn<Parte, String> colGrua;
    @FXML
    private TableColumn<Parte, String> colTurno;
    @FXML
    private TableColumn<Parte, String> colFechaYHoraApertura;
    @FXML
    private TableColumn<Parte, String> colFechaYHoraCierre;
    @FXML
    private TableColumn<Parte, String> colCodigo;

    @Override
    public void initialize(URL url, ResourceBundle rb) {
        colConductor.setCellValueFactory(cellData -> cellData.getValue().idConductorProperty());
        colGrua.setCellValueFactory(cellData -> cellData.getValue().idGruaProperty());
        colTurno.setCellValueFactory(cellData -> cellData.getValue().idTurnoProperty());
        colFechaYHoraApertura.setCellValueFactory(cellData -> cellData.getValue().fechaYHoraAperturaProperty());
        colFechaYHoraCierre.setCellValueFactory(cellData -> cellData.getValue().fechaYHoraCierreProperty());
        colCodigo.setCellValueFactory(cellData -> cellData.getValue().idCodigoProperty());

        cargarDatosDesdeBaseDeDatos();
    }

    @FXML
private void cerrarParte(ActionEvent event) {
    Parte parteSeleccionada = tabla.getSelectionModel().getSelectedItem();

    if (parteSeleccionada != null) {
        // Verificar si el parte está abierto (la fecha de cierre está vacía)
        if (parteSeleccionada.getFechaYHoraCierre() == null || parteSeleccionada.getFechaYHoraCierre().isEmpty()) {
            try (Connection conexión = DriverManager.getConnection("jdbc:mysql://localhost:3306/partes_bd", "root", "")) {
                // Actualiza la columna "FechaYHoraCierre" con la hora actual para la fila seleccionada
                String sql = "UPDATE Partes SET FechaYHoraCierre = NOW() WHERE idCodigo = ?";
                PreparedStatement consulta = conexión.prepareStatement(sql);
                consulta.setString(1, parteSeleccionada.getIdCodigo());

                int filasActualizadas = consulta.executeUpdate();

                if (filasActualizadas > 0) {
                    System.out.println("Parte cerrado correctamente.");
                    cargarDatosDesdeBaseDeDatos();
                } else {
                    System.out.println("No se pudo cerrar el parte.");
                }
            } catch (Exception e) {
                e.printStackTrace();
            }
        } else {
            System.out.println("El parte ya está cerrado.");
        }
    } else {
        System.out.println("No se ha seleccionado ninguna fila.");
    }
}

    private void cargarDatosDesdeBaseDeDatos() {
        ObservableList<Parte> listaPartes = FXCollections.observableArrayList();

        try (Connection conexión = DriverManager.getConnection("jdbc:mysql://localhost:3306/partes_bd", "admin", ",.Manudev,.77");
             PreparedStatement consulta = conexión.prepareStatement("SELECT * FROM Partes");
             ResultSet resultado = consulta.executeQuery()) {

            while (resultado.next()) {
                Parte parte = new Parte(
                        resultado.getString("idConductor"),
                        resultado.getString("idGrua"),
                        resultado.getString("idTurno"),
                        resultado.getString("FechaYHoraApertura"),
                        resultado.getString("FechaYHoraCierre"),
                        resultado.getString("idCodigo"),
                        resultado.getString("estado")
                );

                listaPartes.add(parte);
            }
        } catch (Exception e) {
            e.printStackTrace();
        }

        tabla.setItems(listaPartes);
    }

    public void closeWindows() {
        try {
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/vista/MenuVista.fxml"));

            Parent root = loader.load();

            Scene scene = new Scene(root);
            Stage stage = new Stage();

            stage.setScene(scene);
            stage.show();

            Stage myStage = (Stage) this.btnVolver.getScene().getWindow();
            myStage.close();

        } catch (IOException ex) {
            Logger.getLogger(MenuController.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
}
