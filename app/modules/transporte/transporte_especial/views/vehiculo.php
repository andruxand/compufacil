<form action="">
  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <label for="">Tipo de vehículo</label>
        <select name="tipoVehiculo" id="" class="form-control">
          <option value="1">Bus</option>
          <option value="2">Carro</option>
        </select>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="">Placa Vehículo</label>
        <input type="text" class="form-control" name="placaVehiculo"/>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="">Marca del Vehículo</label>
        <input type="text" class="form-control" name="marcaVehiculo"/>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="">Fecha Revisión Tecnomecánica</label>
        <input type="date" class="form-control" name="fecharevitecnomec"/>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <label for="">No. Revisión Tecnomecánica</label>
        <input type="number" class="form-control" name="numrevitecnomec"/>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="">Estado del Contrato</label>
        <select class="form-control" name="estadoContrato" id="">
          <option value="1">Activo</option>
          <option value="2">Inactivo</option>
        </select>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="">Fecha Vencimiento SOAT</label>
        <input type="date" class="form-control" name="fechavencisoat"/>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="">No. SOAT</label>
        <input type="text" class="form-control" name="numsoat"/>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <label for="">Número de Pasajeros</label>
        <input type="number" class="form-control" name="numpasajeros"/>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="">Propietario del Vehículo</label>
        <input type="text" class="form-control" name="propietarioVehiculo"/>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="">No. De Contrato</label>
        <input type="text" class="form-control" name="numcontrato"/>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="">No. Tarjeta de Operación</label>
        <input type="text" class="form-control" name="numtarjetaope"/>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <label for="">Seguro Contractual</label>
        <input type="text" class="form-control" name="seguroContractual"/>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="">Seguro Extra Contractual</label>
        <input type="text" class="form-control" name="seguroExtraContractual"/>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="">Tipo de Zona</label>
        <select class="form-control" name="tipoZona" id="">
          <option value="1">Urbana</option>
          <option value="2">Rural</option>
        </select>
      </div>
    </div>
  </div>

  <br>

  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <label for="">No. Contrato</label>

      </div>
    </div>
    <div class="col-md-9">
      <div class="form-group">
        <label for="">Observaciones</label>

      </div>
    </div>
  </div>

  <br>

  <div class="row">
    <div class="col-md-12 text-right">
      <button type="button" class="btn btn-dark-blue">Guardar</button>
      <button type="button" class="btn btn-dark-blue">Salir</button>
    </div>
  </div>
</form>