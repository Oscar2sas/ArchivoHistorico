$(document).ready(function() {
    $('#opcion1').change(function() {
        var selectedOption = this.options[this.selectedIndex];
        seleccionado = selectedOption.text;
        Imprimiri(seleccionado);
    });


});



const Imprimiri = (sas) =>{

    if (sas == 'Biblioteca') {
        $('#sas').remove();
        biblioteca();
    }else{
    const coso = "<div id='sas'><h1>"+ sas +"</h1></div>";
    $('#sas').remove();
    $('#formulario').append(coso);}
    
}

const biblioteca = async() =>{
    const data = new FormData();

    data.append('accion','biblioteca');

    const URL = 'modeloimagen.php';
    const CONFIG = {
        method: 'POST',
        body: data
    };

    try {
        const enviar = await fetch(URL, CONFIG);
        const recibir = await enviar.json();
        
        $('#formulario').append(`${recibir}`);
        $('#sas').ready(function() {
            $('#olas').change(function() {
                if(this.checked){
                    document.getElementById('arch').disabled = false;
                    document.getElementById('tapa').disabled = true;
                    document.getElementById('indice').disabled = true;
                    document.getElementById('ct').disabled = true;
                }else{
                    document.getElementById('arch').disabled = true;
                    document.getElementById('tapa').disabled = false;
                    document.getElementById('indice').disabled = false;
                    document.getElementById('ct').disabled = false;
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
