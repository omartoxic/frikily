function enviarDatos()
{
  console.log('estamos dentro');
  var tipo = $('#tipo').val();
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
        if(tipo == 'pelicula')
        {
          $('#'+id).html("<i class='glyphicon glyphicon-ok'></i>Marcar película vista");
        }
        else if(tipo == 'videojuego')
        {
          $('#'+id).html("<i class='glyphicon glyphicon-ok'></i>Marcar el videojuego como jugado");
        }
        else if(tipo == 'libro')
        {
          $('#'+id).html("<i class='glyphicon glyphicon-ok'></i>Marcar libro como leido");
        }
        $('#'+id).removeClass('visto');
      }
      else
      {
        if(tipo == 'pelicula')
        {
          $('#'+id).html("<i class='glyphicon glyphicon-ok'></i>Película vista");
        }
        else if(tipo == 'videojuego')
        {
          $('#'+id).html("<i class='glyphicon glyphicon-ok'></i>Videojuego jugado");
        }
        else if(tipo == 'libro')
        {
          $('#'+id).html("<i class='glyphicon glyphicon-ok'></i>Libro leido");
        }
        $('#'+id).addClass('visto');
      }
      comprobarSerieVista();
    },
    error:function(respuesta)
    {
      console.log('Ha ocurrido un error '+respuesta);
    }
  });

}

function serieVista()
{
  $('.ver').click();
  console.log('serieVista');
  comprobarSerieVista();
}

function comprobarSerieVista()
{
  var codigo = $('#cod').val();
  var usuario = $('#cod-usu').val();
  var tipo = $('#tipo').val();
  $.ajax(
  {
    data:{'codigo':codigo,'usuario':usuario},
    url:'contarCapitulos.php',
    type:'post',
    success:function(respuesta)
    {
      if(respuesta == "1")
      {
        if(tipo == 'serie')
        {
          $('#vistos').html("<i class='glyphicon glyphicon-ok'></i>Serie vista");
        }
        else if(tipo == 'manga')
        {
          $('#vistos').html("<i class='glyphicon glyphicon-ok'></i>Manga leido");
        }
        else if(tipo == 'anime')
        {
          $('#vistos').html("<i class='glyphicon glyphicon-ok'></i>Anime visto");
        }
        else if(tipo == 'comic')
        {
          $('#vistos').html("<i class='glyphicon glyphicon-ok'></i>Cómic leido");
        }
        $('#vistos').addClass('visto');
      }
      else
      {
        if(tipo == 'serie')
        {
          $('#vistos').html("<i class='glyphicon glyphicon-ok'></i>Marcar serie como vista");
        }
        else if(tipo == 'manga')
        {
          $('#vistos').html("<i class='glyphicon glyphicon-ok'></i>Marcar manga como leido");
        }
        else if(tipo == 'anime')
        {
          $('#vistos').html("<i class='glyphicon glyphicon-ok'></i>Marcar anime como visto");
        }
        else if(tipo == 'comic')
        {
          $('#vistos').html("<i class='glyphicon glyphicon-ok'></i>Marcar cómic como leido");
        }
        $('#vistos').removeClass('visto');
      }
    }
  });
}

$(document).ready(function()
{
  $('#visto').click(enviarDatos);
  $('.ver').click(enviarDatos);
  $('#vistos').click(serieVista)
});
