package controlador;

import javafx.beans.property.SimpleStringProperty;
import javafx.beans.property.StringProperty;

public class Parte {
    private final StringProperty idConductor;
    private final StringProperty idGrua;
    private final StringProperty idTurno;
    private final StringProperty fechaYHoraApertura;
    private final StringProperty fechaYHoraCierre;
    private final StringProperty idCodigo;
    private final StringProperty estado;

    public Parte(String idConductor, String idGrua, String idTurno, String fechaYHoraApertura, String fechaYHoraCierre, String idCodigo, String estado) {
        this.idConductor = new SimpleStringProperty(idConductor);
        this.idGrua = new SimpleStringProperty(idGrua);
        this.idTurno = new SimpleStringProperty(idTurno);
        this.fechaYHoraApertura = new SimpleStringProperty(fechaYHoraApertura);
        this.fechaYHoraCierre = new SimpleStringProperty(fechaYHoraCierre);
        this.idCodigo = new SimpleStringProperty(idCodigo);
        this.estado = new SimpleStringProperty(estado);
    }

    public String getIdConductor() {
        return idConductor.get();
    }

    public String getIdGrua() {
        return idGrua.get();
    }

    public String getIdTurno() {
        return idTurno.get();
    }

    public String getFechaYHoraApertura() {
        return fechaYHoraApertura.get();
    }

    public String getFechaYHoraCierre() {
        return fechaYHoraCierre.get();
    }

    public String getIdCodigo() {
        return idCodigo.get();
    }

    public String getEstado() {
        return estado.get();
    }

    // Otros métodos getter para las propiedades StringProperty



    public StringProperty idConductorProperty() {
        return idConductor;
    }

    public StringProperty idGruaProperty() {
        return idGrua;
    }

    public StringProperty idTurnoProperty() {
        return idTurno;
    }

    public StringProperty fechaYHoraAperturaProperty() {
        return fechaYHoraApertura;
    }

    public StringProperty fechaYHoraCierreProperty() {
        return fechaYHoraCierre;
    }

    public StringProperty idCodigoProperty() {
        return idCodigo;
    }

  
}


