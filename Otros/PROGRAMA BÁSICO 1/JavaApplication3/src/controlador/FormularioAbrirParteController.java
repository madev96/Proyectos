/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/javafx/FXMLController.java to edit this template
 */
package controlador;
import java.io.IOException;
import java.net.URL;
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
import javafx.stage.Stage;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;



/**
 * FXML Controller class
 *
 * @author 996ma
 */


public class FormularioAbrirParteController implements Initializable {
    
        @FXML
        private ComboBox nombreConductor;
        @FXML
        private ComboBox grua;
        @FXML
        private ComboBox turno;
        @FXML
        private Button btnNo;
        
        
        String url = "jdbc:mysql://localhost:3306/partes_bd";
        String usuario = "root";
        String contraseña = "";
    
      
    
    
    ObservableList<String> conductoresLista = FXCollections.observableArrayList("Sin conductor", "Alex", "Andrei", "Antonio",  "Cipri", "Gabi", "Javi", "Jesús", "Juanjo", "Manu","Marius","Rober");
    ObservableList<String> gruaLista = FXCollections.observableArrayList("Sin grúa","03", "44", "59");
    ObservableList<String> turnoLista = FXCollections.observableArrayList("Sin turno","Mañana", "Tarde", "Noche", "Mañana-Tarde", "Tarde-Noche");
    



    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
        //Para poner los títulos de los desplegables.
        nombreConductor.setItems(conductoresLista);
        grua.setItems(gruaLista);
        turno.setItems(turnoLista);


        //Para que me salgan por defecto        
        turno.setValue("Sin turno");
        nombreConductor.setValue("Sin conductor");
        grua.setValue("Sin grúa");
     
    }
    //guardar datos en mysql
     public void guardarDatos() {
      
        String idConductor = nombreConductor.getValue().toString();
        String idGrua = grua.getValue().toString();
        String idTurno = turno.getValue().toString();
        
         // Obtener la fecha y hora actual
        LocalDateTime fechaHoraActual = LocalDateTime.now();
        // Formatear la fecha y hora actual como una cadena
        String fechaHoraActualStr = fechaHoraActual.format(DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:ss"));

        try (Connection conexión = DriverManager.getConnection(url, usuario, contraseña)) {
            String sql = "INSERT INTO Partes (idConductor, idGrua, idTurno, FechaYHoraApertura) VALUES (?, ?, ?,?)";
            PreparedStatement declaración = conexión.prepareStatement(sql);

            // Aquí deberías asegurarte de que las columnas en la tabla Partes sean de tipo VARCHAR
            declaración.setString(1, idConductor);
            declaración.setString(2, idGrua);
            declaración.setString(3, idTurno);
            declaración.setString(4, fechaHoraActualStr);

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
