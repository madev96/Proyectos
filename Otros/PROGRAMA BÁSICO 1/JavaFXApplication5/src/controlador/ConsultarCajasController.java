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
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.stage.Stage;

/**
 * FXML Controller class
 *
 * @author 996ma
 */
public class ConsultarCajasController implements Initializable {

    /**
     * Initializes the controller class.
     */
    @FXML
    private Button btnVolver;
    @FXML
    private TableView<Caja> tabla;
    @FXML
    private TableColumn<Caja, String> usuario;
    @FXML
    private TableColumn<Caja, String> turno;
    @FXML
    private TableColumn<Caja, String> horaDeApertura;
    @FXML
    private TableColumn<Caja, String> horaDeCierre;
   
    
 @Override
public void initialize(URL url, ResourceBundle rb) {
    // Configura las propiedades de las columnas para mapear a las propiedades de la clase Caja
    usuario.setCellValueFactory(cellData -> cellData.getValue().getUsuarioProperty());
    turno.setCellValueFactory(cellData -> cellData.getValue().getTurnoProperty());
    horaDeApertura.setCellValueFactory(cellData -> cellData.getValue().getFechaDeAperturaProperty());
    horaDeCierre.setCellValueFactory(cellData -> cellData.getValue().getFechaDeCierreProperty());

    // Llena el TableView con los datos de la base de datos
    cargarDatosDesdeBaseDeDatos();
}
    
    private void cargarDatosDesdeBaseDeDatos() {
        ObservableList<Caja> listaCajas = FXCollections.observableArrayList();

        // Realiza una consulta SQL para obtener los datos de la tabla "Partes"
       try (Connection conexión = DriverManager.getConnection("jdbc:mysql://localhost:3306/cajas_bd", "admin", ",.Manudev,.77");
PreparedStatement consulta = conexión.prepareStatement("SELECT * FROM Cajas ORDER BY fechaDeApertura DESC");
     ResultSet resultado = consulta.executeQuery()) {

            while (resultado.next()) {
                Caja caja = new Caja(
                        resultado.getString("usuario"),
                        resultado.getString("turno"),
                        resultado.getString("fechaDeApertura"),
                        resultado.getString("fechaDeCierre")
                   
                );

                listaCajas.add(caja);
            }
        } catch (Exception e) {
            e.printStackTrace();
        }

        tabla.setItems(listaCajas);
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
