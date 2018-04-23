<form action="">
  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <label for="">Tipo de Documento</label>
        <select class="form-control" name="tipoDocumento" id="">
          <option value="1">Tarjeta de Identidad</option>
          <option value="2">Cedula de ciudadania</option>
          <option value="3">Otro</option>
        </select>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="">Documento</label>
        <input type="number" class="form-control" name="document"/>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="">Primer Apellido</label>
        <input type="text" class="form-control" name="primerApellido"/>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="">Segundo Apellido</label>
        <input type="text" class="form-control" name="segundoApellido"/>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <label for="">Primer Nombre</label>
        <input type="text" class="form-control" name="primerNombre"/>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="">Segundo Nombre</label>
        <input type="text" class="form-control" name="SegundoNombre"/>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="">Dirección de Residencia</label>
        <input type="text" class="form-control" name="direccionResidencia"/>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="">No. de Celular</label>
        <input type="text" class="form-control" name="numCelular"/>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
      <div class="form-group">
        <label for="">Jornada</label>
        <select class="form-control" name="jornada" id="">
          <option value="1">Mañana</option>
          <option value="2">Tarde</option>
        </select>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="">Licencia de conducción No.</label>
        <input type="text" class="form-control" name="licenciaConduccion"/>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="">Categoría Autorizada</label>
        <input type="text" class="form-control" name="categoriaAutorizada"/>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-group">
        <label for="">Fecha Vencimiento Licencia</label>
        <input type="text" class="form-control" name="fechavencilince"/>
      </div>
    </div>
  </div>

  <br>

  <div class="row">
    <div class="col-md-12 text-right">
      <button type="button" class="btn btn-dark-blue">Editar</button>
      <button type="button" class="btn btn-dark-blue">Salir</button>
    </div>
  </div>
</form>