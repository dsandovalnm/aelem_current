<!DOCTYPE html>
<html>
    
    <?php include_once('includes/header.php') ?>

    <body>     

        <section class="contact-area p-0">
            <div class="hero-area bg-img background d-flex justify-content-center align-center"
                style=" background-image: url(img/cursos-img/elaboracion_duelo/head.jpg);
                        height:300px;
                        position:relative;
                        background-attachment:fixed;">

                <div class="container d-flex flex-column justify-content-center align-center">
                    <h1 class="mx-auto text-center" style="color:#fff;font-weight:bold;">Formulario de registro</h3>
                    <h3 class="mx-auto text-center" style="color:#fff;">Libro Vivir Tranquilo</h5>
                </div>
            </div>
        </section>

        <div class="container py-5">
            <h4 class="text-center">Completa todos los datos del formulario para que puedas acceder al material</h4>
            <form id="form_elaboracion" class="general_form" method="post">
                <div class="form-group" autocomplete="off">
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombres" required autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido" required autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="provincia" name="provincia" placeholder="Provincia" required autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="pais" name="pais" placeholder="País" required autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="edad" name="edad" placeholder="Edad" required autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="email" name="email" describedby="emailHelp" placeholder="Email" required autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono" required autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Ingresa una contraseña" required autocomplete="off">
                    <small>Con esta contraseña tendrás acceso a la plataforma</small>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="repeat_password" name="repeat_password" placeholder="Confirme la contraseña" required autocomplete="off">
                    <small>Ingresa nuevamente la contraseña</small>
                </div>
                <!-- <div class="form-group g-recaptcha" data-sitekey="6LcL2bAUAAAAAKgZDev2byya2E7afbcsnOX54e4l"></div> -->
                <button id="submit_btn" class="btn btn-info btn-rounded d-block mx-auto">Registrarme</button>
            </form>
        </div>

        <script>
            let submit = document.getElementById('submit_btn');

            submit.addEventListener('click', e =>{
                
                e.preventDefault();

                let nombre = document.getElementById('nombre').value;
                let apellido = document.getElementById('apellido').value;
                let provincia = document.getElementById('provincia').value;
                let pais = document.getElementById('pais').value;
                let edad = document.getElementById('edad').value;
                let email = document.getElementById('email').value;
                let telefono = document.getElementById('telefono').value;
                let password = document.getElementById('password').value;
                let repeat_password = document.getElementById('repeat_password').value;

                if(nombre == '' || apellido == ''
                    || provincia == '' || pais == ''
                    || edad == '' || email == '' || telefono == ''
                    || password == '' || repeat_password == '') {

                        Swal.fire({
                            title: 'No se pudo enviar el formulario!',
                            text: 'Todos los campos deben estar completados',
                            showConfirmButton: true,
                            confirmButtonColor: 'info',
                            confirmButtonText: 'Verificar'
                        })
                    }else {

                        let emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

                        if(!emailRegex.test(email)) {
                            Swal.fire({
                                title: 'Verifica el correo!',
                                text: 'La dirección de correo no es válida',
                                showConfirmButton: true,
                                confirmButtonColor: 'info',
                                confirmButtonText: 'Verificar'
                            })
                        }else {
                            if(password != repeat_password) {
                                Swal.fire({
                                    title: 'Verifica la contraseña!',
                                    text: 'Las contraseñas deben ser iguales',
                                    showConfirmButton: true,
                                    confirmButtonColor: 'info',
                                    confirmButtonText: 'Verificar'
                                })
                            }else {

                                sendForm();
                            }
                        }

                    }

                function sendForm(){

                    let xhr = new XMLHttpRequest();
                    let form = document.getElementById('form_elaboracion');

                    xhr.open('POST','elaboracion_perdidas_registro.php');

                    xhr.upload.onprogress = () => {
                        Swal.fire({
                            title: 'Realizando registro...',
                            html: ` <div class="spinner-border text-info" role="status" style="width:60px;height:60px">
                                        <span class="sr-only">Cargando...</span>
                                    </div>`,
                            showConfirmButton: false
                        });
                    }
                    
                    xhr.onload = ()=>{

                        response = xhr.response;
                        message = xhr.message;

                        document.write(response);
                        
                        if(xhr.status == 200) {      

                            response = JSON.parse(response);  
                            message = response.message;                    

                            if(response.state == 'correcto') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Bienvenido!',
                                    text: `${message}`,
                                    showConfirmButton: true,
                                    confirmButtonText: 'Iniciar Sesión',
                                    showCancelButton: true,
                                    cancelButtonText: 'Registrar otra cuenta'
                                }).then((result) => {
                                    if(result.value) {
                                        window.location = 'elaboracion_login.php';
                                    }else {
                                        window.location = 'elaboracion_perdidas_formulario.php';
                                    }
                                });
                            }else {

                                Swal.fire({
                                    icon: 'error',
                                    title: `${message}`,
                                    text: 'Este correo ya fue registrado, por favor ingresa uno nuevo'
                                });
                            }
                            
                        }else {

                            Swal.fire({
                                icon: 'error',
                                title: `${message}`,
                                text: 'Por favor intenta nuevamente o contactanos a soporte@ayudaenlasemociones.com'
                            });
                        }
                    }
                    xhr.send(new FormData(form));
                }
            });
        </script>

        <!-- ***** Footer Area Start ***** -->
        <?php include('includes/footer.php');?>
        <!-- ***** Footer Area End ***** -->
    </body>
</html>