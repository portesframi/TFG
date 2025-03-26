$(document).ready(function(){

	//Activa campos para registrar alumno

	$('.btn_new_alumno').click(function(e){
		e.preventDefault();
		$('#alumno').removeAttr('disabled');
		$('#tel_alumno').removeAttr('disabled');
		$('#cor_alumno').removeAttr('disabled');
		
		$('#div_registro_alumno').slideDown();
	});


	// Buscar alumno
	$('#dni').keyup(function(e){
		e.preventDefault();

		var alum = $(this).val();
		var action = 'searchAlumno';

		$.ajax({
			url: 'ajax_alumno.php',
			type: "POST",
			async : true,
			data: {action:action,alumno:alum},

			success: function(response)

			{
			
				if(response == 0){
					$('#idalumno').val('');
					$('#alumno').val('');
					$('#tel_alumno').val('');
					$('#cor_alumno').val('');

					// limpiar campo alumno si no existe 
					$('#practica_alumno').val('');
					
					// mostrar botón nuevo alumno
					$('.btn_new_alumno').slideDown();
				}else{
					var data  = $.parseJSON(response);
					$('#idalumno').val(data.idalumno);
					$('#alumno').val(data.alumno);
					$('#tel_alumno').val(data.telefono);
					$('#cor_alumno').val(data.correo);
					
					// ocultar boton nuevo alumno
					$('.btn_new_alumno').slideUp();

					// Bloque campos desactivados
					$('#alumno').attr('disabled','disabled');
					$('#tel_alumno').attr('disabled','disabled');
					$('#cor_alumno').attr('disabled','disabled');
					
					// ocultar boton guardar alumno
					$('#div_registro_alumno').slideUp();

					// enviar nombre alumno al formulario de practica
					$('#practica_alumno').val(data.alumno);

				}
			},
			error: function(error) {
			}
		});
	});

	// Crear alumno desde ventana de prácticas
	$('#form_new_alumno_practicas').submit(function(e){
		e.preventDefault();

		$.ajax({
			url: 'ajax_alumno.php',
			type: "POST",
			async : true,
			data: $('#form_new_alumno_practicas').serialize(),

			success: function(response)
			{
				if(response != 'error'){
					// agregar id a input hidden
					$('#idalumno').val(response);
					
					//bloqueo campos
					$('#alumno').attr('disabled','disabled');
					$('#tel_alumno').attr('disabled','disabled');
					$('#cor_alumno').attr('disabled','disabled');
					
					// ocultar boton nuevo alumno
					$('.btn_new_alumno').slideUp();

					// ocultar boton guardar alumno
					$('#div_registro_alumno').slideUp();
				}
			},
			error: function(error) {
			}
		});
	});

}); // End Ready