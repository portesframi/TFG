$(document).ready(function(){

	// Filtro de cursos en listados
	$('#search_curso').change(function(e){
		e.preventDefault();
		var sistema = getUrl();
		location.href = sistema+'buscar_curso.php?curso='+$(this).val();
		
	});


}); // End Ready

// Función que permite cargar la url de la aplicación
function getUrl() {
	var loc = window.location;
	var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
	return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
}