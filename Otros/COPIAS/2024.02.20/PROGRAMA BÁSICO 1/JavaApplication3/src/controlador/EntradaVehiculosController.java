/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/javafx/FXMLController.java to edit this template
 */
package controlador;


import java.io.IOException;
import java.net.URL;
import java.time.LocalDate;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.DatePicker;
import javafx.stage.Stage;

public class EntradaVehiculosController implements Initializable {

    @FXML
    private Button btnVolver;
     @FXML
    private DatePicker dtpDiaRetirada;

    /** 
     * Initializes the controller class.
     * @param url
     * 
     * @param rb
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
 dtpDiaRetirada.setValue(LocalDate.now());
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