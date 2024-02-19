$(document).ready(function () {
    $('#mensaje').click(mensaje);
    function mensaje() {
        Swal.fire({
            icon: 'info',
            title: '',
            text: 'Comunicate con el area de desarrollo.'
        });
    }

    $('#developer').click(developer);
    function developer() {
        Swal.fire({
            icon: 'info',
            title: '',
            text: 'Developer: Eider González Sánchez.'
        });
    }
    // -------------------------------------------------------------------------------- //

    // Get dinamico
    $('.php').on('click', function (e) {
        e.preventDefault();

        var formName = $(this).data('form');

        $.ajax({
            url: formName + '.php',
            type: 'GET',
            success: function (response) {
                $('#resultado').html(response);
            },
            error: function (error) {
                console.log('Error al cargar el formulario:', error);
            }
        });
    });
    // -------------------------------------------------------------------------------- //

    // subir malla de turno
    $("#malla").submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        $('#loader').removeClass('hidden');

        $.ajax({
            url: "../php/cargar_mallas.php",
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "",
                        text: response.message,
                        footer: "Total: " + response.total_records + " insertados: " + response.inserted_records + " existente: " + response.duplicados,
                    });
                    $('#loader').addClass('hidden');
                    $("#archivo_excel").val("");
                } else if (response.status === "error") {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: response.message,
                        footer: "Total: " + response.total_records + " insertados: " + response.inserted_records + " existente: " + response.duplicados,
                    });
                    $('#loader').addClass('hidden');
                    $("#archivo_excel").val("");
                }
            },
            error: function (error) {
                console.error("Error in AJAX request: ", error);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "An error occurred during the request.",
                });
                $('#loader').addClass('hidden');
                $("#archivo_excel").val("");
            },
        });
    });

    // buscar malla 
    $('#visualizar').submit(function (e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            url: '../php/consulta_malla.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                $('#resultado').html(response);
            },
            error: function (error) {
                console.log('Error en la búsqueda:', error);
            }
        });
    });

    // editar malla 
    $('.link').on('click', function (e) {
        e.preventDefault();

        var formName = $(this).data('form');

        var cedulaValue = $(this).data('cedula');
        var diaValue = $(this).data('dia');

        var formUrl = '../view/' + formName + '.php?cedula=' + encodeURIComponent(cedulaValue) + '&dia=' + encodeURIComponent(diaValue);

        $.ajax({
            url: formUrl,
            type: 'GET',
            success: function (response) {
                $('#resultado').html(response);
            },
            error: function (error) {
                console.log('Error al cargar el formulario:', error);
            }
        });
    });

    // enviar los cambios de la malla
    $('#editar').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "../php/actualizar_malla.php",
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "",
                        text: response.message,
                    });
                } else if (response.status === "error") {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: response.message,
                    });
                }
            }
        })
    })
    // -------------------------------------------------------------------------------- //

    // enviar solicitud
    $('#solicitudes').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: '../php/subir_solicitud.php',
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "",
                        text: response.message,
                    });
                    $("#solicitudes")[0].reset();
                } else if (response.status === "error") {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: response.message,
                    });
                    $("#solicitudes")[0].reset();
                }
            }
        })
    })

    $('#label').addClass('hidden');
    $('#fecha_solicitud').addClass('hidden');
    $('#solicitud').change(function () {
        var select = $(this).val();
        var label = $('#label');

        if (select === 'Solicitud Vacaciones') {
            $('#label').removeClass('hidden');
            $('#fecha_solicitud').removeClass('hidden');
            label.html('Fecha de inicio de vacaciones:');
        } else if (select === 'Permiso Remunerado') {
            $('#label').removeClass('hidden');
            $('#fecha_solicitud').removeClass('hidden');
            label.html('Fecha de Permiso Remunerado:');
        } else if (select === 'Permiso No Remunerado') {
            $('#label').removeClass('hidden');
            $('#fecha_solicitud').removeClass('hidden');
            label.html('Fecha de Permiso No Remunerado:');
        } else {
            $('#label').addClass('hidden');
            $('#fecha_solicitud').addClass('hidden');
        }
    });

    // filtart
    $('#filtrar').submit(function (e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            url: '../php/filtrar.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                $('#resultado').html(response);
            },
            error: function (error) {
                console.log('Error en la búsqueda:', error);
            }
        });
    });
    // -------------------------------------------------------------------------------- //

    // envio ajax novedad
    $('#novedades').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "../php/subir_novedad.php",
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "",
                        text: response.message,
                        footer: "Total: " + response.total_records,
                    });
                    $("#novedades")[0].reset();
                    $("#archivo_excel").val("");
                } else if (response.status === "error") {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: response.message,
                        footer: "Total: " + response.total_records,
                    });
                    $("#novedades")[0].reset();
                    $("#archivo_excel").val("");
                }
            }
        })
    })

    $('#subir_novedad').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        $('#loader').removeClass('hidden');

        $.ajax({
            url: "../php/cargar_novedades.php",
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "",
                        text: response.message,
                        footer: "Total: " + response.total_records + " insertados: " + response.inserted_records + " no insertados: " + response.duplicados,
                    });
                    $('#loader').addClass('hidden');
                    $("#archivo_excel").val("");
                } else if (response.status === "error") {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: response.message,
                        footer: "Total: " + response.total_records + " insertados: " + response.inserted_records + " no insertados: " + response.duplicados,
                    });
                    $('#loader').addClass('hidden');
                    $("#archivo_excel").val("");
                }
            },
            error: function (error) {
                console.error("Error in AJAX request: ", error);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "An error occurred during the request.",
                });
                $('#loader').addClass('hidden');
                $("#archivo_excel").val("");
            },
        });
    });
    // -------------------------------------------------------------------------------- //

    // busqueda tardanza
    $('#tardanza').submit(function (e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            url: '../php/consulta_tardanza.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                $('#resultado').html(response);
            },
            error: function (error) {
                console.log('Error en la búsqueda:', error);
            }
        });
    });

    // justificar tardanza
    $('#edit_tarda').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "../php/justificacion.php",
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "",
                        text: response.message,
                    });
                } else if (response.status === "error") {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: response.message,
                    });
                }
            }
        })
    })

    $("#tardanza").change(function () {
        var selectedValue = $(this).val();

        if (selectedValue === "Justificada") {
            $('#motivo_label').removeClass('hidden');
            $('#motivo').prop('required', true);
        } else {
            $('#motivo_label').addClass('hidden');
            $('#motivo').prop('required', false).val('');
        }
    });

    $('.volver').on('click', function (e) {
        e.preventDefault();

        var formName = $(this).data('form');
        var cedulaValue = $(this).data('cedula');
        var diaValue = $(this).data('dia');

        var formUrl = '../php/' + formName + '.php?cedula=' + encodeURIComponent(cedulaValue) + '&dia=' + encodeURIComponent(diaValue);

        $.ajax({
            url: formUrl,
            type: 'GET',
            success: function (response) {
                $('#resultado').html(response);
            },
            error: function (error) {
                console.log('Error al cargar el formulario:', error);
            }
        });
    });
    // -------------------------------------------------------------------------------- //

    // agregar empleado
    $('#empleados').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "../php/agregar_empleado.php",
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "",
                        text: response.message,
                        footer: "Total: " + response.total_records,
                    });
                    $("#empleados")[0].reset();
                    $("#archivo_excel").val("");
                } else if (response.status === "error") {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: response.message,
                    });
                    $("#empleados")[0].reset();
                    $("#archivo_excel").val("");
                }
            }
        })
    })

    $('#subir_empleado').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        $('#loader').removeClass('hidden');

        $.ajax({
            url: "../php/cargar_empleados.php",
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "",
                        text: response.message,
                        footer: "Total: " + response.total_records + " insertados: " + response.inserted_records + " existente: " + response.duplicados,
                    });
                    $('#loader').addClass('hidden');
                    $("#archivo_excel").val("");
                } else if (response.status === "error") {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: response.message,
                        footer: "Total: " + response.total_records + " insertados: " + response.inserted_records + " existente: " + response.duplicados,
                    });
                    $('#loader').addClass('hidden');
                    $("#archivo_excel").val("");
                }
            },
            error: function (error) {
                console.error("Error in AJAX request: ", error);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "An error occurred during the request.",
                });
                $('#loader').addClass('hidden');
                $("#archivo_excel").val("");
            },
        });
    });

    // fecha de retiro
    $('#retiro').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "../php/subir_retiro.php",
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "",
                        text: response.message,
                    });
                    $("#retiro")[0].reset();
                } else if (response.status === "error") {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: response.message,
                    });
                    $("#retiro")[0].reset();
                }
            }
        })
    })
    // -------------------------------------------------------------------------------- //

    // cambiar clave
    $('#cambio_clave').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "../php/cambiar_clave.php",
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "",
                        text: response.message,
                    });
                    $("#cambio_clave")[0].reset();
                } else if (response.status === "error") {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: response.message,
                    });
                    $("#cambio_clave")[0].reset();
                }
            }
        })
    })
    // -------------------------------------------------------------------------------- //

    $('#mesAnterior, #mesSiguiente').on('click', function () {

        var mes = $('#mes').val();
        var anio = $('#anio').val();
        var mesValue = $(this).data('mes');
        var formUrl = '../php/actualizar_info.php?mes=' + encodeURIComponent(mes) + '&anio=' + encodeURIComponent(anio) + '&value=' + encodeURIComponent(mesValue);
        console.log(mes,anio,mesValue,formUrl);
        $.ajax({
            url: formUrl,
            type: 'POST',
            success: function (response) {
                $('#ee').html(response);
            },
            error: function (error) {
                console.log('Error al cargar el formulario:', error);
            }
        });
    });
});