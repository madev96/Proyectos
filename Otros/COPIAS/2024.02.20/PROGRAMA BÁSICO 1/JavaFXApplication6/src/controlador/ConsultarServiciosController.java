package controlador;

import javafx.beans.property.ReadOnlyStringWrapper;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.*;
import javafx.stage.Stage;
import java.io.IOException;
import java.net.URL;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.time.LocalDate;
import java.time.format.DateTimeFormatter;
import java.util.ResourceBundle;
import java.util.function.Predicate;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;

public class ConsultarServiciosController implements Initializable {

    @FXML
    private TableView<Entrada> tablaEntradas;
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
    private TextField txtMatricula;
    @FXML
    private TextField txtMarca;
    @FXML
    private TextField txtModelo;
    @FXML
    private TextField txtColor;
    @FXML
    private TextField txtNumReg;
    @FXML
    private TextField txtServicio;
    @FXML
    private TextField txtMotivo;
    @FXML
    private TextField txtConductor;
    @FXML
    private TextField txtDireccion;
    @FXML
    private TextField txtGrua;
    @FXML
    private DatePicker dpFechaInicio;
    @FXML
    private DatePicker dpFechaFin;
    
    @FXML
    private TextField txtEstado;  // Nuevo campo de filtro de estado
    @FXML
    private TextField txtTipoVehiculo;  // Nuevo campo de filtro de tipo de vehículo
    @FXML
    private TextField txtNumeroPolicia;  // Nuevo campo de filtro de número de policía
    @FXML
    private TextField txtUsuario;  // Nuevo campo de filtro de usuario
    @FXML
    private TextField txtComentarios;  // Nuevo campo de filtro de comentarios
    @FXML
    private TextField txtDiaRetirada;  // Nuevo campo de filtro de día de retirada
    @FXML
    private TextField txtPreDireccion;  // Nuevo campo de filtro de pre-dirección
    @FXML
    private TextField txtPlaza;  // Nuevo campo de filtro de plaza
    @FXML
    private TextField txtHoraEntrada;  // Nuevo campo de filtro de hora de entrada
    @FXML
    private Button btnLimpiar;
    @FXML
    private Button btnVolver;

    private ObservableList<Entrada> listaEntradas;
    @FXML
    private ToggleButton tbDeposito;
    @FXML
    private TableColumn<Entrada, String> tcDiaSal;

    
    private LocalDate fechaInicioFiltro;
    private LocalDate fechaFinFiltro;
    
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        
        
        tcDiaSal.setCellValueFactory(cellData -> {
    String diaSalida = cellData.getValue().getDiaSalida();
    if (diaSalida != null) {
    DateTimeFormatter formatter = DateTimeFormatter.ofPattern("dd/MM/yyyy");
        LocalDate fechaSalida = LocalDate.parse(diaSalida, formatter);
        return new ReadOnlyStringWrapper(formatter.format(fechaSalida));
    } else {
        return new ReadOnlyStringWrapper("");
    }
});
        
        
        // Configurar el botón "Limpiar" para que borre todos los campos introducidos por el usuario
        btnLimpiar.setOnAction(event -> {
         limpiarCampos();
        });
        
        tbDeposito.setOnAction(event -> {
        // Llama a una función para filtrar según el estado del ToggleButton
         filtrarDeposito();
        });
        
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

        // Inicializar lista de entradas y cargar datos
        listaEntradas = FXCollections.observableArrayList();
        cargarDatosDesdeBaseDeDatos();

        // Agregar listeners para los campos de filtro
        agregarListenersFiltro(txtMatricula);
        agregarListenersFiltro(txtMarca);
        agregarListenersFiltro(txtModelo);
        agregarListenersFiltro(txtColor);
        agregarListenersFiltro(txtNumReg);
        agregarListenersFiltro(txtServicio);
        agregarListenersFiltro(txtMotivo);
        agregarListenersFiltro(txtConductor);
        agregarListenersFiltro(txtGrua);
        agregarListenersFiltro(txtDireccion);
       
        // Agregar listeners para los DatePickers
        dpFechaInicio.valueProperty().addListener((observable, oldValue, newValue) -> {
            fechaInicioFiltro = newValue;
            filtrarTabla();
        });

