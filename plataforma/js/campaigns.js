import * as myFunctions from './Functions.js';

(function(){

    'use strict'

    let submit = document.getElementById('upd_btn');
    let new_link = document.getElementById('new_link');
    let current_link = document.getElementById('current_link');

    submit.addEventListener('click', e =>{
        
        e.preventDefault();

        if(new_link.value == '') {
            Swal.fire({
                icon: 'error',
                title: 'Debes poner un nuevo enlace',
                text: 'El enlace debe ser diferente al actual',
                showConfirmButton: true,
                confirmButtonColor: 'info',
                confirmButtonText: 'Aceptar'
            })
        }else {

            if(new_link.value == current_link.value) {
                Swal.fire({
                    icon: 'error',
                    title: 'Debes poner un nuevo enlace',
                    text: 'El enlace debe ser diferente al actual',
                    showConfirmButton: true,
                    confirmButtonColor: 'info',
                    confirmButtonText: 'Aceptar'
                })
            }else {
                let urlRegEx = /^https?:\/\/[\w\-]+(\.[\w\-]+)+[/#?]?.*$/;

                if(!urlRegEx.test(new_link.value)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'El formato de enlace no es correcto',
                        text: 'Debe ser similar a "https://ejemplo.algo/opcional',
                        showConfirmButton: true,
                        confirmButtonColor: 'info',
                        confirmButtonText: 'Aceptar'
                    })
                }else {
                    Swal.fire({
                        title: '¿Desea actualizar y guardar cambios?',
                        showConfirmButton: true,
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        confirmButtonText: 'Actualizar',
                        cancelButtonColor: '#dc3545',
                        cancelButtonText: 'Cancelar',
                    }).then((res)=>{
                        if(res.value) {

                            let formCampaign = document.getElementById('update-campaign-form');
                            myFunctions.execAjax('add', '_Campaigns.php', formCampaign);
                            
                        }
                    });
                }
            }
        }
    });

})();