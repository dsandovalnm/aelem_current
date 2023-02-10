// @ts-nocheck
import * as myFunctions from './Functions.js';

(function(){

    'use strict';

        /* MODIFICAR ESTADO DE SUSCRIPCION PREMIUM */
    let subscriptionBtn = document.getElementsByClassName('subscription-btn');

    if(subscriptionBtn.length > 0) {
        for(let i=0; i<subscriptionBtn.length; i++) {
            subscriptionBtn[i].addEventListener('click', e => {

                e.preventDefault();

                let formId = subscriptionBtn[i].getAttribute('data-id-form');
                let action = subscriptionBtn[i].getAttribute('data-action');
                let subscriptionForm = '';

                subscriptionForm = (action === 'cancel') ? document.getElementById(`c-subscription-form-${formId}`) : document.getElementById(`subscription-form-${formId}`);

                    if(action === 'cancel') {
                        Swal.fire({
                            title: '¿Está Seguro?',
                            text: 'Al cancelar la suscripción, esta no podrá volverse a reactivar',
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#28a745',
                            showCancelButton: true,
                            cancelButtonText: 'Cancelar',
                            cancelButtonColor: '#dc3545'
                        }).then( res => {
                            if(res.value) {
                                myFunctions.execAjax('add', '_Suscripciones.php', subscriptionForm);
                            }
                        });
                    }else {
                        Swal.fire({
                            title: '¿Está Seguro?',
                            text: 'Va a modificar el estado de la suscripción y afectará la visualización del contenido',
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#28a745',
                            showCancelButton: true,
                            cancelButtonText: 'Cancelar',
                            cancelButtonColor: '#dc3545'
                        }).then( res => {
                            if(res.value) {
                                myFunctions.execAjax('add', '_Suscripciones.php', subscriptionForm);
                            }
                        });
                    }
            });
        }
    }

        /* AGREGAR SUSCRIPCION BECA */
    let addSubscriptionBtn = document.getElementById('add-subscription-btn');

    if(addSubscriptionBtn !== null) {
        addSubscriptionBtn.addEventListener('click', e => {
            e.preventDefault();

            let addSubscriptionForm = document.getElementById('new-subscription-form');

            if(!myFunctions.validateFormFields(addSubscriptionForm)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Formulario Incompleto',
                    text: 'Todos los campos del formulario son requeridos',
                    showConfirmButton: true,
                    confirmButtonText: 'Verificar',
                    showCancelButton: false
                });
            }else {
                myFunctions.execAjax('add', '_Suscripciones.php', addSubscriptionForm);
            }
        })
    }


        /* CREAR SELECTS DE GRUPOS Y CONTENIDO */
    let tipoContenidoSelect = document.getElementById('tipo-suscripcion');
    
    if(tipoContenidoSelect !== null) {
        
        let grupoSeminariosEl = document.getElementById('grupo-seminario');
        grupoSeminariosEl.style.display = 'none';

        tipoContenidoSelect.addEventListener('change', e => {
            let cursosSeminariosEl = document.getElementById('curso-seminario');
            let tipoContenidoCodigo = tipoContenidoSelect.value;
            let arrayContent = [];

            myFunctions.execAjax('get', '_Suscripciones.php?action=getCursosSeminarios', '', tipoContenidoCodigo);

            setTimeout(() => {
                for(let i=0; i<localStorage.length; i++) {
                    arrayContent.push(JSON.parse(localStorage.getItem(i)));
                }

                localStorage.clear();
                cursosSeminariosEl.innerHTML = '<option disabled selected value="">Seleccione Curso/Seminario</option>';

                for(let i=0; i<arrayContent.length; i++) {
                    if(arrayContent[i]['codigo'] >= 3){
                        cursosSeminariosEl.innerHTML += `
                            <option value="${arrayContent[i]['codigo']}">${arrayContent[i]['nombre']}</option>
                        `;
                    }
                }
            }, 300);

                /* MOSTRAR GRUPOS SI ESTA EN SEMINARIOS LIVE */
                if(tipoContenidoCodigo === '102') {
                    grupoSeminariosEl.style.display = 'block';
                    grupoSeminariosEl.setAttribute('required', '');
                    
                    cursosSeminariosEl.addEventListener('change', () => {
                        
                        let arrayGroups = [];
                        let cursoSeminarioCodigo = cursosSeminariosEl.value;

                        myFunctions.execAjax('get', '_Suscripciones.php?action=getGrupos', '', cursoSeminarioCodigo);
                        
                        setTimeout(() => {
                            for(let i=0; i<localStorage.length; i++) {
                                arrayGroups.push(JSON.parse(localStorage.getItem(i)));
                            }

                            localStorage.clear();
                            grupoSeminariosEl.innerHTML = '<option disabled selected value="">Seleccione Grupo</option>';

                            for(let i=0; i<arrayGroups.length; i++) {
                                grupoSeminariosEl.innerHTML += `
                                    <option value="${arrayGroups[i]['id']}">${arrayGroups[i]['nombre']}</option>
                                `;
                            }
                        }, 300);
                    });

                }else {
                    grupoSeminariosEl.style.display = 'none';
                    grupoSeminariosEl.removeAttribute('required', '');
                }
        });
    }

})();