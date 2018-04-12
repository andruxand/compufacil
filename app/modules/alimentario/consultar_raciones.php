<?php

?>

    <div class="container-fluid">

        <!-- Bloque para cuando se haya seleccionado la ruta y el operador -->
        <div class="card border-dark-blue">
            <div class="card-header-dark-blue">
                CONSULTAR ALIMENTACIÓN
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <form action="" class="form-row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="ruta"><strong>Nombre de Ruta</strong></label>
                                <input type="search" class="form-control" id="ruta" placeholder="Nombre de la Ruta" 
                                       name="ruta"/>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="mb-2 mr-sm-2" for="institucion"><strong>Operador</strong></label>
                                <input type="search" class="form-control" id="institucion" placeholder="Nombre de la Institución" 
                                       name="institucion"/>
                            </div>  
                        </div> 
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-dark-blue mb-2">
                                <span class="oi oi-magnifying-glass text-blue" title="icon name" aria-hidden="true"></span>
                                Buscar
                            </button>
                        </div>        

                    </form>
                </div>
            </div>
        </div>
        <!-- Fin Bloque -->

        <hr>

        <div class="col-md-12 text-right">
            <button type="submit" class="btn btn-dark-blue mb-2">
                <span class="oi oi-plus text-blue" title="icon name" aria-hidden="true"></span>
                Registrar Raciones
            </button>
            <button type="submit" class="btn btn-dark-blue mb-2">
                <span class="oi oi-magnifying-glass text-blue" title="icon name" aria-hidden="true"></span>
                Consultar
            </button>
            <button type="submit" class="btn btn-dark-blue mb-2" data-dismiss="modal" aria-label="Close">
                <span class="oi oi-account-logout text-blue" title="icon name" aria-hidden="true"></span>
                Salir
            </button>
        </div>

    </div>  