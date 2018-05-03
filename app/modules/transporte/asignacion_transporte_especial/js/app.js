let idStudent = 0
$(document).ready(function () {
    let loaderSearch = $("#loader-search-students");

    $("#list-students").hide()

    const tempRow = function (obj, index) {
        return `
        <tr>
            <td>${obj.documento}</td>
            <td>${obj.name}</td>
            <td>${obj.jornada}</td>
            <td>${obj.grado}</td>
            <td>${obj.institucion}</td>
            <td>${obj.sede}</td>
            <td>
                <button type="button" class="btn btn-primary select-estudent" data-id="${obj.id}"><i class="fa fa-mouse-pointer"></i></button>
            </td>
         </tr>`;
    }


    $("#formSearch").submit(function (e) {
        e.preventDefault()

        let valid = 0
        $("#formSearch :input").each(function (e) {
            if (this.type == 'text' || this.type == 'number') {
                if ($(this).val() != '') {
                    valid++
                }
            }
        })

        if (!valid) {
            notificationError("Debe usar al menos uno de los filtros para hacer la búsqueda")
            return false
        }

        $("#tbody-table-students").html('')
        $("#list-students").hide()

        $.ajax({
            url: 'index.php?router=search-estudiantes',
            method: 'POST',
            data: $(this).serialize(),
            beforeSend: function () {
                loaderSearch.show()
            },
        }).then(function (response) {
            if (response.length > 0) {

                response.forEach(function (element, index) {
                    $("#tbody-table-students").append(tempRow(element, index++));
                })

                $("#list-students").show()

                $(".select-estudent").click(function (e) {
                    $("#list-students").hide();
                    idStudent = $(this).attr('data-id');
                    $.ajax({
                        url: 'views/dataStudent.php',
                        method: 'GET'
                    }).then(function (response){
                        $("#container-search").hide();
                        $("#container").html(response);
                        $("#exit-assign").click(function () {
                            $("#container").html('')
                            $("#container-search, #list-students").show();
                        })
                    }).catch(function (error) {
                        notificationError(error.message)
                    })
                })
            } else notificationError("No se encontraron registros que coincidan con el filtro")
            loaderSearch.hide()
        }).catch(function (error) {
            notificationError(error.message)
        })
    })


})

function notificationError(message) {
    $("#alert-error").text(message).show("slow", function () {
        setTimeout(function () {
            $("#alert-error").hide('slow');
        }, 5000)
    });
}

function notificationSuccess(message) {
    $("#alert-success").text(message).show("slow", function () {
        setTimeout(function () {
            $("#alert-success").hide('slow');
        }, 5000)
    });
}