window.onload=function(){
  ocultar();
}

$(document).ready(function(){
  var tipos = [];
  $("select[name=tipo]").change(function(){
    var tipo = $('select[name=tipo]').val();
    console.log(tipo);

    switch(tipo){
      case "Serie":
        ocultar();
        mostrar("serie");
      break;
      case "Manga":
        ocultar();
        mostrar("manga");
      break;
      case "Videojuego":
        ocultar();
        mostrar("videojuego");
      break;
      case "Pelicula":
        ocultar();
        mostrar("pelicula");
      break;
      case "Anime":
        ocultar();
        mostrar("anime");
      break;
      case "Comic":
        ocultar();
        mostrar("comic");
      break;
      case "Libro":
        ocultar();
        mostrar("libro");
      break;
    }
  });
});


 function mostrar(tipo){
   $('.' + tipo).show();
   $('.' + tipo).prop('required',true);
 }

 function ocultar(){
        $('.serie').hide();
        $('.serie').prop('required',false);
        $('.manga').hide();
        $('.manga').prop('required',false);
        $('.videojuego').hide();
        $('.videojuego').prop('required',false);
        $('.pelicula').hide();
        $('.pelicula').prop('required',false);
        $('.anime').hide();
        $('.anime').prop('required',false);
        $('.comic').hide();
        $('.comic').prop('required',false);
        $('.libro').hide();
        $('.libro').prop('required',false);
 }