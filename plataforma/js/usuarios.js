// @ts-nocheck
import * as myFunctions from './Functions.js';

(()=>{
   'use strict';

	/* AGREGAR Y EDITAR USUARIOS */
		let submitUserBtn = document.getElementById('submit-user-btn');
		let action = document.getElementById('action');
		let userForm = document.getElementById('user-form');
		let userEmail = document.getElementById('usuario-email');
		let userPassword = document.getElementById('usuario-password');
		let userPasswordRepeat = document.getElementById('usuario-password-r');

		if(submitUserBtn !== null) {
			submitUserBtn.addEventListener('click', e => {

				e.preventDefault();

				let formValidation = (action.value === 'editar' && userPassword.value === '' && userPasswordRepeat.value === '') ? 
											myFunctions.fullValidation(userForm, userEmail.value) :
											myFunctions.fullValidation(userForm, userEmail.value, userPassword.value, userPasswordRepeat.value);

				switch(formValidation) {
					case 0 :
						myFunctions.execAjax('add', '_Usuarios.php', userForm);
					break;
					case 1 :
						Swal.fire({
							icon : 'warning',
							title : 'Campos Incompletos',
							text : 'Todos los campos marcados con (*) son obligatorios',
							showConfirmButton : true,
							confirmButtonText : 'Verificar',
							confirmButtonColor : '#17a2b8'
						});
					break;
					case 2 :
						Swal.fire({
							icon : 'warning',
							title : 'Email Incorrecto',
							text : 'La dirección de correo no tiene un formato correcto',
							showConfirmButton : true,
							confirmButtonText : 'Verificar',
							confirmButtonColor : '#17a2b8'
						});
					break;
					case 3 :
						Swal.fire({
								icon : 'warning',
								title : 'Contraseña Inválida',
								html : `
									<p>La contraseña debe:</p>
									<p>- Tener mínimo 8 caracteres</p>
									<p>- Contener al menos 1 dígito o caracter numérico</p>
									<p>- Tener una minúscula</p>
									<p>- Tener una mayúscula</p>
								`,
								showConfirmButton : true,
								confirmButtonText : 'Verificar',
								confirmButtonColor : '#17a2b8'
							});
					break;
					case 4 :
						Swal.fire({
							icon : 'warning',
							title : 'Las contraseñas no coinciden',
							text : 'Las contraseñas deben ser exactamente iguales',
							showConfirmButton : true,
							confirmButtonText : 'Verificar',
							confirmButtonColor : '#17a2b8'
						});
					break;
				}

			});
		}

	/* ELIMINAR USUARIOS */

		let deleteUserBtn = document.getElementsByClassName('del-usu-btn');

		if(deleteUserBtn.length > 0) {
			for(let i=0; i<deleteUserBtn.length; i++) {
				deleteUserBtn[i].addEventListener('click', e => {
					e.preventDefault();

					let userId = deleteUserBtn[i].getAttribute('data-user-id');
					let deleteUserForm = document.getElementById(`delete-user-form-${userId}`);
					let userEmail = deleteUserBtn[i].getAttribute('data-user-email');

					Swal.fire({
						icon : 'question',
						title : '¿Está Seguro?',
						html : `Va a eliminar al usuario <b>${userEmail}</b>, esta acción no se puede deshacer`,
						showConfirmButton : true,
						confirmButtonText : 'Eliminar',
						confirmButtonColor : '#28a745',
						showCancelButton : true,
						cancelButtonText : 'Cancelar',
						cancelButtonColor : '#dc3545'
					})
					.then(res => {
						if(res.value) {
							myFunctions.execAjax('delete', '_Usuarios.php', deleteUserForm);
						}
					});

				});
			}
		}

})();