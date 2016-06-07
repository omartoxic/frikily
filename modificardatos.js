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
  console.log('tipo' + tipo);
   $('.' + tipo).show();
 }

 function ocultar(){
        $('.serie').hide();
        $('.manga').hide();
        $('.videojuego').hide();
        $('.pelicula').hide();
        $('.anime').hide();
        $('.comic').hide();
        $('.libro').hide();
 }