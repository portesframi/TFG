$(document).ready(function(){

	// Buscar alumno
	$('#dni').keyup(function(e){
		e.preventDefault();

		var alum = $(this).val();
		var action = 'searchAlumno';

		$.ajax({
			url: 'ajax_seguimiento_alumno.php',
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

}); // End Ready