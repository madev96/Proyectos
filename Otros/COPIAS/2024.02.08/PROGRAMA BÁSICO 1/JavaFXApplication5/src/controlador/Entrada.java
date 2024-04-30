package controlador;

import javafx.beans.property.SimpleStringProperty;
import javafx.beans.property.StringProperty;

public class Entrada {
    private final StringProperty idEntrada;
    private final StringProperty matricula;
    private final StringProperty marca;
    private final StringProperty modelo;
    private final StringProperty color;
    private final StringProperty estado;
    private final StringProperty tipoDeVehiculo;
    private final StringProperty numeroPolicia;
    private final StringProperty servicio;
    private final StringProperty motivo;
    private final StringProperty conductor;
    private final StringProperty grua;
    private final StringProperty usuario;
    private final StringProperty comentarios;
    private final StringProperty diaRetirada;
    private final StringProperty direccion;
    private final StringProperty diaEntrada;


    public Entrada(
            String idEntrada, String matricula, String marca, String modelo, String color, String estado, String tipoDeVehiculo, String numeroPolicia, String servicio, String motivo, String conductor, String grua, String usuario, String comentarios, String diaRetirada, String direccion, String diaEntrada) {
        this.idEntrada = new SimpleStringProperty(idEntrada);
        this.matricula = new SimpleStringProperty(matricula);
        this.marca = new SimpleStringProperty(marca);
        this.modelo = new SimpleStringProperty(modelo);
        this.color = new SimpleStringProperty(color);
        this.estado = new SimpleStringProperty(estado);
        this.tipoDeVehiculo = new SimpleStringProperty(tipoDeVehiculo);
        this.numeroPolicia = new SimpleStringProperty(numeroPolicia);
        this.servicio = new SimpleStringProperty(servicio);
        this.motivo = new SimpleStringProperty(motivo);
        this.conductor = new SimpleStringProperty(conductor);
        this.grua = new SimpleStringProperty(grua);
        this.usuario = new SimpleStringProperty(usuario);
        this.comentarios = new SimpleStringProperty(comentarios);
        this.diaRetirada = new SimpleStringProperty(diaRetirada);
        this.direccion = new SimpleStringProperty(direccion);
        this.diaEntrada = new SimpleStringProperty(diaEntrada);
      

    }
    

    // Métodos getter para cada propiedad
    public String getIdEntrada() {
        return idEntrada.get();
    }

    public String getMatricula() {
        return matricula.get();
    }

    public String getMarca() {
        return marca.get();
    }

    public String getModelo() {
        return modelo.get();
    }

    public String getColor() {
        return color.get();
    }

    public String getEstado() {
        return estado.get();
    }

    public String getTipoDeVehiculo() {
        return tipoDeVehiculo.get();
    }

    public String getNumeroPolicia() {
        return numeroPolicia.get();
    }

    public String getServicio() {
        return servicio.get();
    }

    public String getMotivo() {
        return motivo.get();
    }

    public String getConductor() {
        return conductor.get();
    }

    public String getGrua() {
        return grua.get();
    }

    public String getUsuario() {
        return usuario.get();
    }

    public String getComentarios() {
        return comentarios.get();
    }

    public String getDiaRetirada() {
        return diaRetirada.get();
    }

    public String getDireccion() {
        return direccion.get();
    }

    public String getDiaEntrada() {
        return diaEntrada.get();
    }

    
    
    
    
}
