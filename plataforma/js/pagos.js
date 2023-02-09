// @ts-nocheck
import * as myFunctions from './Functions.js';

(function(){
    'use strict';

    /* ======================================================================== */
    /* ===============================  ADMIN  ================================ */
    /* ======================================================================== */

        /* VERIFY PENDING PAYMENTS */
        let verifyPaymentBtn = document.getElementsByClassName('verify-payment-btn');

        if(verifyPaymentBtn !== null && verifyPaymentBtn.length > 0) {
            for(let i=0; i<verifyPaymentBtn.length; i++) {
                verifyPaymentBtn[i].addEventListener('click', e => {

                    e.preventDefault();

                    let transactionKey = verifyPaymentBtn[i].getAttribute('data-transaction-key');
                    let verifyPaymentForm = document.getElementById(`verify-payment-form-${transactionKey}`);
                    let userVerifyPayment = verifyPaymentForm.children.user.value;

                    Swal.fire({
                        icon : 'question',
                        title : 'Verificación de Pago',
                        html : `Al realizar la verificación se activará automáticamente el contenido correspondiente, para el usuario <b>${userVerifyPayment}</b>`,
                        confirmButtonText : 'Confirmar',
                        showCancelButton : true,
                        confirmButtonColor : '#28a745',
                        cancelButtonText : 'Cancelar',
                        cancelButtonColor : '#d9534f'
                    })
                    .then( resp => {
                        if(resp.value){
                            myFunctions.execAjax('add', '_Pagos.php', verifyPaymentForm);
                        }
                    });
                });
            }
        }


        /* DELETE PAYMENT */
        let deletePaymentBtn = document.getElementsByClassName('delete-payment-btn');

        if(deletePaymentBtn !== null && deletePaymentBtn.length > 0) {
            for(let i=0; i<deletePaymentBtn.length; i++) {
                deletePaymentBtn[i].addEventListener('click', e => {

                    e.preventDefault();

                    let transactionKey = deletePaymentBtn[i].getAttribute('data-transaction-key');
                    let deletePaymentForm = document.getElementById(`delete-payment-form-${transactionKey}`);

                    Swal.fire({
                        icon : 'warning',
                        title : '¿Está Seguro?',
                        text : 'Va a realizar la eliminación de un pago pendiente, esta acción no puede ser restablecida',
                        confirmButtonText : 'Eliminar',
                        showCancelButton : true,
                        confirmButtonColor : '#d9534f',
                        cancelButtonText : 'Cancelar',
                    })
                    .then( resp => {
                        if(resp.value) {
                            myFunctions.execAjax('delete', '_Pagos.php', deletePaymentForm);
                        }
                    });
                });
            }
        }

        
        /* BRING PAYMENT BY SEARCH */
        let searchPaymentsBtn = document.getElementById('search-payment-btn');

        if(searchPaymentsBtn !== null) {
            searchPaymentsBtn.addEventListener('click', e => {
                e.preventDefault();

                let searchDataPayment = [];

                let userPaymentEl = document.getElementById('email-pago-buscar');
                let seminarioPaymentEl = document.getElementById('seminario-pago-buscar');
                let buscarPagosForm = document.getElementById('pagos-search-form');
                let paymentsTableEl = document.getElementById('payments-table');

                    if( userPaymentEl.value === '' &&
                        seminarioPaymentEl.value === '') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'No hay criterios de búsqueda',
                                text: 'Debes completar por lo menos 1 campo',
                                confirmButtonText: 'Aceptar'
                            });
                            return;
                    }
                    
                myFunctions.execAjax('get', '_Pagos.php?action=search', buscarPagosForm);

                setTimeout(() => {
                    for(let i=0; i<localStorage.length; i++) {
                        searchDataPayment.push(JSON.parse(localStorage.getItem(i)));
                    }

                    // localStorage.clear();
                    paymentsTableEl.innerHTML = `
                        <thead class="thead-primary">
                            <tr class="bg-info">
                                <th>Fecha de Pago</th>
                                <th>Correo</th>
                                <th>Entidad</th>
                                <th>Estado</th>
                                <th>Verificado</th>
                                <th>Asesor</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                    `;

                        for(let i=0; i<searchDataPayment.length; i++) {

                            let dateParsed = new Date(searchDataPayment[i]['date']);                            
                            let formatOptions = {
                                day: 'numeric',
                                month: 'long',
                                year: '2-digit',
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit'
                            }
                            let dateFormated = dateParsed.toLocaleDateString("es-ES", formatOptions);

                            let verifiedIcon = searchDataPayment[i]['verified'] == 1 ? '<i class="fas fa-circle" style="color:green;"></i>' : '<i class="fas fa-circle" style="color:red;"></i>';
                            paymentsTableEl.innerHTML += `
                                <tr>
                                    <td>${dateFormated}</td>
                                    <td>${searchDataPayment[i]['email']}</td>
                                    <td>${searchDataPayment[i]['entity']}</td>
                                    <td>${searchDataPayment[i]['status']}</td>
                                    <td>${verifiedIcon}</td>
                                    <td>${searchDataPayment[i]['asesor']}</td>
                                    <td class="d-flex">
                                        <a  href="/plataforma/index.php?page=admin&view=pagos&subview=ver&codigo=${searchDataPayment[i]['transaction_key']}"
                                            class="btn"
                                            data-content="Ver el detalle del pago"
                                            data-toggle="popover"
                                            data-trigger="hover"
                                            title="Ver Detalle">

                                                <i class="far fa-eye"></i>
                                                
                                        </a>
                                    </td>
                                </tr>
                            `;
                        }

                    paymentsTableEl.innerHTML += '</tbody>';

                }, 500);
            });
        }


    /* ========================================================================= */
    /* ===============================  USUARIOS  ============================== */
    /* ========================================================================= */

        

})();