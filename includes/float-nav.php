
<div class="float-nav">
    <!-- <div class="nav-opt">
        <a href="faq">
            <i class="far fa-question-circle float-nav-icon"></i>
        </a>
    </div> -->
    <div class="nav-opt">
        <a href="#" data-toggle="modal" data-target="#modal-message">
            <i class="fas fa-envelope-open-text float-nav-icon"></i>
        </a>
    </div>
    <div class="nav-opt">
        <a href="/campana">
            <i class="fab fa-whatsapp float-nav-icon"></i>
        </a>
    </div>
</div>


<!-- Modal Envío Mensaje -->
<div id="modal-message" class="modal fade bd-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
    <div class="modal-content"
        style=" padding: 15px;
                top: 10vh;
                background-color: rgba(255,255,255,0.7);">
        <div class="modal-header">
            <h5 class="title text-center">Envíanos tu consulta</h5>
            <i class="far fa-times-circle close" data-dismiss="modal" aria-label="Close" style="cursor:pointer;font-size:40px;"></i>
        </div>
        <div class="box col-12 d-flex flex-wrap justify-content-center align-items-center">
            <form id="formulario-consulta" class="py-5" method="post">
                <div class="form-group" autocomplete="off">
                    <input type="text" class="form-control" id="nombre_consulta" name="nombre_consulta" placeholder="Nombre" required autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="apellido_consulta" name="apellido_consulta" placeholder="Apellido" required autocomplete="off">
                </div>
                <div class="form-group">
                    <select name="pais_consulta" id="pais_consulta" class="form-control" required autocomplete="off">
                            <option disabled selected>Eliga su país de residencia</option>
                        <?php
                            foreach($paises as $pais) {
                                echo '
                                    <option value="'.$pais['indicativo'].'">'.$pais['nombre'].'</option>
                                ';
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="telefono_consulta" name="telefono_consulta" placeholder="Telefono" required autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="email_consulta" name="email_consulta" describedby="emailHelp" placeholder="Email" required autocomplete="off">
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="consulta" name="consulta" rows="3" placeholder="Escriba su consulta..."></textarea>
                </div>
                <div class="g-recaptcha" data-sitekey="6LeYTeAUAAAAAOdfUtvojoi5b-MwZJn32IZZWQ3b" style="margin: 0 auto;"></div>
                <button id="enviar_consulta_btn" type="submit" class="btn btn-info btn-block">Enviar</button>
            </form>
        </div>
    </div>
    </div>
</div>

<script>

let enviarConsultaBtn = document.getElementById('enviar_consulta_btn');
let nombreConsulta = document.getElementById('nombre_consulta');
let apellidoConsulta = document.getElementById('apellido_consulta');
let paisConsulta = document.getElementById('pais_consulta');
let telefonoConsulta = document.getElementById('telefono_consulta');
let emailConsulta = document.getElementById('email_consulta');

enviarConsultaBtn.addEventListener('click', e =>{
    
    e.preventDefault();

if( nombreConsulta.value == '' || apellidoConsulta.value == '' || emailConsulta.value == ''
    || paisConsulta.value == '' || telefonoConsulta.value == '' ) {
    Swal.fire({
        icon: 'warning',
        title: 'Verifica tus datos!',
        text: 'Todos los campos deben ser completados',
        showConfirmButton: true,
        confirmButtonColor: 'info',
        confirmButtonText: 'Verificar'
    })
}else {

    let emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

    if(telefonoConsulta.value.length < 10) {
        Swal.fire({
            icon: 'warning',
            title: 'Verifica el número de teléfono!',
            text: 'El número de teléfono no es válido',
            showConfirmButton: true,
            confirmButtonColor: 'info',
            confirmButtonText: 'Verificar'
        })
    }else if(!emailRegex.test(emailConsulta.value)) {
        Swal.fire({
            icon: 'warning',
            title: 'Verifica el correo!',
            text: 'La dirección de correo no es válida',
            showConfirmButton: true,
            confirmButtonColor: 'info',
            confirmButtonText: 'Verificar'
        })
    }else {
        
        sendForm();

    }
}

    function sendForm(){

        let xhr = new XMLHttpRequest();
        let form = document.getElementById('formulario-consulta');

        xhr.open('POST','/enviar_consulta.php');

        xhr.upload.onprogress = () => {
            Swal.fire({
                title: 'Enviando tu consulta...',
                html: ` <div class="spinner-border text-info" role="status" style="width:60px;height:60px">
                            <span class="sr-only">Cargando...</span>
                        </div>`,
                showConfirmButton: false
            });
        }
        
        xhr.onload = ()=>{

            let response = xhr.response;
            
            if(xhr.status == 200) {     

                let res = JSON.parse(response);

                console.log(res.status);

                if(res.status === 'captcha_false') {
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de autenticación',
                        text: `${res.mensaje}`,
                        showConfirmButton: true,
                        confirmButtonText: 'Aceptar'
                    });

                }else if(!res.status) {

                    Swal.fire({
                        icon: 'error',
                        title: 'Mensaje no enviado',
                        text: `${res.mensaje}`,
                        showConfirmButton: true,
                        confirmButtonText: 'Aceptar'
                    });

                }else if(res.status) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Mensaje Enviado',
                        text: `${res.mensaje}`,
                        showConfirmButton: true,
                        confirmButtonText: 'Aceptar'
                    });

                    form.reset();
                }
            }
        }
        xhr.send(new FormData(form));
    }
});

/* Phone Number AreaCode */
    /* let pais = document.getElementById('pais');
    let telefono = document.getElementById('telefono'); */

    paisConsulta.onchange = function() {
            telefonoConsulta.value = this.value;
            if((this.value).trim() != '') {
                telefonoConsulta.disabled = false;
        } else {
                telefonoConsulta.disabled = true
        }
    }

    telefonoConsulta.onkeyup = function(e) {
            let nums_v = this.value.match(/\d+/g);
        if (nums_v != null) {
            this.value = '+'+((nums_v).toString().replace(/\,/, ''));
        } else { 
                this.value = paisConsulta.value;
            }
    }
    /* End Phone Number AreaCode */
</script>