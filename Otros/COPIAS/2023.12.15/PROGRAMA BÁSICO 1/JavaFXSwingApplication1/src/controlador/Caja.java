/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package controlador;

import javafx.beans.property.SimpleStringProperty;
import javafx.beans.property.StringProperty;



public class Caja {
    private final StringProperty usuario;
    private final StringProperty turno;
    private final StringProperty fechaDeApertura;
    private final StringProperty fechaDeCierre;

    public Caja(String usuario, String turno, String fechaDeApertura, String fechaDeCierre) {
        this.usuario = new SimpleStringProperty(usuario);
        this.turno = new SimpleStringProperty(turno);
        this.fechaDeApertura = new SimpleStringProperty(fechaDeApertura);
        this.fechaDeCierre = new SimpleStringProperty(fechaDeCierre);
    }

    public StringProperty getUsuarioProperty() {
        return usuario;
    }

    public StringProperty getTurnoProperty() {
        return turno;
    }

    public StringProperty getFechaDeAperturaProperty() {
        return fechaDeApertura;
    }

    public StringProperty getFechaDeCierreProperty() {
        return fechaDeCierre;
    }
    
}
