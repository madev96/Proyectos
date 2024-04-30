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
import java.sql.SQLException;
import java.text.SimpleDateFormat;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.stage.Stage;

public class MenuController implements Initializable {

    @FXML
    private Button btnIntroducir;
    @FXML
    private Button btnConsultar;
    @FXML
    private Button btnACaja;
     @FXML
    private Button btnCCaja;
    @FXML
    private Button btnSalida;
   
    @FXML
    private Button btnConsultarPartes;
    @FXML
    private Button btnTodosPartes;
    @FXML
    private Button btnConsultarCajas;
    @FXML
    private Button cerrarParte;
    @FXML
    private Label lTurnoEmpezado; 
    @FXML
    private Button btnConsultarFacturas;
   

    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
                obtenerFechaMasReciente();

    }
 private void obtenerFechaMasReciente() {
        try {
            // Establecer la conexión a la base de datos (asegúrate de tener el controlador JDBC y la URL de conexión correctos).
            Connection connection = DriverManager.getConnection("jdbc:mysql://localhost:3306/cajas_bd", "admin", ",.Manudev,.77");

            // Consulta SQL para obtener la fecha más reciente en la columna fechaDeApertura de la tabla cajas
            String query = "SELECT MAX(fechaDeApertura) AS fechaReciente FROM cajas";
            PreparedStatement statement = connection.prepareStatement(query);
            ResultSet resultSet = statement.executeQuery();

           if (resultSet.next()) {
            // Obtener la fecha más reciente
            java.sql.Timestamp timestamp = resultSet.getTimestamp("fechaReciente");

            // Crear un formato personalizado para mostrar la fecha y hora
            SimpleDateFormat sdf = new SimpleDateFormat("HH:mm dd/MM/yyyy");

            // Formatear la fecha y hora y configurarla en el label
            String fechaFormateada = sdf.format(timestamp);
            lTurnoEmpezado.setText(fechaFormateada);
        }


            // Cerrar conexiones
            resultSet.close();
            statement.close();
            connection.close();
        } catch (SQLException ex) {
            ex.printStackTrace();
            // Maneja cualquier excepción aquí
        }
    }
    
    
    @FXML
    private void insertarServicios(ActionEvent event) {

        try {
            // Cargo la vista
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/vista/EntradaVehiculosVista.fxml"));

            // Cargo el padre
            Parent root = loader.load();

            // Obtengo el controlador(hay qye cambiarlO)
            EntradaVehiculosController controlador = loader.getController();

            // Creo la scene y el stage
            Scene scene = new Scene(root);
            Stage stage = new Stage();

            // Asocio el stage con el scene
            stage.setScene(scene);
            stage.show();

            // Indico que debe hacer al cerrar
            stage.setOnCloseRequest(e -> controlador.closeWindows());

            // Ciero la ventana donde estoy
            Stage myStage = (Stage) this.btnIntroducir.getScene().getWindow();
            myStage.close();

        } catch (IOException ex) {
            Logger.getLogger(MenuController.class.getName()).log(Level.SEVERE, null, ex);
        }

    }
    
    @FXML
    private void consultarFacturas(ActionEvent event) {

        try {
            // Cargo la vista
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/vista/ConsultarFacturasVista.fxml"));

            // Cargo el padre
            Parent root = loader.load();

            // Obtengo el controlador(hay qye cambiarlO)
            ConsultarFacturasController controlador = loader.getController();

            // Creo la scene y el stage
            Scene scene = new Scene(root);
            Stage stage = new Stage();

            // Asocio el stage con el scene
            stage.setScene(scene);
            stage.show();

            // Indico que debe hacer al cerrar
            stage.setOnCloseRequest(e -> controlador.closeWindows());

            // Ciero la ventana donde estoy
            Stage myStage = (Stage) this.btnConsultarFacturas.getScene().getWindow();
            myStage.close();

        } catch (IOException ex) {
            Logger.getLogger(MenuController.class.getName()).log(Level.SEVERE, null, ex);
        }

    }
    
    
    @FXML
    private void ConsultarCajas(ActionEvent event) {

        try {
            // Cargo la vista
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/vista/ConsultarCajasVista.fxml"));

            // Cargo el padre
            Parent root = loader.load();

            // Obtengo el controlador(hay qye cambiarlO)
            ConsultarCajasController controlador = loader.getController();

            // Creo la scene y el stage
            Scene scene = new Scene(root);
            Stage stage = new Stage();

            // Asocio el stage con el scene
            stage.setScene(scene);
            stage.show();

            // Indico que debe hacer al cerrar
            stage.setOnCloseRequest(e -> controlador.closeWindows());

            // Ciero la ventana donde estoy
            Stage myStage = (Stage) this.btnConsultarCajas.getScene().getWindow();
            myStage.close();

        } catch (IOException ex) {
            Logger.getLogger(MenuController.class.getName()).log(Level.SEVERE, null, ex);
        }

    }
    
    
     @FXML
    private void verTodos(ActionEvent event) {

        try {
            // Cargo la vista
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/vista/VerTodosPartesVista.fxml"));

            // Cargo el padre
            Parent root = loader.load();

            // Obtengo el controlador(hay qye cambiarlO)
            VerTodosPartesController controlador = loader.getController();

            // Creo la scene y el stage
            Scene scene = new Scene(root);
            Stage stage = new Stage();

            // Asocio el stage con el scene
            stage.setScene(scene);
            stage.show();

            // Indico que debe hacer al cerrar
            stage.setOnCloseRequest(e -> controlador.closeWindows());

            // Ciero la ventana donde estoy
            Stage myStage = (Stage) this.btnTodosPartes.getScene().getWindow();
            myStage.close();

        } catch (IOException ex) {
            Logger.getLogger(MenuController.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    
    
       @FXML
    private void cerrarParte(ActionEvent event) {

        try {
            // Cargo la vista
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/vista/CerrarPartesVista.fxml"));

            // Cargo el padre
            Parent root = loader.load();

            // Obtengo el controlador(hay qye cambiarlO)
            CerrarPartesController controlador = loader.getController();

            // Creo la scene y el stage
            Scene scene = new Scene(root);
            Stage stage = new Stage();

            // Asocio el stage con el scene
            stage.setScene(scene);
            stage.show();

            // Indico que debe hacer al cerrar
            stage.setOnCloseRequest(e -> controlador.closeWindows());

            // Ciero la ventana donde estoy
            Stage myStage = (Stage) this.btnTodosPartes.getScene().getWindow();
            myStage.close();

        } catch (IOException ex) {
            Logger.getLogger(MenuController.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    
    @FXML
    private void salidaDeServicios(ActionEvent event) {

        try {
            // Cargo la vista
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/vista/SalidaVehiculosVista.fxml"));

            // Cargo el padre
            Parent root = loader.load();

            // Obtengo el controlador(hay qye cambiarlO)
            SalidaVehiculosController controlador = loader.getController();

            // Creo la scene y el stage
            Scene scene = new Scene(root);
            Stage stage = new Stage();

            // Asocio el stage con el scene
            stage.setScene(scene);
            stage.show();

            // Indico que debe hacer al cerrar
            stage.setOnCloseRequest(e -> controlador.closeWindows());

            // Ciero la ventana donde estoy
            Stage myStage = (Stage) this.btnSalida.getScene().getWindow();
            myStage.close();

        } catch (IOException ex) {
            Logger.getLogger(MenuController.class.getName()).log(Level.SEVERE, null, ex);
        }

    }

    @FXML
    private void consultarServicios(ActionEvent event) {

        try {
            // Cargo la vista
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/vista/ConsultarServiciosVista.fxml"));

            // Cargo el padre
            Parent root = loader.load();

            // Obtengo el controlador(hay qye cambiarlO)
            ConsultarServiciosController controlador = loader.getController();

            // Creo la scene y el stage
            Scene scene = new Scene(root);
            Stage stage = new Stage();

            // Asocio el stage con el scene
            stage.setScene(scene);
            stage.show();

            // Indico que debe hacer al cerrar
            stage.setOnCloseRequest(e -> controlador.closeWindows());

            // Ciero la ventana donde estoy
            Stage myStage = (Stage) this.btnConsultar.getScene().getWindow();
            myStage.close();

        } catch (IOException ex) {
            Logger.getLogger(MenuController.class.getName()).log(Level.SEVERE, null, ex);
        }

    }
    
    
    
    @FXML
    private void abrirCaja(ActionEvent event) {

        try {
            // Cargo la vista
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/vista/FormularioAbrirParteVista.fxml"));

            // Cargo el padre
            Parent root = loader.load();

            // Obtengo el controlador
            FormularioAbrirParteController controlador = loader.getController();

            // Creo la scene y el stage
            Scene scene = new Scene(root);
            Stage stage = new Stage();

            // Asocio el stage con el scene
            stage.setScene(scene);
            stage.show();

            // Indico que debe hacer al cerrar
            stage.setOnCloseRequest(e -> controlador.closeWindows());

            // Ciero la ventana donde estoy
            Stage myStage = (Stage) this.btnACaja.getScene().getWindow();
            myStage.close();

        } catch (IOException ex) {
            Logger.getLogger(MenuController.class.getName()).log(Level.SEVERE, null, ex);
        }

    }
    
    @FXML
    private void cerrarCaja(ActionEvent event) {

        try {
            // Cargo la vista
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/vista/CerrarCajaVista.fxml"));

            // Cargo el padre
            Parent root = loader.load();

            // Obtengo el controlador
            CerrarCajaController controlador = loader.getController();

            // Creo la scene y el stage
            Scene scene = new Scene(root);
            Stage stage = new Stage();

            // Asocio el stage con el scene
            stage.setScene(scene);
            stage.show();

            // Indico que debe hacer al cerrar
            stage.setOnCloseRequest(e -> controlador.closeWindows());

            // Ciero la ventana donde estoy
            Stage myStage = (Stage) this.btnCCaja.getScene().getWindow();
            myStage.close();

        } catch (IOException ex) {
            Logger.getLogger(MenuController.class.getName()).log(Level.SEVERE, null, ex);
        }

    }
     @FXML
    private void consultarParte(ActionEvent event) {

        try {
            // Cargo la vista
            FXMLLoader loader = new FXMLLoader(getClass().getResource("/vista/ConsultarPartesVista.fxml"));

            // Cargo el padre
            Parent root = loader.load();

            // Obtengo el controlador(hay qye cambiarlO)
            ConsultarPartesController controlador = loader.getController();

            // Creo la scene y el stage
            Scene scene = new Scene(root);
            Stage stage = new Stage();

            // Asocio el stage con el scene
            stage.setScene(scene);
            stage.show();

            // Indico que debe hacer al cerrar
            stage.setOnCloseRequest(e -> controlador.closeWindows());

            // Ciero la ventana donde estoy
            Stage myStage = (Stage) this.btnConsultarPartes.getScene().getWindow();
            myStage.close();

        } catch (IOException ex) {
            Logger.getLogger(MenuController.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
}