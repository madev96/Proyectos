package controlador;

import java.io.IOException;
import java.net.URL;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Date;
import java.sql.Time;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.GregorianCalendar;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.ComboBox;
import javafx.scene.control.Label;
import javafx.scene.control.TextField;
import javafx.stage.Stage;

public class SalidaVehiculosController implements Initializable {

    @FXML
    private Button btnVolver;
    @FXML
    private Button btnDarSalida;
    @FXML
    private ComboBox<String> cbMatricula;
    // Cambié el tipo de ComboBox a <String> para contener matrículas.
    @FXML
    private TextField tfTipo;
    @FXML
    private TextField tfMarca;
    @FXML
    private TextField tfModelo;
    @FXML
    private TextField tfColor;
    @FXML
    private TextField tfServicio;
    @FXML
    private TextField tfMotivo;
    @FXML
    private TextField tfFechaDeEntrada;
    @FXML
    private TextField tfDireccionDeRetirada;
    @FXML
    private TextField tfPlaza;
    @FXML
    private TextField tfComentarios;
    @FXML
    private Label tfFechaDeSalida;
    @FXML
    private Label lNReg;
    @FXML
    private Label lNumFact;
    @FXML
    private Label lblPrecio;
@FXML
private TextField tfDNI;
@FXML
private TextField tfPrecio;
@FXML
private TextField tfNombre;
@FXML
private TextField tfApellidos;
@FXML
private TextField tfDireccionCliente;
@FXML
private TextField tfLocalidad;
@FXML
private TextField tfProvincia;
@FXML
private TextField tfNumOp;
@FXML
private TextField tfcodigoPostal;
@FXML
private ComboBox<String> cbFormaPago;
    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        cargarMatriculas(); // Llama a esta función en la inicialización.

        // Obtener la fecha y hora actual
        Calendar calendar = new GregorianCalendar();
        SimpleDateFormat sdf = new SimpleDateFormat("d, MMMM yyyy HH:mm"); // Formato de fecha y hora
        String fechaHoraActual = sdf.format(calendar.getTime());

        // Mostrar la fecha y hora actual en el campo tfFechaDeEntrada
        tfFechaDeSalida.setText(fechaHoraActual);
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

