<?php

    if(!isset($_GET['codigo']) || is_null($_GET['codigo'] || empty($_GET['codigo']))) {
        echo '
            <script>
                alert("Lo sentimos, no hemos encontrado este articulo, intenta nuevamente");
                window.location.href="downloads";
            </script>
        ';
    }
    include_once('controllers/Paises.php');
    include_once('controllers/Descargas.php');

    $pa = new Pais();
    $paises = $pa->getPaises();

    $desc = new Descarga;
    $item = $desc->getItemDescarga($_GET['codigo']);

    $material = $desc->getDescargasMaterial($item['nombre'],$item['categoria']);
    
    if($material !== NULL) {
        $count = count($material);
    }else {
        $count = 0;
    }

    if($item == NULL) {
        echo '
            <script>
                alert("Lo sentimos, no hemos encontrado este articulo, intenta nuevamente");
                window.location.href="downloads";
            </script>
        ';
    }

    $tipo = '';

    switch($item['categoria']) {
        case 11 :
            $tipo = 'Libro';
            break;
        case 12 :
            $tipo = 'Audio';
            break;
        case 13:
            $tipo = 'Melodía';
            break;
        case 14:
            $tipo = 'Video';
            break;
    }
?>
<html>
    <!-- Header -->
    <?php include_once 'includes/header.php'; ?>
    <!-- Fin Header -->

    <body>

        <?php include_once 'includes/nav-bar.php'; ?>

        <div class="hero d-flex justify-content-center align-items-center"
            style=" background-image: url('img/cursos-img/elaboracion_duelo/head.jpg');
                    background-repeat: no-repeat;
                    background-position: center;
                    background-size:cover;
                    height:50vh;">
            <div class="container d-flex flex-column justify-content-center align-center">
                <h1 class="mx-auto text-center" style="color:#fff;font-weight:bold;">
                    <?php 
                        echo $item['pago'] === '1' ? 'Formulario de Compra' : 'Formulario de Descarga';
                    ?>
                </h3>
                <h3 class="mx-auto text-center" style="color:#fff;"><?php echo $tipo . ' ' . $item['nombre'] ?></h5>
            </div>
        </div>

        <div class="container py-5">
            <h3 class="text-uppercase text-center py-3">Campaña Solidaria de Ayuda Emocional</h3>
            <div class="box col-xs-12 d-flex flex-wrap justify-content-center align-items-center">
              <div class="download-form col-xs-12 col-sm-6">
                <h5 class="text-center">
                    Completa los datos para <?php echo $item['pago'] === '1' ? 'realizar la compra de:' : 'descargar de forma gratuita:'; ?> <br/>
                    "<?php echo $tipo . ' <strong>' . $item['nombre'] ?>"</strong>
                </h5>
                <form id="download-form" class="py-5" method="post">
                        <?php if($item['pago'] == 1) : 
                                $precio = $country === 'Argentina' ? $item['precio_arg'] : $item['precio_ext'];
                            ?>
                                <input type="hidden" class="form-control" id="precio_item" name="precio_item" value="<?php echo $precio ?>">
                                <input type="hidden" class="form-control" id="cantidad_item" name="cantidad_item" value="1">
                            <?php endif; ?>
                        <input type="hidden" class="form-control" id="tipo_pago" name="tipo_pago" value="<?php echo($item['pago']) ?>">
                        <input type="hidden" class="form-control" id="item_nombre" name="item_nombre" value="<?php echo($item['nombre']) ?>">
                        <input type="hidden" class="form-control" id="categoria" name="categoria" value="<?php echo($item['categoria']) ?>">
                        <input type="hidden" class="form-control" id="ruta" name="ruta" value="<?php echo($item['ruta']) ?>">
                    <div class="form-group" autocomplete="off">
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Apellido" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <select name="pais" id="pais" class="form-control" required autocomplete="off">
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
                        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Telefono" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email" describedby="emailHelp" placeholder="Email" required autocomplete="off">
                    </div>
                    <?php if($item['pago'] === '1') : ?>
                        <button id="purshase_btn" type="submit" class="btn btn-info btn-block">Comprar Ahora!</button>
                    <?php else : ?>
                        <button id="download_btn" type="submit" class="btn btn-info btn-block">Descargar Ahora!</button>
                        <p class="py-1 my-2 text-center" 
                        style="    border-top: 1px solid #48afc5;
                                border-bottom: 1px solid #48afc5;">Número total de descargas: <?php echo $count; ?>
                        </p>
                    <?php endif; ?>                    
                </form>
              </div>
              <div class="image col-xs-12 col-sm-6 position-relative">
                <img src="img/material-img/<?php echo $item['imagen'] ?>" class="d-block mx-auto" alt="">
              </div>
            </div>
        </div>

        <!-- Descarga Contenido -->
        <script>

            let submit = document.getElementById('download_btn') !== null ? document.getElementById('download_btn') : document.getElementById('purshase_btn');
            let pago = document.getElementById('tipo_pago').value;

            let nombre = document.getElementById('nombre');
            let apellido = document.getElementById('apellido');
            let pais = document.getElementById('pais');
            let telefono = document.getElementById('telefono');
            let email = document.getElementById('email');

            submit.addEventListener('click', e =>{
                
                e.preventDefault();

                if(nombre.value == '' || apellido.value == '' || email.value == ''
                || pais.value == '' || telefono.value == '') {
                Swal.fire({
                    title: 'Verifica tus datos!',
                    text: 'Todos los campos deben ser completados',
                    showConfirmButton: true,
                    confirmButtonColor: 'info',
                    confirmButtonText: 'Verificar'
                })
            }else {

                let emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

                if(telefono.value.length < 10) {
                    Swal.fire({
                        title: 'Verifica el número de teléfono!',
                        text: 'El número de teléfono no es válido',
                        showConfirmButton: true,
                        confirmButtonColor: 'info',
                        confirmButtonText: 'Verificar'
                    })
                }else if(!emailRegex.test(email.value)) {
                    Swal.fire({
                        title: 'Verifica el correo!',
                        text: 'La dirección de correo no es válida',
                        showConfirmButton: true,
                        confirmButtonColor: 'info',
                        confirmButtonText: 'Verificar'
                    })
                }else {
                    
                    sendForm(pago);

                }
            }

                function sendForm(tipoPago){

                    let xhr = new XMLHttpRequest();
                    let form = document.getElementById('download-form');

                    xhr.open('POST','verify-data.php');

                    xhr.upload.onprogress = () => {
                        if(tipoPago === '0') {
                            Swal.fire({
                                title: 'Preparando tu descarga, en breve tendrás el material',
                                html: ` <div class="spinner-border text-info" role="status" style="width:60px;height:60px">
                                            <span class="sr-only">Cargando...</span>
                                        </div>`,
                                showConfirmButton: false
                            });
                        }else {
                            Swal.fire({
                                title: 'Verificando datos',
                                html: ` <div class="spinner-border text-info" role="status" style="width:60px;height:60px">
                                            <span class="sr-only">Cargando...</span>
                                        </div>`,
                                showConfirmButton: false
                            });
                        }
                    }
                    
                    xhr.onload = ()=>{

                        response = xhr.response;

                        console.log(response.pago);
                        
                        if(xhr.status == 200) {

                            res = JSON.parse(response);

                            if(res.usuario === 'nuevo') {
                                if(tipoPago === '1') {
                                    window.location.href = '/pagar.php';
                                }else {
                                    Swal.fire({
                                        title: 'Listo!',
                                        html: ` <p>Ya puedes descargar tu contenido</p>
                                                <a href="${res.contenido}" target="_blank" class="btn btn-info" download>Descargar Ahora</a>`,
                                        showCloseButton: true,
                                        onClose: () => {
                                            window.location.href = 'downloads';
                                        },
                                        showConfirmButton: false,
                                    });
                                }
                            }else {
                                if(tipoPago === '1') {
                                    Swal.fire({
                                        html: ` <h6 class="font-weight-bold">Ya has comprado este artículo con esta cuenta de mail</h6>
                                                <p>Si deseas podemos reenviarte el enlace de descarga a esta cuenta de correo</p>`,
                                        showCloseButton: true,
                                        showConfirmButton: true,
                                        confirmButtonText: 'Enviar enlace',
                                        showConfirmButton: false,
                                    }).then( res => {
                                        if(res.isConfirmed) {
                                            window.location.href = '/sendMail.php'
                                        }
                                    });
                                }else {
                                    Swal.fire({
                                        html: ` <h6 class="font-weight-bold">Ya has descargado este contenido con esta cuenta de mail</h6>
                                                <p>Recuerda guardalo en tu dispositivo</p>
                                                <a href="${res.contenido}" class="btn btn-info btn-block" download>Volver a descargar</a>`,
                                        showCloseButton: true,
                                        onClose: () => {
                                            window.location.href = 'downloads';
                                        },
                                        showConfirmButton: false,
                                    });
                                }
                            }
                        }
                    }
                    xhr.send(new FormData(form));
                }
            });

            /* Phone Number AreaCode */
                /* let pais = document.getElementById('pais');
                let telefono = document.getElementById('telefono'); */

                pais.onchange = function() {
                        telefono.value = this.value;
                        if((this.value).trim() != '') {
                            telefono.disabled = false;
                    } else {
                            telefono.disabled = true
                    }
                }

                telefono.onkeyup = function(e) {
                        let nums_v = this.value.match(/\d+/g);
                    if (nums_v != null) {
                        this.value = '+'+((nums_v).toString().replace(/\,/, ''));
                    } else { 
                            this.value = pais.value;
                        }
                }
            /* End Phone Number AreaCode */

        </script>

        <!-- ***** Footer Area Start ***** -->
        <?php include('includes/footer.php');?>
        <!-- ***** Footer Area End ***** -->
    </body>
</html>