<script>
    idEstu = <?= $_GET["id"] ?>
</script>
<div class="row">
    <div class="col-md-12 text-center">
        <h3 id="titleDetail"></h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-estudiente-tab" data-toggle="tab"
                   href="#nav-estudiante-content" role="tab" aria-controls="nav-home" aria-selected="true">Datos
                    Estudiante</a>
                <a class="nav-item nav-link" id="nav-acudiente-tab" data-toggle="tab" href="#nav-acudiente-content"
                   role="tab" aria-controls="nav-profile" aria-selected="false">Datos Acudiente</a>
                <a class="nav-item nav-link" id="nav-trans-mio-tab" data-toggle="tab" href="#nav-trans-mio-content"
                   role="tab" aria-controls="nav-contact" aria-selected="false">Transporte MIO</a>
                <a class="nav-item nav-link" id="nav-trans-especial-tab" data-toggle="tab"
                   href="#nav-trans-especial-content" role="tab" aria-controls="nav-contact" aria-selected="false">Transporte
                    Especial</a>
                <a class="nav-item nav-link" id="nav-alimentacion-tab" data-toggle="tab"
                   href="#nav-alimentacion-content" role="tab" aria-controls="nav-contact" aria-selected="false">Alimentación</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-estudiante-content" role="tabpanel"
                 aria-labelledby="nav-home-tab"></div>
            <div class="tab-pane fade" id="nav-acudiente-content" role="tabpanel" aria-labelledby="nav-home-tab"></div>
            <div class="tab-pane fade" id="nav-trans-mio-content" role="tabpanel" aria-labelledby="nav-home-tab"></div>
            <div class="tab-pane fade" id="nav-trans-especial-content" role="tabpanel"
                 aria-labelledby="nav-home-tab"></div>
            <div class="tab-pane fade" id="nav-alimentacion-content" role="tabpanel"
                 aria-labelledby="nav-home-tab">
                <div class="container">
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-md-12 text-center"><label class="label"><b>Recibe alimentación complementaria: </b>Sí</label></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center"><label class="label" id="jornada-alimen"><b>Pertenece a jornada única: </b></label></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-primary" id="btn-print-detail"><i class="fa fa-print"></i> Imprimir</button>
            </div>
        </div>
    </div>
</div>