    // Función para cargar matrículas desde la base de datos.
    private void cargarMatriculas() {
        try {
            // Conectar a la base de datos (asegúrate de tener el controlador JDBC y la URL de conexión correctos).
            Connection connection = DriverManager.getConnection("jdbc:mysql://localhost:3306/entradas_bd", "admin", ",.Manudev,.77");

            // Consulta SQL para obtener matrículas.
            String query = "SELECT matricula FROM entradas";
            PreparedStatement statement = connection.prepareStatement(query);
            ResultSet resultSet = statement.executeQuery();

            // Llena el ComboBox con las matrículas.
            while (resultSet.next()) {
                String matricula = resultSet.getString("matricula");
                cbMatricula.getItems().add(matricula);
            }

            // Cierra las conexiones.
            resultSet.close();
            statement.close();
            connection.close();
        } catch (SQLException ex) {
            Logger.getLogger(SalidaVehiculosController.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    
    @FXML
private void btnDarSalida() {
    // Obtener los valores de los campos del formulario
    String dni = tfDNI.getText();
    String nombre = tfNombre.getText();
    String apellidos = tfApellidos.getText();
    String direccion = tfDireccionCliente.getText();
    String localidad = tfLocalidad.getText();
    String provincia = tfProvincia.getText();
    String codigoPostal = tfcodigoPostal.getText();
    String numeroDeOperacion = tfNumOp.getText();
    String idEntrada = lNReg.getText(); // Obtener el ID de entrada del campo lNReg
    String fechaSalida = tfFechaDeSalida.getText();
    String precio = tfPrecio.getText();

    // Realizar la inserción en la tabla de salidas
    try {
        // Conectar a la base de datos (asegúrate de tener el controlador JDBC y la URL de conexión correctos).
        Connection connection = DriverManager.getConnection("jdbc:mysql://localhost:3306/salidas_bd", "admin", ",.Manudev,.77");

        // Consulta SQL para insertar datos en la tabla salidas
        String query = "INSERT INTO salidas (dni, nombre, apellidos, direccion, localidad, provincia, codigoPostal, precio, precioSinIVA, precioIVA, numeroDeOperacion, idEntrada, fechaSalida) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        PreparedStatement statement = connection.prepareStatement(query);
        statement.setString(1, dni);
        statement.setString(2, nombre);
        statement.setString(3, apellidos);
        statement.setString(4, direccion);
        statement.setString(5, localidad);
        statement.setString(6, provincia);
        statement.setString(7, codigoPostal);
        statement.setString(8, precio);        // Debes calcular precioSinIVA y precioIVA y asignarlos aquí.
        statement.setString(9,""); // Debes calcular precioSinIVA y asignarlo aquí.
        statement.setString(10, ""); // Debes calcular precioIVA y asignarlo aquí.
        statement.setString(11, fechaSalida); 
        statement.setString(12, numeroDeOperacion);
        statement.setString(13, idEntrada);
     
        // Ejecutar la inserción
        int rowsInserted = statement.executeUpdate();
        if (rowsInserted > 0) {
            System.out.println("Inserción exitosa en la tabla salidas.");
        } else {
            System.out.println("No se pudo insertar en la tabla salidas.");
        }

        // Cierra las conexiones.
        statement.close();
        connection.close();
    } catch (SQLException ex) {
        Logger.getLogger(SalidaVehiculosController.class.getName()).log(Level.SEVERE, null, ex);
    }
}

    
    @FXML
    private void seleccionarMatricula() {
        // Obtener la matrícula seleccionada
        String matriculaSeleccionada = cbMatricula.getValue();

        // Verificar que se ha seleccionado una matrícula
        if (matriculaSeleccionada != null) {
            try {
                // Conectar a la base de datos (asegúrate de tener el controlador JDBC y la URL de conexión correctos).
                Connection connection = DriverManager.getConnection("jdbc:mysql://localhost:3306/entradas_bd", "admin", ",.Manudev,.77");

                // Consulta SQL para obtener los datos asociados a la matrícula seleccionada
                String query = "SELECT idEntrada, tipoDeVehiculo, marca, modelo, color, servicio, motivo, diaEntrada, horaEntrada, direccion, plaza, comentarios, direccion FROM entradas WHERE matricula = ?";
                PreparedStatement statement = connection.prepareStatement(query);
                statement.setString(1, matriculaSeleccionada);
                ResultSet resultSet = statement.executeQuery();

                // Verificar si se encontraron datos
                if (resultSet.next()) {
                    // Obtener los datos de la consulta
                    String tipo = resultSet.getString("tipoDeVehiculo");
                    String marca = resultSet.getString("marca");
                    String modelo = resultSet.getString("modelo");
                    String color = resultSet.getString("color");
                    String servicio = resultSet.getString("servicio");
                    String motivo = resultSet.getString("motivo");
                    Date fechaEntrada = resultSet.getDate("diaEntrada");
                    Time horaEntrada = resultSet.getTime("horaEntrada");
                    String plaza = resultSet.getString("plaza");
                    String comentarios = resultSet.getString("comentarios");
                    String direccionDeRetirada = resultSet.getString("direccion");
                    int idEntrada = resultSet.getInt("idEntrada");
    int siguienteIdSalidas = obtenerSiguienteIdSalidas();

                    // Formatear la fecha como "día, mes, año"
                    SimpleDateFormat sdfFecha = new SimpleDateFormat("d, MMMM yyyy");
                    String fechaFormateada = sdfFecha.format(fechaEntrada);

                    // Formatear la hora en formato de 24 horas
                    SimpleDateFormat sdfHora = new SimpleDateFormat("HH:mm"); // HH representa horas en formato de 24 horas
                    String horaFormateada = sdfHora.format(horaEntrada);

                    // Combinar la fecha y la hora formateadas
                    String fechaYHora = fechaFormateada + " a las " + horaFormateada;

                    // Mostrar y actualizar los campos
                    tfTipo.setText(tipo);
                    tfMarca.setText(marca);
                    tfModelo.setText(modelo);
                    tfColor.setText(color);
                    tfServicio.setText(servicio);
                    tfMotivo.setText(motivo);
                    tfDireccionDeRetirada.setText(direccionDeRetirada);
                    tfFechaDeEntrada.setText(fechaYHora); // Mostrar la fecha y hora formateadas
                    tfPlaza.setText(plaza);
                    tfComentarios.setText(comentarios);
                    lNReg.setText(String.valueOf(idEntrada)); // AQÍ TENGO QUE AÑADIR AL FINAL + /23 CON UNA FÓRMULA.
                            lNumFact.setText(String.valueOf(siguienteIdSalidas));

                    // Calcular y mostrar el precio
                    double precio = calcularPrecio(fechaEntrada, horaEntrada);
                    tfPrecio.setText(String.format("%.2f €", precio));
                }

                // Cierra las conexiones.
                resultSet.close();
                statement.close();
                connection.close();
            } catch (SQLException ex) {
                Logger.getLogger(SalidaVehiculosController.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }

    // Función para calcular el precio en función de la fecha de entrada y la fecha de salida
    private double calcularPrecio(Date fechaEntrada, Time horaEntrada) {
        // Aquí debes implementar tu lógica para calcular el precio
        // Puedes utilizar la fecha y hora de entrada y salida para realizar los cálculos necesarios
        // Por ejemplo, puedes calcular la diferencia de tiempo y aplicar tarifas según ciertas condiciones
        // El resultado debe ser el precio a mostrar en el campo tfPrecio
        // Por ahora, simplemente devolveremos un valor de ejemplo (1000.0) como demostración.
        return 1000.0;
    }
    private int obtenerSiguienteIdSalidas() {
    int siguienteIdSalidas = 0;

    try {
        // Conectar a la base de datos (asegúrate de tener el controlador JDBC y la URL de conexión correctos).
        Connection connection = DriverManager.getConnection("jdbc:mysql://localhost:3306/salidas_bd", "admin", ",.Manudev,.77");

        // Consulta SQL para obtener el último valor de idsalidas en la tabla salidas
        String query = "SELECT MAX(idsalidas) AS max_idsalidas FROM salidas";
        PreparedStatement statement = connection.prepareStatement(query);
        ResultSet resultSet = statement.executeQuery();

        // Obtener el siguiente valor de idsalidas
        if (resultSet.next()) {
            siguienteIdSalidas = resultSet.getInt("max_idsalidas") + 1;
        }

        // Cierra las conexiones.
        resultSet.close();
        statement.close();
        connection.close();
    } catch (SQLException ex) {
        Logger.getLogger(SalidaVehiculosController.class.getName()).log(Level.SEVERE, null, ex);
    }

    return siguienteIdSalidas;
}

}
