package controlador;

import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.fxml.FXML;
import javafx.scene.control.ComboBox;
import java.io.IOException;
import java.net.URL;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.time.LocalDate;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.application.Platform;
import javafx.scene.control.DatePicker;
import javafx.fxml.Initializable;
import javafx.scene.control.Label;
import javafx.scene.control.TextArea;
import javafx.scene.control.Alert;
import javafx.scene.control.Alert.AlertType;
import javafx.scene.control.ButtonType;
import javafx.stage.StageStyle;

import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.TextField;
import javafx.stage.Stage;

public class EntradaVehiculosController implements Initializable {

    @FXML
    private Button btnVolver;
    @FXML
    private TextField tfDireccion;
    @FXML
    private TextField tfPreDireccion;
    @FXML
    private TextArea taComentarios;
    @FXML
    private DatePicker dtpDiaRetirada;
    @FXML
    private DatePicker dtpDiaEntrada;
    @FXML
    private TextField tfMatricula;
    @FXML
    private ComboBox<String> cbMarca;
    @FXML
    private ComboBox<String> cbModelo;
    @FXML
    private ComboBox<String> cbColor;
    @FXML
    private ComboBox<String> cbEstado;
    @FXML
    private ComboBox<String> cbTipoDeVehiculo;
    @FXML
    private ComboBox<String> cbPolicia;
    @FXML
    private ComboBox<String> cbServicio;
    @FXML
    private ComboBox<String> cbMotivo;
    @FXML
    private ComboBox<String> cbConductor;
    @FXML
    private ComboBox<String> cbGrua;
    @FXML
    private TextField tfHora;
    @FXML
    private TextField tfMin;
    @FXML
    private Button btnSeleccionarHora;
    @FXML
    private Label lNumReg;
    
        

