<fieldset>
  <legend>
    Carga masiva de conductores
  </legend>
</fieldset>
<form action="index.php?router=load-conductores" method="post" enctype="multipart/form-data">
  <div class="row">
    <div class="col-md-12">
      <div class="form-group">
        <label for="lConductor"></label>
        <input type="file" class="form-control-file" name="lConductor" id="lConductor" accept="text/csv" required  />
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">Cargar</button>
      </div>
    </div>
  </div>
</form>