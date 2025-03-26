$(document).ready(function(){

	// Buscar empresa
	$('#cif').keyup(function(e){
		e.preventDefault();

		var emp = $(this).val();
		var action = 'searchEmpresa';
		console.log('empresa', emp)

		$.ajax({
			url: 'ajax_seguimiento_empresa.php',
			type: "POST",
			async : true,
			data: {action:action,empresa:emp},

			success: function(response)
			{
				var empresa_no_existe = response == 0;

				if(empresa_no_existe){
					$('#idempresa').val('');
					$('#empresa').val('');
					$('#contacto').val('');
					$('#telefono_contacto').val('');
					$('#correo_contacto').val('');

					// limpiar campo empresa si no existe 
					$('#seguimiento_empresa').val('');

					// mostrar botón nueva empresa
					$('.btn_new_empresa').slideDown();
				}else{
					var data  = $.parseJSON(response);
					$('#idempresa').val(data.idempresa);
					$('#empresa').val(data.empresa);
					$('#contacto').val(data.contacto);
					$('#telefono_contacto').val(data.telefono_contacto);
					$('#correo_contacto').val(data.correo_contacto);

					// ocultar boton nueva empresa
					$('.btn_new_empresa').slideUp();

					// Bloque campos desactivados
					$('#empresa').attr('disabled','disabled');
					$('#contacto').attr('disabled','disabled');
					$('#telefono_contacto').attr('disabled','disabled');
					$('#correo_contacto').attr('disabled','disabled');

					// ocultar boton guardar empresa
					$('#div_registro_empresa').slideUp();

					// enviar nombre empresa al formulario de seguimiento
					$('#practica_empresa').val(data.empresa);

					console.log('seguimiento de empresa', data.empresa);
				}
			},
			error: function(error) {
			}
		});
	});	

}); // End Ready