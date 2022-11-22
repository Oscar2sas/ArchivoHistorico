$(buscar_libro());



function buscar_libro(consulta){
    const carpeta = window.location.pathname.substring(0,window.location.pathname.indexOf("controladores")-1);
    $.ajax({
        url: carpeta +'/modelo/Biblioteca/controller_busqueda_libro.php',
        type: 'POST',
        dataType: 'html',
        data: {consulta: consulta},
    })
    .done(function(respuesta) {
        console.log(respuesta);
        $('#datos').html(respuesta);
    })
    .fail(function() {
        console.log('error')
    })
}

$(document).on('keyup', '#caja_busqueda',function(){
    var valor = $(this).val();
    if(valor != ""){
        buscar_libro(valor);
    }else{
        buscar_libro();
    }

})