    String url = "jdbc:mysql://localhost:3306/entradas_bd";
    String usuario = "root";
    String contraseña = "";

    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // Llenar los ComboBox con datos
        llenarComboBoxMarcas();
        llenarComboBoxModelos();
        llenarComboBoxColores();
        llenarComboBoxEstados();
        llenarComboBoxTiposDeVehiculo();
        llenarComboBoxPolicias();
        llenarComboBoxServicios();
        llenarComboBoxMotivos();
        llenarComboBoxConductores();
        llenarComboBoxGruas();
        mostrarSiguienteNumeroRegistro();

    }

    private void mostrarSiguienteNumeroRegistro() {
        try (Connection conexión = DriverManager.getConnection(url, usuario, contraseña);
             PreparedStatement consulta = conexión.prepareStatement("SELECT MAX(idEntrada) FROM entradas");
             ResultSet resultado = consulta.executeQuery()) {

            if (resultado.next()) {
                String maxIdEntrada = resultado.getString(1);
                if (maxIdEntrada != null) {
                    int siguienteNumeroRegistro = Integer.parseInt(maxIdEntrada) + 1;
                    lNumReg.setText(String.valueOf(siguienteNumeroRegistro));
                } else {
                    // Si no hay registros en la tabla, comenzar desde 1
                    lNumReg.setText("1");
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    private void volverAlMenuPrincipal() {
        try {
            // Tu código para volver al menú principal aquí
            // ...

            // Ejemplo: cargar la vista del menú principal
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/vista/MenuVista.fxml"));
            Parent root = loader.load();
            Scene scene = new Scene(root);
            Stage stage = new Stage();
            stage.setScene(scene);
            stage.show();

            // Cerrar la ventana actual
            Stage myStage = (Stage) lNumReg.getScene().getWindow();
            myStage.close();

        } catch (IOException ex) {
            Logger.getLogger(MenuController.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    // Resto de tu código

    // Tu método guardarDatos() y otros métodos siguen aquí

    // ...

    // Guardar datos en MySQL
    public void guardarDatos() {
        String cbMarcaValue = cbMarca.getValue();
        String cbModeloValue = cbModelo.getValue();
        String cbColorValue = cbColor.getValue();
        String cbEstadoValue = cbEstado.getValue();
        String cbPoliciaValue = cbPolicia.getValue();
        String cbServicioValue = cbServicio.getValue();
        String cbConductorValue = cbConductor.getValue();
        String cbGruaValue = cbGrua.getValue();
        String cbTipoDeVehiculoValue = cbTipoDeVehiculo.getValue();
        String tfDireccionValue = tfDireccion.getText();
        String tfPreDireccionValue = tfPreDireccion.getText();
        String taComentariosValue = taComentarios.getText();
        String tfMatriculaValue = tfMatricula.getText();
        // Obtener las horas y minutos de los TextField
        String tfHoraValue = tfHora.getText();
        String tfHora1Value = tfMin.getText();
        // Obtener las fechas de los DatePicker
        LocalDate fechaRetiradaLocal = dtpDiaRetirada.getValue();
        LocalDate fechaEntradaLocal = dtpDiaEntrada.getValue();
        // Combinar las horas y minutos en un solo campo de tiempo (HH:mm)
        String horaEntrada = tfHoraValue + ":" + tfHora1Value;

        
        // Verificar si las fechas no son nulas
        if (fechaRetiradaLocal == null || fechaEntradaLocal == null) {
            System.out.println("Selecciona fechas válidas.");
            return;
        }

        // Convertir las fechas locales a java.sql.Date
        java.sql.Date fechaRetirada = java.sql.Date.valueOf(fechaRetiradaLocal);
        java.sql.Date fechaEntrada = java.sql.Date.valueOf(fechaEntradaLocal);

        try (Connection conexión = DriverManager.getConnection(url, usuario, contraseña)) {
            String sql = "INSERT INTO entradas (matricula, marca, modelo, color, estado, tipoDeVehiculo, numeroPolicia, servicio, motivo, conductor, grua, usuario, comentarios, diaRetirada, direccion, diaEntrada, preDireccion, horaEntrada) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            PreparedStatement declaración = conexión.prepareStatement(sql);

            // Aquí deberías asegurarte de que las columnas en la tabla entradas sean de tipo VARCHAR y DATE según corresponda
            declaración.setString(1, tfMatriculaValue);
            declaración.setString(2, cbMarcaValue);
            declaración.setString(3, cbModeloValue);
            declaración.setString(4, cbColorValue);
            declaración.setString(5, cbEstadoValue);
            declaración.setString(6, cbTipoDeVehiculoValue);
            declaración.setString(7, cbPoliciaValue);
            declaración.setString(8, cbServicioValue);
            declaración.setString(9, cbMotivo.getValue()); // Acceder directamente al valor del ComboBox
            declaración.setString(10, cbConductorValue);
            declaración.setString(11, cbGruaValue);
            declaración.setString(12, "Usuario"); // Cambia "Usuario" por el valor deseado
            declaración.setString(13, taComentariosValue);
            declaración.setDate(14, fechaRetirada);
            declaración.setString(15, tfDireccionValue);
            declaración.setDate(16, fechaEntrada);
            declaración.setString(17, tfPreDireccionValue);
            declaración.setString(18, horaEntrada);

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

    private void llenarComboBoxMarcas() {
        ObservableList<String> marcas = FXCollections.observableArrayList(
            "Toyota", "Honda", "Ford", "Chevrolet", "Nissan",
            "Volkswagen", "BMW", "Mercedes-Benz", "Audi", "Hyundai",
            "Kia", "Subaru", "Mazda", "Tesla", "Ferrari", "Lamborghini",
            "Porsche", "Jaguar", "Land Rover", "Volvo", "Fiat", "Jeep",
            "Dodge", "Chrysler", "Buick", "Cadillac", "GMC", "Ram",
            "Acura", "Infiniti", "Mitsubishi", "Alfa Romeo", "Suzuki",
            "Lexus", "Lincoln", "Mini", "Smart", "Aston Martin", "Bentley",
            "Bugatti", "Maserati", "McLaren", "Rolls-Royce", "Lotus",
            "Fisker", "Pagani", "Genesis", "Koenigsegg", "Rivian",
            "Lucid", "Polestar", "Rivian", "Rimac", "Canoo",
            "Hennessey", "Spyker", "Aixam", "Bolloré", "Daihatsu", "Datsun",
            "DeLorean", "Gaz", "Geely", "Great Wall", "Haval", "Isuzu", "Lada",
            "Mahindra", "Maruti", "Nikola", "SsangYong", "Tata", "UAZ", "Zotye",
            "Zenvo", "Vencer", "VinFast", "Qoros", "Lifan", "Wuling", "Changan",
            "Geely", "BYD", "JAC", "Roewe", "MG", "Zotye", "Brilliance", "Chery",
            "Gonow", "Karry", "Hawtai", "JMC", "Landwind", "NIO", "Xpeng", "WM Motor"
        );
        cbMarca.setItems(marcas);
    }

    private void llenarComboBoxModelos() {
        ObservableList<String> modelos = FXCollections.observableArrayList(
            "Corolla", "Civic", "Focus", "Cruze", "Sentra"
        );
        cbModelo.setItems(modelos);
    }

    private void llenarComboBoxColores() {
        ObservableList<String> colores = FXCollections.observableArrayList(
            "Rojo", "Azul", "Verde", "Blanco", "Negro"
        );
        cbColor.setItems(colores);
    }

    private void llenarComboBoxEstados() {
        ObservableList<String> estados = FXCollections.observableArrayList(
            "Nuevo", "Usado", "En Reparación"
        );
        cbEstado.setItems(estados);
    }

    private void llenarComboBoxTiposDeVehiculo() {
        ObservableList<String> tipos = FXCollections.observableArrayList(
            "Automóvil", "Camioneta", "Motocicleta"
        );
        cbTipoDeVehiculo.setItems(tipos);
    }

    private void llenarComboBoxPolicias() {
        ObservableList<String> policias = FXCollections.observableArrayList(
            "600", "456", "824");
        cbPolicia.setItems(policias);
    }

    private void llenarComboBoxServicios() {
        ObservableList<String> servicios = FXCollections.observableArrayList(
            "Grúa Municipal", "Grúa Privada", "Asistencia en Carretera"
        );
        cbServicio.setItems(servicios);
    }

    private void llenarComboBoxMotivos() {
        ObservableList<String> motivos = FXCollections.observableArrayList(
            "Avería", "Accidente", "Mantenimiento", "Otro"
        );
        cbMotivo.setItems(motivos);
    }

    private void llenarComboBoxConductores() {
        ObservableList<String> conductores = FXCollections.observableArrayList(
            "Juan Pérez", "Ana Gómez", "Luis Rodríguez", "María López", "Pedro Martínez"
        );
        cbConductor.setItems(conductores);
    }

    private void llenarComboBoxGruas() {
        ObservableList<String> gruas = FXCollections.observableArrayList(
            "Grua 01", "Grua 02", "Grua 03", "Grua 04"
        );
        cbGrua.setItems(gruas);
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
