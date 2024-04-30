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
    private final StringProperty diaParte;
    private final StringProperty horaParte;
    private final StringProperty minParte;

    public Parte(String idConductor, String idGrua, String idTurno, String fechaYHoraApertura, String fechaYHoraCierre,
            String idCodigo, String estado, String diaParte, String horaParte, String minParte) {
        this.idConductor = new SimpleStringProperty(idConductor);
        this.idGrua = new SimpleStringProperty(idGrua);
        this.idTurno = new SimpleStringProperty(idTurno);
        this.fechaYHoraApertura = new SimpleStringProperty(fechaYHoraApertura);
        this.fechaYHoraCierre = new SimpleStringProperty(fechaYHoraCierre);
        this.idCodigo = new SimpleStringProperty(idCodigo);
        this.estado = new SimpleStringProperty(estado);
        this.diaParte = new SimpleStringProperty(diaParte);
        this.horaParte = new SimpleStringProperty(horaParte);
        this.minParte = new SimpleStringProperty(minParte);
    }

    Parte(String string, String string0, String string1, String string2, String string3, String string4, String string5) {
        throw new UnsupportedOperationException("Not supported yet."); // Generated from nbfs://nbhost/SystemFileSystem/Templates/Classes/Code/GeneratedMethodBody
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

    public String getDiaParte() {
        return diaParte.get();
    }

    public String getHoraParte() {
        return horaParte.get();
    }

    public String getMinParte() {
        return minParte.get();
    }

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

    public StringProperty diaParteProperty() {
        return diaParte;
    }

    public StringProperty horaParteProperty() {
        return horaParte;
    }

    public StringProperty minParteProperty() {
        return minParte;
    }
}
