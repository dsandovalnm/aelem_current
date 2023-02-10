// @ts-nocheck
(function(){
    'use strict';

    let toggleBtn = document.getElementById('toggle-btn');
    let sideBar = document.getElementsByClassName('side-bar-box');
    let topBar = document.getElementsByClassName('topbar');
    let mainContent = document.getElementsByClassName('main-content');
	let collapsed = false;

    /* Novedades Modal Home */
        // $('#notificationModal').modal({
        //     show: true
        // });

	/* Bootstrap Popovers */
        $('[data-toggle="popover"]').popover();

        if(toggleBtn !== null) {
            toggleBtn.addEventListener('click', ()=>{
                sideBar[0].classList.toggle("collapsed");
                topBar[0].classList.toggle("collapsed");
                mainContent[0].classList.toggle("collapsed");
        
                collapsed = sideBar[0].classList.contains('collapsed');
            });
        }

    /* SideBar Nav */
        let navItems = document.getElementsByClassName('item nav-item');

        for(let i=0; i<navItems.length; i++) {
            navItems[i].addEventListener('click',()=>{
                if(navItems[i].getAttribute('data-link') !== '') {
                    window.location.href = navItems[i].getAttribute('data-link');
                }
            })
        }

    /* -------- TOP BAR BUTTONS --------- */
        /* Logout Btn */
            let logOut = document.getElementById('logout-btn');

            if(logOut !== null) {
                logOut.addEventListener('click', ()=>{
                    Swal.fire({
                        title: 'Cerrando Sesión',
                        confirmButtonText: 'Salir',
                        confirmButtonColor: '#d9534f',
                        onClose: ()=>{
                            window.location.href = 'logout.php'
                        }
                    })
                });
            }


        /* Notification Btn */
            let notificationsBtn = document.getElementById('notifications-btn');

            if(notificationsBtn !== null) {
                notificationsBtn.addEventListener('click', e => {
                    e.preventDefault();
    
                    Swal.fire({
                        title: 'Notificaciones Pendientes',
                        html: `
                            <hr>
                            <div class="container notifications-container">
                                <div class="notification-box">
                                    <p style="font-size:.8rem">Nuevo Seminario "Instructorado de Educación Emocional"</p>
                                    <hr>
                                </div>
                                <div class="notification-box">
                                    <p style="font-size:.8rem">Tu suscripción expira dentro de 7 días</p>
                                    <hr>
                                </div>
                            </div>
                        `,
                        width: 300,
                        backdrop: false,
                        position: 'top-right',
                        toast: true,
                        showCloseButton: true,
                        showConfirmButton: false
                    });
    
                });
            }

})();