<div id="printArea"></div>
<script>
    $(document).ready(function () {

        // const tempInfoEstu = function (obj) {
        //     return `<div class="container">
        //                 <div class="row">
        //                     <div class="col-md-4"><label class="label"><b>Fecha de nacimiento: </b>${obj.fecha_nacimiento}</label></div>
        //                     <div class="col-md-3"><label class="label"><b>Sexo: </b>${obj.genero}</label></div>
        //                     <div class="col-md-4"><label class="label"><b>Dirección de residencia: </b>${obj.direccion}</label></div>
        //                 </div>
        //                 <div class="row">
        //                     <div class="col-md-4"><label class="label"><b>Barrio: </b>${obj.barrio}</label></div>
        //                     <div class="col-md-3"><label class="label"><b>Comuna: </b>${obj.comuna}</label></div>
        //                     <div class="col-md-4"><label class="label"><b>Institución educativa: </b>${obj.institucion}</label></div>
        //                 </div>
        //                 <div class="row">
        //                     <div class="col-md-4"><label class="label"><b>Sede: </b>${obj.sede}</label></div>
        //                     <div class="col-md-3"><label class="label"><b>Grado: </b>${obj.grado}</label></div>
        //                     <div class="col-md-4"><label class="label"><b>Jornada: </b>${obj.jornada}</label></div>
        //                 </div>
        //             </div>`;
        // }

        var tempInfoEstu = function tempInfoEstu(obj) {
            return "<br><br><div class=\"container\">\n                        <div class=\"row\">\n                            <div class=\"col-md-4\"><label class=\"label\"><b>Fecha de nacimiento: </b>" + obj.fecha_nacimiento + "</label></div>\n                            <div class=\"col-md-3\"><label class=\"label\"><b>Sexo: </b>" + obj.genero + "</label></div>\n                            <div class=\"col-md-4\"><label class=\"label\"><b>Direcci\xF3n de residencia: </b>" + (obj.direccion ? obj.direccion : 'Sin asignar') + "</label></div>\n                        </div>\n                        <div class=\"row\">\n                            <div class=\"col-md-4\"><label class=\"label\"><b>Barrio: </b>" + obj.barrio + "</label></div>\n                            <div class=\"col-md-3\"><label class=\"label\"><b>Comuna: </b>" + obj.comuna + "</label></div>\n                            <div class=\"col-md-4\"><label class=\"label\"><b>Instituci\xF3n educativa: </b>" + obj.institucion + "</label></div>\n                        </div>\n                        <div class=\"row\">\n                            <div class=\"col-md-4\"><label class=\"label\"><b>Sede: </b>" + obj.sede + "</label></div>\n                            <div class=\"col-md-3\"><label class=\"label\"><b>Grado: </b>" + obj.grado + "</label></div>\n                            <div class=\"col-md-4\"><label class=\"label\"><b>Jornada: </b>" + obj.jornada + "</label></div>\n                        </div>\n                    </div>";
        };

        // const tempInfoAcu = function (obj) {
        //     return `<div class="container">
        //                 <div class="row">
        //                     <div class="col-md-3"><label class="label"><b>Tipo de documento: </b>${(obj.tipoDocumentoAcu ? obj.tipoDocumentoAcu : 'Sin asignar')}</label></div>
        //                     <div class="col-md-3"><label class="label"><b>No. documento: </b>${(obj.numDocumentoAcu ? obj.numDocumentoAcu : 'Sin asignar')}</label></div>
        //                     <div class="col-md-3"><label class="label"><b>Nombres: </b>${(obj.nombresAcu ? obj.nombresAcu : 'Sin asignar')}</label></div>
        //                     <div class="col-md-3"><label class="label"><b>Apellidos: </b>${obj.apellidosAcu}</label></div>
        //                 </div>
        //                 <div class="row">
        //                     <div class="col-md-4"><label class="label"><b>Parentesco: </b>${(obj.parentescoAcu ? obj.parentescoAcu : 'Sin asignar')}</label></div>
        //                     <div class="col-md-4"><label class="label"><b>Correo electrónico: </b>${(obj.correoAcu ? obj.correoAcu : 'Sin asignar')}</label></div>
        //                     <div class="col-md-4"><label class="label"><b>Celular: </b>${(obj.celularAcu ? obj.celularAcu : 'Sin asignar')}</label></div>
        //                 </div>
        //             </div>`;
        // }

        var tempInfoAcu = function tempInfoAcu(obj) {
            return '<br><br><div class="container">\n                        <div class="row">\n                            <div class="col-md-3"><label class="label"><b>Tipo de documento: </b>' + (obj.tipoDocumentoAcu ? obj.tipoDocumentoAcu : 'Sin asignar') + '</label></div>\n                            <div class="col-md-3"><label class="label"><b>No. documento: </b>' + (obj.numDocumentoAcu ? obj.numDocumentoAcu : 'Sin asignar') + '</label></div>\n                            <div class="col-md-3"><label class="label"><b>Nombres: </b>' + (obj.nombresAcu ? obj.nombresAcu : 'Sin asignar') + '</label></div>\n                            <div class="col-md-3"><label class="label"><b>Apellidos: </b>' + (obj.apellidosAcu ? obj.apellidosAcu : 'Sin asignar') + '</label></div>\n                        </div>\n                        <div class="row">\n                            <div class="col-md-4"><label class="label"><b>Parentesco: </b>' + (obj.parentescoAcu ? obj.parentescoAcu : 'Sin asignar') + '</label></div>\n                            <div class="col-md-4"><label class="label"><b>Correo electr\xF3nico: </b>' + (obj.correoAcu ? obj.correoAcu : 'Sin asignar') + '</label></div>\n                            <div class="col-md-4"><label class="label"><b>Celular: </b>' + (obj.celularAcu ? obj.celularAcu : 'Sin asignar') + '</label></div>\n                        </div>\n                    </div>';
        };

        $.ajax({
            url: 'ajax.php?router=get-info-estudent&id=' + idEstu,
            method: 'GET'
        }).then(function (response) {
            if (response.success) {
                $("#titleDetail").text(response.data.nombres + ' - ' + response.data.numero_identificacion)
                $("#nav-estudiante-content").html(tempInfoEstu(response.data))
                $("#nav-acudiente-content").html(tempInfoAcu(response.data))
                $("#jornada-alimen").append(function () {
                    return response.data.jornada.toLowerCase() == 'unica' ? 'Sí' : 'No'
                })
            } else {
                alert("Algo salió mal consultando los datos");
            }
        }).catch(function (error) {
            alert("Ha ocurrido un error " + error)
        })

        // const tempInfoMio = function (obj) {
        //     return `<div class="container">
        //                 <div class="row">
        //                     <div class="col-md-4"><label class="label"><b>No. tarjeta MIO: </b>${obj.nro_tarjeta}</label></div>
        //                     <div class="col-md-4"><label class="label"><b>SEM: </b>${obj.nro_sem}</label></div>
        //                     <div class="col-md-4"><label class="label"><b>Caracterización: </b>${obj.caracterizacion}</label></div>
        //                 </div>
        //                 <div class="row">
        //                     <div class="col-md-4"><label class="label"><b>Fecha asignación: </b>${obj.fecha_asignacion}</label></div>
        //                     <div class="col-md-4"><label class="label"><b>Saldo: </b>${obj.saldo}</label></div>
        //                 </div>
        //             </div>`
        // }

        var tempInfoMio = function tempInfoMio(obj) {
            return "<br><br><div class=\"container\">\n                        <div class=\"row\">\n                            <div class=\"col-md-4\"><label class=\"label\"><b>No. tarjeta MIO: </b>" + obj.nro_tarjeta + "</label></div>\n                            <div class=\"col-md-4\"><label class=\"label\"><b>SEM: </b>" + obj.nro_sem + "</label></div>\n                            <div class=\"col-md-4\"><label class=\"label\"><b>Caracterizaci\xF3n: </b>" + obj.caracterizacion + "</label></div>\n                        </div>\n                        <div class=\"row\">\n                            <div class=\"col-md-4\"><label class=\"label\"><b>Fecha asignaci\xF3n: </b>" + obj.fecha_asignacion + "</label></div>\n                            <div class=\"col-md-4\"><label class=\"label\"><b>Saldo: </b>" + obj.saldo + "</label></div>\n                        </div>\n                    </div>";
        };

        //$("#nav-trans-mio-tab").click(function () {
            //if ($("#nav-trans-mio-content").html() == '') {
                $.ajax({
                    url: 'ajax.php?router=get-trans-mio&id=' + idEstu,
                    method: 'GET'
                }).then(function (response) {
                    if (response.success) {
                        if (response.data) {
                            $("#nav-trans-mio-content").html(tempInfoMio(response.data))
                        } else {
                            $("#nav-trans-mio-content").html("<br><br><h4>Actualmente el estudiante no posee transporte MIO</h4>")
                        }
                    }
                }).catch(function (error) {
                    alert("Ha ocurrido un error " + error)
                })
            //}
        //})

        // const tempInfoEsp = function (obj) {
        //     return `<div class="container">
        //                 <div class="row">
        //                     <div class="col-md-4"><label class="label"><b>Ruta:  </b>${obj.nombre_ruta}</label></div>
        //                     <div class="col-md-4"><label class="label"><b>Caracterización: </b>${obj.caracterizacion}</label></div>
        //                 </div>
        //                 <div class="row">
        //                     <div class="col-md-4"><label class="label"><b>Fecha asignación: </b>${obj.fecha_asignacion}</label></div>
        //                     <div class="col-md-4"><label class="label"><b>Vijencia: </b>${obj.vijencia}</label></div>
        //                 </div>
        //             </div>`
        // }

        var tempInfoEsp = function tempInfoEsp(obj) {
            return "<br><br><div class=\"container\">\n                        <div class=\"row\">\n                            <div class=\"col-md-4\"><label class=\"label\"><b>Ruta:  </b>" + obj.nombre_ruta + "</label></div>\n                            <div class=\"col-md-4\"><label class=\"label\"><b>Caracterizaci\xF3n: </b>" + obj.caracterizacion + "</label></div>\n                        </div>\n                        <div class=\"row\">\n                            <div class=\"col-md-4\"><label class=\"label\"><b>Fecha asignaci\xF3n: </b>" + obj.fecha_asignacion + "</label></div>\n                            <div class=\"col-md-4\"><label class=\"label\"><b>Vijencia: </b>" + obj.vijencia + "</label></div>\n                        </div>\n                    </div>";
        };

        //$("#nav-trans-especial-tab").click(function () {
            //if($("#nav-trans-especial-content").html() == ''){
                $.ajax({
                    url: 'ajax.php?router=get-trans-especial&id=' + idEstu,
                    method: 'GET'
                }).then(function (response) {
                    if (response.success) {
                        if (response.data) {
                            $("#nav-trans-especial-content").html(tempInfoEsp(response.data))
                        } else {
                            $("#nav-trans-especial-content").html("<br><br><h4>Actualmente el estudiante no posee transporte especial</h4>")
                        }
                    }
                }).catch(function (error) {
                    alert("Ha ocurrido un error " + error)
                })
            //}
        //})

        $("#btn-print-detail").click(function (e) {
            $("#printArea").append("<h2>Datos de estudiante</h2>")
            $("#printArea").append($("#nav-estudiante-content").html())
            $("#printArea").append("<br>")
            $("#printArea").append("<h2>Datos de acudiente</h2>")
            $("#printArea").append($("#nav-acudiente-content").html())
            $("#printArea").append("<br>")
            $("#printArea").append("<h2>Transporte MIO</h2>")
            $("#printArea").append($("#nav-trans-mio-content").html())
            $("#printArea").append("<br>")
            $("#printArea").append("<h2>Transporte especial</h2>")
            $("#printArea").append($("#nav-trans-especial-content").html())
            $("#printArea").append("<br>")
            $("#printArea").append("<h2>Alimentación</h2>")
            $("#printArea").append($("#nav-alimentacion-content").html())
            $("#printArea").printArea({
                mode: "popup",
                popClose: true,
                popTitle: "Impresión detalle de estudiante",
                popHt: 820,
                popWd: 1024,
                popX: 0,
                popY: 0

            })
            $("#printArea").html('')
        })
    })
</script>