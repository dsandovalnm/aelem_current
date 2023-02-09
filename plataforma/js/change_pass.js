(function(){
    'use strict';

    let changePassBtn = document.getElementById('change-pass-btn');
    let password = document.getElementById('password');
    let repeatPassword = document.getElementById('r-password');
    let email = document.getElementById('email');

    changePassBtn.addEventListener('click', e => {
        e.preventDefault();

        if(password.value == '' || repeatPassword.value == '') {
            Swal.fire({
                icon : 'error',
                title : 'Contraseña no válida',
                text : 'Es necesario completar ambos campos'
            });
        }else if(password.value !== repeatPassword.value) {
            Swal.fire({
                icon: 'error',
                title: 'Las contraseñas no coinciden',
                text: 'Por favor revisa que las contraseñas sean exactamente iguales',
            });
        }else {

            let xhr = new XMLHttpRequest();
            let changePassForm = document.getElementById('change-pass-form');

            xhr.open('POST', 'recovery.php');

            xhr.upload.onprogress = () => {
                Swal.fire({
                    title: 'Realizando Cambios...',
                    html: ` <div class="spinner-border text-info" role="status" style="width:60px;height:60px">
                                <span class="sr-only">Cargando...</span>
                            </div>`,
                    showConfirmButton: false
                });
            }

            xhr.onload = () => {

                // document.write(xhr.response);

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

            xhr.send(new FormData(changePassForm));
        }
    });

})(); 