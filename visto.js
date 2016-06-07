function enviarDatos()
{
  console.log('estamos dentro');
  var codigo = $('#cod').val();
  var usuario = $('#cod-usu').val();
  var capitulo = null;
  var id = $(this).attr('id');
  var isCap = id.match(/^\d+$/);
  if(isCap != null)
  {
    capitulo = id
  }
  $.ajax(
  {
    data:{'codigo':codigo,'usuario':usuario,'capitulo':capitulo},
    url:'visto.php',
    type:'post',
    beforeSend:function()
    {
      console.log('Enviando el código');
    },
    success:function(respuesta)
    {
      console.log('Todo correcto '+respuesta);
      if($('#'+id).hasClass('visto'))
      {
        $('#'+id).removeClass('visto');
      }
      else
      {
        $('#'+id).addClass('visto');
      }
    },
    error:function(respuesta)
    {
      console.log('Ha ocurrido un error '+respuesta);
    }
  });

}

$(document).ready(function()
{
  $('#visto').click(enviarDatos);
  $('.ver').click(enviarDatos);
});
