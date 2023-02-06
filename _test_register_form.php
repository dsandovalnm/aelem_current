<?php require_once('models/dbconnect.php'); ?>
<?php include('includes/header.php');?>
    
    <body>
        <section class="p-0">
            <div class="hero-area bg-img background d-flex justify-content-center align-center background-overlay"
                style=" background-image: url(img/register-img/registro_header.jpg);
                        background-position: bottom;
                        background-size: cover;
                        height:300px;
                        position:relative;
                        background-attachment:initial;">

                <div class="container d-flex flex-column justify-content-center align-center">
                    <h1 class="mx-auto text-center" style="color:#fff;font-weight:bold;">Formulario de registro</h3>
                </div>
            </div>
        </section>

        <div class="container py-5">
            <h6 class="text-center mx-auto" style="width:75%;">Realizando la siguiente suscripción mensual tendrás acceso total a los seminarios y cursos de plataforma online Ayuda en las Emociones</h6>
            <form id="register_form" class="general_form" method="post">
                <div class="form-group" autocomplete="off">
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombres" required autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido" required autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="pais" name="pais" placeholder="País" required autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="email" name="email" describedby="emailHelp" placeholder="Email" required autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono" required autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="profesion" name="profesion" placeholder="Profesion" required autocomplete="off">
                </div>
                <div class="form-group">
                    <select class="form-control" name="conocio" id="conocio" rquired autocomplete="off">
                        <option disabled selected>¿Por qué medio conociste de nosotros?</option>
                        <option value="wa">Whatsapp</option>
                        <option value="fb">Facebook</option>
                        <option value="in">Instagram</option>
                        <option value="re">Recomendación Amigo</option>
                        <option value="ot">Otro</option>
                    </select>
                </div>
                <div class="form-check text-center">
                    <input class="form-check-input position-relative" type="checkbox" id="acepto" name="acepto">
                    <label class="form-check-label" for="acepto" style="width:90%;">
                        <p style="font-size:15px;">Acepto realizar un pago de débito mensual durante 5 meses mínimo</p>
                    </label>
                </div>
                <div class="precios-box d-flex justify-content-center">
                    <div class="argentina d-flex flex-column mt-4 mx-5 text-center">
                        <p>Argentina</p>
                        <p>ARS 1200</p>
                    </div>
                    <div class="exterior d-flex flex-column mt-4 mx-5 text-center">
                        <p>Exterior</p>
                        <p>USD 15</p>
                    </div>
                </div>
                <div class="g-recaptcha mx-auto" data-sitekey="6LeYTeAUAAAAAOdfUtvojoi5b-MwZJn32IZZWQ3b"></div>
                <div class="boton-box p-5">
                    <button id="submit_btn" class="btn btn-info btn-rounded d-block mx-auto">Registrarme</button>
                </div>
            </form>
        </div>

        <!-- SweetAlerts2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.9.0/dist/sweetalert2.all.min.js"></script>

        <script>
            let submit = document.getElementById('submit_btn');

            submit.addEventListener('click', e =>{
                
                e.preventDefault();

                let nombre = document.getElementById('nombre').value;
                let apellido = document.getElementById('apellido').value;
                let pais = document.getElementById('pais').value;
                let email = document.getElementById('email').value;
                let telefono = document.getElementById('telefono').value;
                let profesion = document.getElementById('profesion').value;
                let conocio = document.getElementById('conocio').value;
                let acepto = document.getElementById('acepto').checked;

                if(nombre == '' || apellido == ''
                    || pais == '' || email == '' || telefono == ''
                    || profesion == '' || conocio == '' || acepto == false) {

                        Swal.fire({
                            title: 'No se pudo realizar el registro!',
                            text: 'Todos los campos deben estar completados',
                            icon: 'warning',
                            showConfirmButton: true,
                            confirmButtonColor: '#ffbb33',
                            confirmButtonText: 'Verificar'
                        })
                    }else {

                        let emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

                        if(!emailRegex.test(email)) {
                            Swal.fire({
                                title: 'Verifica el correo!',
                                text: 'La dirección de correo no es válida',
                                icon: 'warning',
                                showConfirmButton: true,
                                confirmButtonColor: '#ffbb33',
                                confirmButtonText: 'Verificar'
                            })
                        }else {
                            sendForm();
                        }

                    }

                function sendForm(){

                    let xhr = new XMLHttpRequest();
                    let form = document.getElementById('register_form');

                    xhr.open('POST','/register.php');

                    xhr.upload.onprogress = () => {
                        Swal.fire({
                            title: 'Registrando Usuario...',
                            html: ` <div class="spinner-border text-info" role="status" style="width:60px;height:60px">
                                        <span class="sr-only">Cargando...</span>
                                    </div>`,
                            showConfirmButton: false
                        });
                    }
                    
                    xhr.onload = ()=>{

                        response = xhr.response;
                        message = xhr.message;
                        
                        if(xhr.status == 200) {      

                            response = JSON.parse(response);  
                            message = response.message;

                            if(response.state == 'correcto') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Bienvenido!',
                                    text: `${message}`,
                                    showConfirmButton: true,
                                    confirmButtonText: 'Realizar Pago',
                                    showCancelButton: false
                                }).then((result) => {
                                    window.location = 'portalpagos';
                                });
                            }else {

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Hubo un error!',
                                    text: `${message}`
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