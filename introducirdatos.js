window.onload=function(){
  ocultar();
}

$(document).ready(function(){
  var tipos = [];
  $("select[name=tipo]").change(function(){
    var tipo = $('select[name=tipo]').val();
    ocultar();
    mostrar(tipo);
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