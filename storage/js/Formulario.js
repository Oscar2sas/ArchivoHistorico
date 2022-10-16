$(document).ready(function() {
    $('#opcion1').change(function() {
        var selectedOption = this.options[this.selectedIndex];
        seleccionado = selectedOption.text;
        Imprimiri(seleccionado);
    });


});

const carpeta = window.location.pathname.substring(0,window.location.pathname.indexOf("controladores")-1);

const Imprimiri = (sas) =>{

    if (sas == 'Biblioteca') {
        $('#sas').remove();
        biblioteca();
    }else{
    const coso = "<div id='sas'><h1>"+ sas +"</h1></div>";
    $('#sas').remove();
    $('#formulario').append(coso);}
    
}

const palabrasL = async() =>{
    const data = new FormData();

    data.append('accion','palabra');

    const URL = carpeta + '/controladores/Subir_archivo/controler-sub.php';
    const CONFIG = {
        method: 'POST',
        body: data
    };

    try {
        const enviar = await fetch(URL, CONFIG);
        const recibir = await enviar.json();

        $('#pala').append(`${recibir}`);
    } catch (error) {
        console.log(error);
    }
}

const biblioteca = async() =>{
    const data = new FormData();

    data.append('accion','biblioteca');
	
	

    const URL = carpeta + '/controladores/Subir_archivo/controler-sub.php';
    const CONFIG = {
        method: 'POST',
        body: data
    };

    try {
        const enviar = await fetch(URL, CONFIG);
        const recibir = await enviar.json();
        
        $('#formulario').append(`${recibir}`);
        $('#sas').ready(function() { 
            $('#plc').change( function() { 
                if(this.checked){
                    document.getElementById('palabra').remove();
                    $('#pala').append('<input name="palabraNueva" id="palabraN">');

                }else{
                    document.getElementById('palabraN').remove();
                    palabrasL();
                }
            });

            $('#TPA').change(function() {
                var selectedOption = this.options[this.selectedIndex];
                seleccionado = selectedOption.text;

                if(seleccionado == 'Folleto'){
                    document.getElementById('omar').style.visibility = "hidden";
                    document.getElementById('olas').checked = true;
                    document.getElementById('arch').disabled = false;

                }else{
                    document.getElementById('omar').style.visibility = "visible";
                    document.getElementById('olas').checked = false;
                    document.getElementById('arch').disabled = true;
                }
            });
        });

        return;

    } catch (error) {
        console.log(error);
        return;
    }
}
