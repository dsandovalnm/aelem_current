// @ts-nocheck
(function(){
    'use strict';

    let recoveryPassBtn = document.getElementById('recovery-pass-btn');
    let email = document.getElementById('email');
    let emailRegex = /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;

    recoveryPassBtn.addEventListener('click', e => {
        e.preventDefault();

        if(email.value == '') {
            Swal.fire({
                icon : 'error',
                title : 'Usuario Incorrecto',
                text : 'Debes ingresar una dirección de mail'
            });
        }else if(!emailRegex.test(email.value)) {
            Swal.fire({
                icon: 'warning',
                title: 'Correo no válido',
                text: 'Por favor revisa que la cuenta de correo sea correcta',
                showConfirmButton: true,
                confirmButtonText: 'Verificar',
                showCancelButton: false
            });
        }else {

            let xhr = new XMLHttpRequest();
            let recoveryPassForm = document.getElementById('recovery-pass-form');

            xhr.open('POST', 'recovery.php');

            xhr.upload.onprogress = () => {
                Swal.fire({
                    title: 'Verificando Cuenta',
                    html: ` <div class="spinner-border text-info" role="status" style="width:60px;height:60px">
                                <span class="sr-only">Cargando...</span>
                            </div>`,
                    showConfirmButton: false
                });
            }

            xhr.onload = () => {

                // document.write(xhr.response);
                console.log(xhr.response);

                if(xhr.status === 200) {
                    let res = JSON.parse(xhr.response);

                    if(res.status === true) {
                        Swal.fire({
                            icon : 'success',
                            title : res.title,
                            text : res.text,
                            timer : 5000,
                            timerProgressBar : true,
                            onClose : () => {
                                window.location.href = '/plataforma'
                            }
                        });
                    }else {
                        Swal.fire({
                            icon : 'error',
                            title : res.title,
                            text : res.text
                        });
                    }
                }
            }

            xhr.send(new FormData(recoveryPassForm));
        }
    });

})(); 