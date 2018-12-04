 function showbuscarOrden()
    {
		//blanquear campos
		$("#nroridend").val("");
		$('#idordendialog').modal({
		keyboard:false,
		backdrop:'static'
		})
	}
	
	function buscarorden()
	{
		$.ajax({
        type: "POST",
        url: "ajax_search.php?buscarorden="+$("#nroridend").val(),
        processData: false, 
        contentType: "application/json"
    })
    .done(function(datae, textStatus, jqXHR){
 var obj = JSON.parse( datae );
 if(obj[0].codigo!="0")
 {
	window.location.href = "trabajarorden.php?id="+$("#nroridend").val(); 
 }
 else
 {
	 $("#buscarordenerror").css("display","block");
	 $("#nroridend").select();
 }
	});
	}
	

$("#nroridend").keyup(function(e){
    if(e.keyCode == 13)
    {
       buscarorden();
    }
});

function toggleMenu()
{
	$("#wrapper").toggleClass("toggled");
}


//verificar si es un mobile
if (navigator.userAgent.match(/Android/i) ||
             navigator.userAgent.match(/webOS/i) ||
             navigator.userAgent.match(/iPhone/i) ||
             navigator.userAgent.match(/iPad/i) ||
             navigator.userAgent.match(/iPod/i) ||
             navigator.userAgent.match(/BlackBerry/) || 
             navigator.userAgent.match(/Windows Phone/i) || 
             navigator.userAgent.match(/ZuneWP7/i)
             ) {
                // some code
                
				$("body").prepend('<div class="navbar navbar-inverse navbar-fixed-top" style="background:#000;min-height:30px;position:relative;margin-bottom:0px;"><a  href="#" onclick="toggleMenu();"  class="btn btn-default"><span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span></a>&nbsp;<span style="color:#fff">Servicio Tecnico</span><span style="float:right"><a href="logout.php" style="display:inline">Cerrar Sesion</a></span></div>');
				$(".sidebar-brand").css("display","none");
				$("#wrapper").removeClass("toggled");
               }