/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 var path = "https://calidadsuperarse.app/";

$(document).ready(function () {


    $(".dataTable").dataTable();

    $("#envio-correo-prematricula").click(function () {

        var correo = $(this).attr('correo');
        var idMatricula = $(this).attr('idMatricula');
        swal({
            title: "Envío de Correo",
            text: "Se enviará el correo a la siguiente dirección:\n",
            type: "input",
            showCancelButton: true,
            closeOnConfirm: false,
            inputPlaceholder: "",
            inputValue: correo,
            showLoaderOnConfirm: true,
            confirmButtonId: "btn-confirm-correo",
        }, function (inputValue) {
            if (inputValue === false) {
                return false;
            }
            if (inputValue === "") {
                swal.showInputError("Debe escribir un correo");
                return false;
            }
            $.ajax({
                type: 'GET',
                dataType: 'text',
                url: "https://sgi.superarse.edu.ec/matricula/prematricula/enviar-correo/" + idMatricula,
                data: {
                    correo: inputValue
                },
                success: function (datos) {
                    swal("", "Correo enviado con Exito");
                }
            });

        });
    });


    $(".btn-eliminar").click(function () {
        var url = $(this).attr("url");
        swal({
            title: "Eliminar",
            text: "¿Está seguro que desea eliminar?",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-primary",
            confirmButtonText: "SI",
            cancelButtonText: "NO",
            closeOnConfirm: false,
            closeOnCancel: true
        },
                function (isConfirm) {
                    if (isConfirm) {
                        window.location.href = url;
                    }
                });
    });

    $("#calcularCuantitativo").click(function () {
        $.ajax({
            type: 'GET',
            dataType: 'text',
            url: "https://sgi.superarse.edu.ec/calcular-cuantitativo",
            data: $("#formulario").serialize(),
            success: function (datos) {
                var json = JSON.parse(datos);
                $("#resultado").html(json['resultado']);
                $("#ponderado").html(json['ponderado'] + "%");
            }
        });
    });







});


function soloNumeros(evt) {

    // code is the decimal ASCII representation of the pressed key.
    var code = (evt.which) ? evt.which : evt.keyCode;

    if (code == 8) { // backspace.
        return true;
    } else if (code >= 48 && code <= 57) { // is a number.
        return true;
    } else { // other keys.
        return false;
    }
}

function mayusculas(string) {
    return string.toUpperCase();
}
