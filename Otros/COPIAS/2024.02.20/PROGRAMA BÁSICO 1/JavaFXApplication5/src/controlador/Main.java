/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/javafx/FXMain.java to edit this template
 */
package controlador;

import java.io.IOException;
import javafx.application.Application;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.scene.layout.Pane;
import javafx.stage.Stage;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;

/**
 *
 * @author 996ma
 */
public class Main extends Application {

    @Override
    public void start(Stage primaryStage) {

        try {
            FXMLLoader loader = new FXMLLoader();
            loader.setLocation(Main.class.getResource("/vista/MenuVista.fxml"));
            Pane ventana = (Pane) loader.load();

            // Show the scene containing the root layout.
            Scene scene = new Scene(ventana);
            primaryStage.setScene(scene);
            primaryStage.show();
        } catch (IOException e) {
            System.out.println(e.getMessage());
        }
    }

    public static void main(String[] args) {
    launch(args);
    
    try {
        // Registrar la conexión y obtener los driver de la clase.
        Class.forName("com.mysql.cj.jdbc.Driver");
        // Obtener la URL de la base de datos
        String url = "jdbc:mysql://localhost:3306/partes_bd?zeroDateTimeBehavior=CONVERT_TO_NULL";
        // Crear un objeto string de usuario y contraseña de MySQL Server Connection
        String username = "admin";
        String password = ",.Manudev,.77";
        // Crear un objeto Connection para registrar el driver.
        try (Connection conn = DriverManager.getConnection(url, username, password)) {
            // Crear un objeto String de consulta SQL.
            String sql = "SELECT * FROM Partes";
            // Preparar la consulta SQL.
            try (PreparedStatement pst = conn.prepareStatement(sql)) {
                // Obtener el resultado de la consulta SQL
                try (ResultSet rs = pst.executeQuery()) {
                    if (rs.next()) {
                        // Realizar acciones con los datos obtenidos, si es necesario.
                    }
                }
            }
        }
        
    } catch (Exception e) {
        // Manejar excepciones aquí, por ejemplo, mostrar un mensaje de error en la interfaz de usuario.
        System.err.println("Error de conexión a la base de datos: " + e.getMessage());
    }
    
    //48483483
     try {
        // Registrar la conexión y obtener los driver de la clase.
        Class.forName("com.mysql.cj.jdbc.Driver");
        // Obtener la URL de la base de datos
        String url = "jdbc:mysql://localhost:3306/cajas_bd?zeroDateTimeBehavior=CONVERT_TO_NULL";
        // Crear un objeto string de usuario y contraseña de MySQL Server Connection
        String username = "admin";
        String password = ",.Manudev,.77";
        // Crear un objeto Connection para registrar el driver.
        try (Connection conn = DriverManager.getConnection(url, username, password)) {
            // Crear un objeto String de consulta SQL.
            String sql = "SELECT * FROM Cajas";
            // Preparar la consulta SQL.
            try (PreparedStatement pst = conn.prepareStatement(sql)) {
                // Obtener el resultado de la consulta SQL
                try (ResultSet rs = pst.executeQuery()) {
                    if (rs.next()) {
                        // Realizar acciones con los datos obtenidos, si es necesario.
                    }
                }
            }
        }
        
    } catch (Exception e) {
        // Manejar excepciones aquí, por ejemplo, mostrar un mensaje de error en la interfaz de usuario.
        System.err.println("Error de conexión a la base de datos: " + e.getMessage());
    }
    
    
    
    }
}

