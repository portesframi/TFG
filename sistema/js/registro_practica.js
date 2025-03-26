$(document).ready(function(){

	//Activa campos para registrar empresa

	$('.btn_new_empresa').click(function(e){
		e.preventDefault();
		$('#empresa').removeAttr('disabled');
		$('#dir_empresa').removeAttr('disabled');
		$('#loc_empresa').removeAttr('disabled');
		$('#cp_empresa').removeAttr('disabled');
		$('#pro_empresa').removeAttr('disabled');
		$('#tel_empresa').removeAttr('disabled');
		$('#corr_empresa').removeAttr('disabled');
		$('#cont_empresa').removeAttr('disabled');

		$('#div_registro_empresa').slideDown();
	});


	// Buscar empresa
	$('#cif').keyup(function(e){
		e.preventDefault();

		var emp = $(this).val();
		var action = 'searchEmpresa';
		console.log('empresa', emp)

		$.ajax({
			url: 'ajax_empresa.php',
			type: "POST",
			async : true,
			data: {action:action,empresa:emp},

			success: function(response)
			{
				var empresa_no_existe = response == 0;

				if(empresa_no_existe){
					$('#idempresa').val('');
					$('#empresa').val('');
					$('#dir_empresa').val('');
					$('#loc_empresa').val('');
					$('#cp_empresa').val('');
					$('#pro_empresa').val('');
					$('#tel_empresa').val('');
					$('#corr_empresa').val('');
					$('#cont_empresa').val('');

					// limpiar campo empresa si no existe 
					$('#practica_empresa').val('');

					// mostrar botón nueva empresa
					$('.btn_new_empresa').slideDown();
				}else{
					var data  = $.parseJSON(response);
					$('#idempresa').val(data.idempresa);
					$('#empresa').val(data.empresa);
					$('#dir_empresa').val(data.direccion);
					$('#loc_empresa').val(data.localidad);
					$('#cp_empresa').val(data.cp);
					$('#pro_empresa').val(data.provincia);
					$('#tel_empresa').val(data.telefono);
					$('#corr_empresa').val(data.correo);
					$('#cont_empresa').val(data.contacto);

					// ocultar boton nueva empresa
					$('.btn_new_empresa').slideUp();

					// Bloque campos desactivados
					$('#empresa').attr('disabled','disabled');
					$('#dir_empresa').attr('disabled','disabled');
					$('#loc_empresa').attr('disabled','disabled');
					$('#cp_empresa').attr('disabled','disabled');
					$('#pro_empresa').attr('disabled','disabled');
					$('#tel_empresa').attr('disabled','disabled');
					$('#corr_empresa').attr('disabled','disabled');
					$('#cont_empresa').attr('disabled','disabled');

					// ocultar boton guardar empresa
					$('#div_registro_empresa').slideUp();

					// enviar nombre empresa al formulario de practica
					$('#practica_empresa').val(data.empresa);

					console.log('practica de empresa', data.empresa);
				}
			},
			error: function(error) {
			}
		});
	});

	// Crear empresa desde ventana de prácticas
	$('#form_new_empresa_practicas').submit(function(e){
		e.preventDefault();

		$.ajax({
			url: 'ajax_empresa.php',
			type: "POST",
			async : true,
			data: $('#form_new_empresa_practicas').serialize(),

			success: function(response)
			{
				if(response != 'error'){
					// agregar id a input hidden
					$('#idempresa').val(response);
					
					//bloqueo campos
					$('#empresa').attr('disabled','disabled');
					$('#dir_empresa').attr('disabled','disabled');
					$('#loc_empresa').attr('disabled','disabled');
					$('#cp_empresa').attr('disabled','disabled');
					$('#pro_empresa').attr('disabled','disabled');
					$('#tel_empresa').attr('disabled','disabled');
					$('#corr_empresa').attr('disabled','disabled');
					$('#cont_empresa').attr('disabled','disabled');

					// ocultar boton nueva empresa
					$('.btn_new_empresa').slideUp();

					// ocultar boton guardar empresa
					$('#div_registro_empresa').slideUp();
				}
			},
			error: function(error) {
			}
		});
	});

}); // End Ready