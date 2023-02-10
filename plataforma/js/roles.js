import * as myFunctions from './Functions.js';

(()=>{
    'use strict';

    let selectAllPerm = document.getElementById('select-all');
    let checkBoxPerm = document.getElementsByClassName('checkbox-perm');

    selectAllPerm.addEventListener('click', () => {
        if(selectAllPerm.checked) {
            for(let i=0; i<checkBoxPerm.length; i++) {
                checkBoxPerm[i].checked = true;
            }
        }else{
            for(let i=0; i<checkBoxPerm.length; i++) {
                checkBoxPerm[i].checked = false;
            }
        }
    });

    /* CREAR UN NUEVO ROL */
        let submitRolBtn = document.getElementById('rol-submit-btn');
        let rolesForm = document.getElementById('roles-form');

        if(submitRolBtn !== null) {
            submitRolBtn.addEventListener('click', e => {
                e.preventDefault();

                if(myFunctions.validateFormFields(rolesForm)) {
                    myFunctions.execAjax('add', '_Roles.php', rolesForm);
                }else {
                    Swal.fire({
                        icon : 'warning',
                        title : 'Formulario Incompleto',
                        text : 'Los campos del formulario deben ser completados',
                        showConfirmButton : true,
                        confirmButtonText : 'Verificar',
                        confirmButtonColor : '#17a2b8;'
                    });
                }
            })
        }

})();