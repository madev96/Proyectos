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
import javafx.beans.property.ReadOnlyStringWrapper;
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

public class ConsultarServiciosController implements Initializable {

    @FXML
    private TableView<Entrada> tabla;
    @FXML
    private TableColumn<Entrada, String> tcReg;
    @FXML
    private TableColumn<Entrada, String> tcSer;
    @FXML
    private TableColumn<Entrada, String> tcMot;
    @FXML
    private TableColumn<Entrada, String> tcMat;
    @FXML
    private TableColumn<Entrada, String> tcMar;
    @FXML
    private TableColumn<Entrada, String> tcMod;
    @FXML
    private TableColumn<Entrada, String> tcCol;
    @FXML
    private TableColumn<Entrada, String> tcTip;
    @FXML
    private TableColumn<Entrada, String> tcCon;
    @FXML
    private TableColumn<Entrada, String> tcGru;
    @FXML
    private TableColumn<Entrada, String> tcDir;
    @FXML
    private TableColumn<Entrada, String> tcDiaEnt;

    @FXML
    private Button btnVolver;

    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // Configura las CellValueFactory para cada columna
        tcSer.setCellValueFactory(cellData -> new ReadOnlyStringWrapper(cellData.getValue().getServicio()));
        tcMot.setCellValueFactory(cellData -> new ReadOnlyStringWrapper(cellData.getValue().getMotivo()));
        tcMat.setCellValueFactory(cellData -> new ReadOnlyStringWrapper(cellData.getValue().getMatricula()));
        tcMar.setCellValueFactory(cellData -> new ReadOnlyStringWrapper(cellData.getValue().getMarca()));
        tcMod.setCellValueFactory(cellData -> new ReadOnlyStringWrapper(cellData.getValue().getModelo()));
        tcCol.setCellValueFactory(cellData -> new ReadOnlyStringWrapper(cellData.getValue().getColor()));
        tcTip.setCellValueFactory(cellData -> new ReadOnlyStringWrapper(cellData.getValue().getTipoDeVehiculo()));
        tcCon.setCellValueFactory(cellData -> new ReadOnlyStringWrapper(cellData.getValue().getConductor()));
        tcGru.setCellValueFactory(cellData -> new ReadOnlyStringWrapper(cellData.getValue().getGrua()));
        tcDir.setCellValueFactory(cellData -> new ReadOnlyStringWrapper(cellData.getValue().getDireccion()));
        tcDiaEnt.setCellValueFactory(cellData -> new ReadOnlyStringWrapper(cellData.getValue().getDiaEntrada()));
                tcReg.setCellValueFactory(cellData -> new ReadOnlyStringWrapper(cellData.getValue().getIdEntrada()));


        cargarDatosDesdeBaseDeDatos();
    }

    private void cargarDatosDesdeBaseDeDatos() {
        ObservableList<Entrada> listaEntradas = FXCollections.observableArrayList();

        try (Connection conexión = DriverManager.getConnection("jdbc:mysql://localhost:3306/entradas_bd", "admin", ",.Manudev,.77");
             PreparedStatement consulta = conexión.prepareStatement("SELECT \n" +
                     "    idEntrada, \n" +
                     "    matricula, \n" +
                     "    marca, \n" +
                     "    modelo, \n" +
                     "    color, \n" +
                     "    estado, \n" +
                     "    tipoDeVehiculo, \n" +
                     "    numeroPolicia, \n" +
                     "    servicio, \n" +
                     "    motivo, \n" +
                     "    conductor, \n" +
                     "    grua, \n" +
                     "    usuario, \n" +
                     "    comentarios, \n" +
                     "    diaRetirada, \n" +
                     "    direccion, \n" +
                     "    diaEntrada \n" +
                     "      FROM \n" +
                     "    entradas;");
             ResultSet resultado = consulta.executeQuery()) {

            while (resultado.next()) {
                Entrada entrada = new Entrada(
                        resultado.getString("idEntrada"),
                        resultado.getString("matricula"),
                        resultado.getString("marca"),
                        resultado.getString("modelo"),
                        resultado.getString("color"),
                        resultado.getString("estado"),
                        resultado.getString("tipoDeVehiculo"),
                        resultado.getString("numeroPolicia"),
                        resultado.getString("servicio"),
                        resultado.getString("motivo"),
                        resultado.getString("conductor"),
                        resultado.getString("grua"),
                        resultado.getString("usuario"),
                        resultado.getString("comentarios"),
                        resultado.getString("diaRetirada"),
                        resultado.getString("direccion"),
                        resultado.getString("diaEntrada")
                      );
                                
                 
                listaEntradas.add(entrada);
            }
        } catch (Exception e) {
            e.printStackTrace(); 
        }

        tabla.setItems(listaEntradas);
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
