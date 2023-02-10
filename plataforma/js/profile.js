import * as myFunctions from './Functions.js';
(function(){
    'use strict';

    /* UPDATE PROFILE */
        let nombre = document.getElementById('nombre');
        let apellido = document.getElementById('apellido');
        let pais = document.getElementById('pais');
        let email = document.getElementById('email');
        let telefono = document.getElementById('telefono');
        let profesion = document.getElementById('profesion');

        let updateProfileForm = document.getElementById('edit-profile-form');
        let updateProfileBtn = document.getElementById('update-profile-btn');

        let password = document.getElementById('password');
        let repeatPassword = document.getElementById('r-password');

        let updatePasswordForm = document.getElementById('change-pswd-form');
        let updatePasswordBtn = document.getElementById('change-pswd-btn');


    /* RECORTAR Y AJUSTAR IMAGEN DE PERFIL */
        let profPicture = document.getElementById('prof-picture');
        let cancelCropBtn = document.getElementsByClassName('cancel-crop');
        let usuarioEmail = document.getElementById('email');
        let uploadImageModal = $('#uploadImageModal');

        let imageCrop = $('#image-demo').croppie({
            enableExif : true,
            viewport : {
                width : 280,
                height : 280,
                type : 'circle'
            },
            boundary : {
                width : 300,
                height : 300
            }
        });

        profPicture.addEventListener('change', () => {

            let reader = new FileReader();

            reader.onload = e => {
                imageCrop.croppie('bind', {
                    url : e.target.result
                });
                 // .then( () => console.log('jQuery bind Image Croppie completed') );
            }

            reader.readAsDataURL(profPicture.files[0]);
            uploadImageModal.modal('show');
        });

    /* ACEPTAR CAMBIOS Y RECORTAR IMAGEN */
            let cropImgBtn = document.getElementById('crop-img-btn');
            let pictureBox = document.getElementById('img-up');            

            cropImgBtn.addEventListener('click', e => {
                imageCrop.croppie('result', {
                    type : 'canvas',
                    size : 'viewport'
                }).then( res => {
                    $.ajax({
                        url : 'models/_Profile.php',
                        type : 'POST',
                        data : {
                            'image' : res,
                            'userEmail' : `${usuarioEmail.value}`,
                            'action' : 'crop-image'
                        },
                        success : data => {
                            // document.write(data);
                            uploadImageModal.modal('hide');
                            pictureBox.setAttribute('src', data);
                            profPicture.value = '';
                        }
                    });
                });
            });

        /* CANCELAR RECORTE DE IMAGEN */
            for(let i=0; i<cancelCropBtn.length; i++) {
                cancelCropBtn[i].addEventListener('click', e => {
                    profPicture.value = '';
                });
            }



    /* UPDATE PROFILE BTN */
        updateProfileBtn.addEventListener('click', e => {
            e.preventDefault();

            if(myFunctions.validateFormFields(updateProfileForm)) {
                if(myFunctions.validateEmail(email.value)) {

                    myFunctions.execAjax('edit', '_Profile.php', updateProfileForm);

                }else {
                    Swal.fire({
						icon : 'warning',
						title : 'Email Incorrecto',
						text : 'La dirección de correo no tiene un formato correcto',
						showConfirmButton : true,
						confirmButtonText : 'Verificar',
						confirmButtonColor : '#17a2b8'
					});
                }
                
            }else {
                Swal.fire({
                    icon : 'warning',
                    title : 'Campos Incompletos',
                    text : 'Todos los campos son obligatorios',
                    showConfirmButton : true,
                    confirmButtonText : 'Verificar',
                    confirmButtonColor : '#17a2b8'
                });
            }
        });



    /* UPDATE PASSWORD BTN */
        updatePasswordBtn.addEventListener('click', e => {
            e.preventDefault();

            if(myFunctions.validateFormFields(updatePasswordForm)){
                if(myFunctions.validatePassword(password.value)) {
                    if(myFunctions.comparePasswords(password.value, repeatPassword.value)) {

                        myFunctions.execAjax('edit', '_Profile.php', updatePasswordForm);

                    }else {
                        Swal.fire({
                            icon : 'warning',
                            title : 'Las contraseñas no coinciden',
                            text : 'Las contraseñas deben ser exactamente iguales',
                            showConfirmButton : true,
                            confirmButtonText : 'Verificar',
                            confirmButtonColor : '#17a2b8'
                        });
                    }
                }else {
                    Swal.fire({
                        icon : 'warning',
                        title : 'Contraseña Inválida',
                        html : `
                            <p>La contraseña debe:</p>
                            <p>- Tener mínimo 8 caracteres y máximo 16</p>
                            <p>- Contener al menos 1 dígito o caracter numérico</p>
                            <p>- Tener una minúscula</p>
                            <p>- Tener una mayúscula</p>								
                        `,
                        showConfirmButton : true,
                        confirmButtonText : 'Verificar',
                        confirmButtonColor : '#17a2b8'
                    });
                }
            }else {
                Swal.fire({
                    icon : 'warning',
                    title : 'Campos Incompletos',
                    text : 'Todos los campos son obligatorios',
                    showConfirmButton : true,
                    confirmButtonText : 'Verificar',
                    confirmButtonColor : '#17a2b8'
                });
            }

        });    
})();