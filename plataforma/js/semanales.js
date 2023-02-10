// @ts-nocheck

(function(){
	'use strict';

	/* ================================================================================================== */
	/* ============================================= USUARIO ============================================ */
	/* ================================================================================================== */


	let semanalesTab = document.getElementsByClassName('semanal-table-row');

	let semanalId;

	if(semanalesTab.length > 0) {
		for(let i=0; i < semanalesTab.length; i++) {
			semanalesTab[i].addEventListener('click', e => {
				e.preventDefault();

				semanalId = semanalesTab[i].getAttribute('semanal-id');
				window.location.href = `/plataforma/index.php?page=semanales&view=semanal&code=${semanalId}`;
			});
		}
	}


	/* ================================================================================================== */
	/* ========================================== ADMINISTRADOR ========================================= */
	/* ================================================================================================== */
})();
