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
public class ConsultarPartesController implements Initializable {

    /**
     * Initializes the controller class.
     */
    @FXML
    private Button btnVolver;
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
    // Configura las propiedades de las columnas para mapear a las propiedades de la clase Parte
    colConductor.setCellValueFactory(cellData -> cellData.getValue().idConductorProperty());
    colGrua.setCellValueFactory(cellData -> cellData.getValue().idGruaProperty());
    colTurno.setCellValueFactory(cellData -> cellData.getValue().idTurnoProperty());
    colFechaYHoraApertura.setCellValueFactory(cellData -> cellData.getValue().fechaYHoraAperturaProperty());
    colFechaYHoraCierre.setCellValueFactory(cellData -> cellData.getValue().fechaYHoraCierreProperty());
    colCodigo.setCellValueFactory(cellData -> cellData.getValue().idCodigoProperty()); 

    // Llena el TableView con los datos de la base de datos
    cargarDatosDesdeBaseDeDatos();


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

    private void cargarDatosDesdeBaseDeDatos() {
        ObservableList<Parte> listaPartes = FXCollections.observableArrayList();

        // Realiza una consulta SQL para obtener los datos de la tabla "Partes"
       try (Connection conexión = DriverManager.getConnection("jdbc:mysql://localhost:3306/partes_bd", "admin", ",.Manudev,.77");
     PreparedStatement consulta = conexión.prepareStatement("SELECT * FROM Partes WHERE FechaYHoraCierre IS NULL ORDER BY FechaYHoraApertura DESC");
              

     ResultSet resultado = consulta.executeQuery()) {

            while (resultado.next()) {
                Parte parte = new Parte(
                        resultado.getString("idConductor"),
                        resultado.getString("idGrua"),
                        resultado.getString("idTurno"),
                        resultado.getString("FechaYHoraApertura"),
                        resultado.getString("FechaYHoraCierre"),
                        resultado.getString("idCodigo"), resultado.getString("estado")
                );

                listaPartes.add(parte);
            }
        } catch (Exception e) {
            e.printStackTrace();
        }

        tabla.setItems(listaPartes);
    }

}