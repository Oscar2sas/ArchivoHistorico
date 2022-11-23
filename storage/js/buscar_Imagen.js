$(buscar_img());



function buscar_img(consulta){
    const carpeta = window.location.pathname.substring(0,window.location.pathname.indexOf("controladores")-1);
    $.ajax({
        url: carpeta +'/modelo/Fotografia/controller_busqueda_Imagen.php',
        type: 'POST',
        dataType: 'html',
        data: {consulta: consulta},
    })
    .done(function(respuesta) {
        $('#datos_img').html(respuesta);
    })
    .fail(function() {
        console.log('error')
    })
}

$(document).on('keyup', '#caja_busqueda_img',function(){
    var valor = $(this).val();
    if(valor != ""){
        buscar_img(valor);
    }else{
        buscar_img();
    }

})