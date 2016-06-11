function comprobarLongitudTexto()
{
  var texto = $(this).html();
  var longitudTexto = $(this).html().length;
  if(longitudTexto > 30)
  {
    texto = texto.substr(0,30);
    texto += "...";
  }
  $(this).html(texto);
}

$(document).ready(function()
{
  $('.texto-articulo').each(comprobarLongitudTexto);
});