        dpFechaFin.valueProperty().addListener((observable, oldValue, newValue) -> {
            fechaFinFiltro = newValue;
            filtrarTabla();
        });
    }

    private void agregarListenersFiltro(TextField campoFiltro) {
        campoFiltro.textProperty().addListener((observable, oldValue, newValue) -> filtrarTabla());
    }

    private void filtrarTabla() {
        Predicate<Entrada> filtro = entrada -> {
            // Lógica de filtro para cada campo.
            String matricula = txtMatricula.getText();
            String marca = txtMarca.getText();
            String modelo = txtModelo.getText();
            String color = txtColor.getText();
            String registro = txtNumReg.getText();
            String servicio = txtServicio.getText();
            String motivo = txtMotivo.getText();
            String conductor = txtConductor.getText();
            String grua = txtGrua.getText();
            String direccion = txtDireccion.getText();

            // Lógica de filtro para cada campo
            boolean matriculaCoincide = matricula.isEmpty() || entrada.getMatricula().contains(matricula);
            boolean marcaCoincide = marca.isEmpty() || (entrada != null && entrada.getMarca() != null && entrada.getMarca().contains(marca));
            boolean modeloCoincide = modelo.isEmpty() || (entrada != null && entrada.getModelo() != null && entrada.getModelo().contains(modelo));
            boolean colorCoincide = color.isEmpty() || (entrada != null && entrada.getColor() != null && entrada.getColor().contains(color));
            boolean numRegCoincide = registro.isEmpty() || (entrada != null && entrada.getIdEntrada() != null && entrada.getIdEntrada().contains(registro));
            boolean servicioCoincide = servicio.isEmpty() || (entrada != null && entrada.getServicio() != null && entrada.getServicio().contains(servicio));
            boolean motivoCoincide = motivo.isEmpty() || (entrada != null && entrada.getMotivo() != null && entrada.getMotivo().contains(motivo));
            boolean conductorCoincide = conductor.isEmpty() || (entrada != null && entrada.getConductor() != null && entrada.getConductor().contains(conductor));
            boolean gruaCoincide = grua.isEmpty() || (entrada != null && entrada.getGrua() != null && entrada.getGrua().contains(grua));
            boolean direccionCoincide = direccion.isEmpty() || (entrada != null && entrada.getDireccion() != null && entrada.getDireccion().contains(direccion));

            LocalDate fechaEntrada = LocalDate.parse(entrada.getDiaEntrada());
            boolean fechaInicioCoincide = fechaInicioFiltro == null || fechaEntrada.isEqual(fechaInicioFiltro) || fechaEntrada.isAfter(fechaInicioFiltro);
            boolean fechaFinCoincide = fechaFinFiltro == null || fechaEntrada.isEqual(fechaFinFiltro) || fechaEntrada.isBefore(fechaFinFiltro.plusDays(1));

            // Combina todas las condiciones con un operador lógico &&
            return matriculaCoincide && marcaCoincide && fechaInicioCoincide && fechaFinCoincide && modeloCoincide && colorCoincide && numRegCoincide && servicioCoincide && motivoCoincide && conductorCoincide && gruaCoincide && direccionCoincide;
        };

        tablaEntradas.setItems(listaEntradas.filtered(filtro));
    }

    private void cargarDatosDesdeBaseDeDatos() {
        try (Connection conexión = DriverManager.getConnection("jdbc:mysql://localhost:3306/entradas_bd", "admin", ",.Manudev,.77");
             PreparedStatement consulta = conexión.prepareStatement("SELECT * FROM entradas");
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
                        resultado.getString("diaEntrada"),
                        resultado.getString("diaSalida")
                );

                listaEntradas.add(entrada);
            }
        } catch (Exception e) {
            e.printStackTrace();
        }

        tablaEntradas.setItems(listaEntradas);
    }
    
    
    @FXML
    private void limpiarCampos() {
    txtMatricula.setText("");
    txtMarca.setText("");
    txtModelo.setText("");
    txtColor.setText("");
    txtNumReg.setText("");
    txtServicio.setText("");
    txtMotivo.setText("");
    txtConductor.setText("");
    txtDireccion.setText("");
    txtGrua.setText("");
    dpFechaInicio.setValue(null);
    dpFechaFin.setValue(null);
    // Limpia los demás campos de filtro si los tienes
}
    @FXML
    private void filtrarDeposito() {
    Predicate<Entrada> filtro = entrada -> {
        boolean estaSeleccionado = tbDeposito.isSelected();

        // Si el ToggleButton está seleccionado, muestra solo entradas con día de salida en blanco
        if (estaSeleccionado) {
            String diaSalida = entrada.getDiaSalida();
            return diaSalida == null || diaSalida.isEmpty();
        } else {
            // Si el ToggleButton no está seleccionado, muestra todas las entradas
            return true;
        }
    };

    tablaEntradas.setItems(listaEntradas.filtered(filtro));
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

            Stage myStage = (Stage) btnVolver.getScene().getWindow();
            myStage.close();

        } catch (IOException ex) {
            Logger.getLogger(MenuController.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
}
