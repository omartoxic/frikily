$(document).ready(function()
{
    if ($(window).width() <= 320)
	  {
			$("#secciones").removeClass("list-group");
			$("#secciones .list-group-item").removeClass("list-group-item");
			$("#secciones").addClass("navbar navbar-default navbar-nav");
			$("#secciones").attr("role","navigation");
    }
});
