// @ts-nocheck
import * as myFunctions from './Functions.js';

(function(){
    'use strict';

    /* =================================================================================== */
    /* ================================== USUARIO ======================================== */
    /* =================================================================================== */

        /* VIDEO FRAMES CARGADOS */
            myFunctions.iframesPreloader();
        
        /* ACORDEON CLASES */
            let classTab = document.getElementsByClassName('clase-tab');
            let classContent = document.getElementsByClassName('clase-video');

            if(classTab !== null && classContent !== null
                && classTab !== undefined && classContent !== undefined) {
                    for(let i=0; i<classTab.length; i++) {
                        $(classContent[i]).hide();

                        classTab[i].addEventListener('click', e => {
                            let currentLesson = classTab[i].getAttribute('data-target');
                            let arrow = classTab[i].childNodes[3];

                            $(classTab[i]).toggleClass('open');
                            
                                if(classTab[i].classList.contains('open')) {
                                    arrow.style.rotate = '180deg';
                                }else {
                                    arrow.style.rotate = '0deg';
                                }

                            $(classContent[i]).stop();
                            $(classContent[i]).slideToggle();
                        });
                    }
            }


        /* -------------------------- */
        /* SEMINARIOS EN VIVO */
            


    /* =================================================================================== */
    /* ==================================== ADMIN ======================================== */
    /* =================================================================================== */
    
    
        let contenidoSeminario = document.getElementById('contenido_seminario');
        let contenidoSeminarioInf = document.getElementById('contenido_seminario_inf');
        let contSem, contSemInf;
        
        /* TextEditor */
            if(contenidoSeminario !== null && contenidoSeminarioInf !== null) {
                ClassicEditor
                    .create(contenidoSeminario, {
                        toolbar: {
                            items: [
                                'heading',
                                '|',
                                'alignment',
                                '|',
                                'fontBackgroundColor',
                                'fontColor',
                                'fontSize',
                                '|',
                                'bold',
                                'italic',
                                'underline',
                                '|',
                                'blockQuote',
                                'undo',
                                'redo',
                                '|',
                                'link'
                            ]
                        },
                        language: 'es',
                        image: {
                            toolbar: [
                                'imageTextAlternative',
                                'imageStyle:full',
                                'imageStyle:side'
                            ]
                        },
                        table: {
                            contentToolbar: [
                                'tableColumn',
                                'tableRow',
                                'mergeTableCells'
                            ]
                        }
                    })
                    .then(editorSup => {
                        // window.contenido_seminario = editor;
                        contSem = editorSup;
                    })
                    .catch(error => {
                        console.error(error);
                    })

                    /* Inf */
                    ClassicEditor
                    .create(contenidoSeminarioInf, {
                        toolbar: {
                            items: [
                                'heading',
                                '|',
                                'alignment',
                                '|',
                                'fontBackgroundColor',
                                'fontColor',
                                'fontSize',
                                '|',
                                'bold',
                                'italic',
                                'underline',
                                '|',
                                'blockQuote',
                                'undo',
                                'redo',
                                '|',
                                'link'
                            ]
                        },
                        language: 'es',
                        image: {
                            toolbar: [
                                'imageTextAlternative',
                                'imageStyle:full',
                                'imageStyle:side'
                            ]
                        },
                        table: {
                            contentToolbar: [
                                'tableColumn',
                                'tableRow',
                                'mergeTableCells'
                            ]
                        }
                    })
                    .then(editorInf => {
                        // window.contenido_seminario_inf = editor;
                        contSemInf = editorInf;
                    })
                    .catch(error => {
                        console.error(error);
                    })
            }
        /* Fin Editor Texto */





        /* ************************************************ */
        /* FORMULARIOS DE CREACION Y EDICION DE SEMINARIOS */
            let submit = document.getElementById('seminario_submit_btn');
            let agregarTemaBtn = document.getElementById('agregar_tema_btn');
            let formSeminario = document.getElementById('seminarios_form');

            if(submit !== null && submit !== undefined
                && formSeminario !== '' && formSeminario !== null){

                submit.addEventListener('click', e=>{
                    e.preventDefault();

                    contSem.updateSourceElement();
                    contSemInf.updateSourceElement();

                    myFunctions.execAjax('add', '_SeminariosLive.php?btn=formBtn',formSeminario);
                });

                if(agregarTemaBtn !== null) {
                    agregarTemaBtn.addEventListener('click', e=>{
                        e.preventDefault();

                        myFunctions.execAjax('add', '_SeminariosLive.php?btn=temaBtn',formSeminario);
                    });
                }
            }




            /* ***************************** */
            /* ELIMINAR TEMAS DE SEMINARIO */
            let eliminarTemaBtn = document.getElementsByClassName('del_tema_btn');

            if(eliminarTemaBtn !== null) {
                for(let i=0; i<eliminarTemaBtn.length; i++) {
                    eliminarTemaBtn[i].addEventListener('click', e => {

                        let id_tema = eliminarTemaBtn[i].getAttribute('id_target');

                        Swal.fire({
                            icon: 'warning',
                            title: '¿Está seguro de eliminar este tema?',
                            showConfirmButton: true,
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor : '#28a745',
                            showCancelButton: true,
                            cancelButtonText: 'Cancelar',
                            cancelButtonColor : '#dc3545'
                        }).then( res => {
                            
                            if(res.value) {

                                myFunctions.execAjax('delete', '_SeminariosLive.php?btn=eliminarTemaBtn','',id_tema);

                            }

                        })

                    })
                }
            }  
            
            


            /* ****************************** */
            /* AGREGAR MATERIAL A SEMINARIOS */
            let agregarMaterialBtn = document.getElementById('material_submit_btn');
            let formMaterial = document.getElementById('material_form');

            if(formMaterial !== null) {

                agregarMaterialBtn.addEventListener('click', e => {

                    e.preventDefault();
                    myFunctions.execAjax('add', '_SeminariosLive.php?btn=agregarMaterial', formMaterial)

                })
            }




            /* ******************************** */
            /* ELIMINAR MATERIAL DE SEMINARIOS */
            let eliminarMaterialBtn = document.getElementsByClassName('del_mat_btn');

            if(eliminarMaterialBtn !== null) {
                for(let i=0; i<eliminarMaterialBtn.length; i++) {
                    eliminarMaterialBtn[i].addEventListener('click', e => {

                        let codeMaterial = e.target.parentElement.getAttribute('code-mat');

                        Swal.fire({
                            icon: 'warning',
                            title: '¿Está seguro de eliminar el material?',
                            showConfirmButton: true,
                            confirmButtonText: 'Eliminar',
                            showCancelButton: true,
                            cancelButtonText:'Cancelar'
                        }).then( res => {

                            if(res.value) {

                                myFunctions.execAjax('delete', '_SeminariosLive.php?btn=eliminarMaterial', '', codeMaterial);

                            }
                        });
                        
                    });
                }
            }



            /* ************************************* */
            /* AGREGAR VIDEO O CLASE PARA SEMINARIO */
            let agregarVideoBtn = document.getElementById('video_submit_btn');
            let formVideo = document.getElementById('video_form');

            if(formVideo !== null && agregarVideoBtn !== null) {

                agregarVideoBtn.addEventListener('click', e => {

                    e.preventDefault();
                    myFunctions.execAjax('add', '_SeminariosLive.php?btn=agregarVideoClase', formVideo);

                });
            }



            /* ********************************** */
            /* ELIMINAR UN VIDEO DE UN SEMINARIO */            
            let eliminarVideoBtn = document.getElementsByClassName('del_vid_btn');

            if(eliminarVideoBtn !== null) {
                for(let i=0;i<eliminarVideoBtn.length;i++) {
                    eliminarVideoBtn[i].addEventListener('click', e => {

                        let codeVideo = e.target.parentElement.getAttribute('code-vid');

                        Swal.fire({
                            icon: 'warning',
                            title: '¿Está seguro de eliminar este video?',
                            showConfirmButton: true,
                            confirmButtonText: 'Eliminar',
                            showCancelButton: true,
                            cancelButtonText: 'Cancelar'
                        }).then( res => {

                            if(res.value) {

                                myFunctions.execAjax('delete', '_SeminariosLive.php?btn=eliminarVideo', '', codeVideo);

                            }
                        })
                    });
                }
            }



            /* ********************************** */
            /* AGREGAR UN GRUPO AL SEMINARIO */
            let agregarGrupoBtn = document.getElementById('agregar-grupo-btn');

            if(agregarGrupoBtn !== null) {
                agregarGrupoBtn.addEventListener('click', e => {
                    e.preventDefault();

                    let seminarioCode = agregarGrupoBtn.getAttribute('seminario-code');
                    let nombreGrupo = agregarGrupoBtn.getAttribute('group-name');

                        myFunctions.execAjax('add', `_SeminariosLive.php?btn=addGrupo&groupName=${nombreGrupo}`, '', seminarioCode);

                })
            }



            /* ********************************** */
            /* EDITAR UN GRUPO DEL SEMINARIO */
            let editarGrupoBtn = document.getElementsByClassName('edit-grupo-btn');

            if(editarGrupoBtn !== null) {
                for(let i=0; i<editarGrupoBtn.length; i++) {
                    editarGrupoBtn[i].addEventListener('click', e => {
                        e.preventDefault();

                        Swal.fire({
                            icon: 'warning',
                            title: '¿Desea actualizar cambios?',
                            text: 'Se van a modificar los cambios de este grupo',
                            showConfirmButton: true,
                            confirmButtonText: 'Actualizar',
                            showCancelButton: true,
                            cancelButtonText: 'Cancelar'
                        }).then( res => {
                            if(res.value) {
                                let idGrupo = editarGrupoBtn[i].getAttribute('edit-id');
                                let idInput = editarGrupoBtn[i].getAttribute('input-field');
                                let inputValue = document.getElementById(idInput).value;

                                myFunctions.execAjax('add', `_SeminariosLive.php?btn=editGrupo&link=${inputValue}`, '', idGrupo);

                            }
                        })
                    });
                }
            }




            /* ********************************** */
            /* ELIMINAR UN GRUPO DEL SEMINARIO */
            let deleteGrupoBtn = document.getElementsByClassName('delete-grupo-btn');

            if(deleteGrupoBtn.length > 0) {
                for(let i=0; i<deleteGrupoBtn.length; i++) {
                    deleteGrupoBtn[i].addEventListener('click', e => {
                        e.preventDefault();

                        Swal.fire({
                            icon: 'warning',
                            title: '¿Está Seguro?',
                            text: 'Va a eliminar un grupo, esta acción no se puede deshacer',
                            showConfirmButton: true,
                            confirmButtonText: 'Eliminar',
                            confirmButtonColor: '#dc3545',
                            showCancelButton: true,
                            cancelButtonText: 'Cancelar'
                        }).then( res => {

                            if(res.value) {
                                let idGrupo = deleteGrupoBtn[i].getAttribute('delete-id');
                                myFunctions.execAjax('delete', `_SeminariosLive.php?btn=deleteGrupo`, '', idGrupo);
                            }

                        });
                    });
                }
            }


            /* ********************************** */
            /* AGREGAR UN PRECIO AL SEMINARIO */
            let agregarPrecioBtn = document.getElementById('agregar-precio-btn');

            if(agregarPrecioBtn !== null) {
                agregarPrecioBtn.addEventListener('click', e => {
                    e.preventDefault();

                    let seminarioCode = agregarPrecioBtn.getAttribute('seminario-code');
    
                    myFunctions.execAjax('add', `_SeminariosLive.php?btn=addPrecio`, '', seminarioCode);
                });
            }



            /* ********************************** */
            /* ELIMINAR UN PRECIO DEL SEMINARIO */
            let deletePrecioBtn = document.getElementsByClassName('delete-precio-btn');

            if(deletePrecioBtn.length > 0) {
                for(let i=0; i<deletePrecioBtn.length; i++) {
                    deletePrecioBtn[i].addEventListener('click', e => {
                        e.preventDefault();

                         Swal.fire({
                            icon: 'warning',
                            title: '¿Está Seguro?',
                            text: 'Va a eliminar un precio de un seminario, esta acción no se puede deshacer',
                            showConfirmButton: true,
                            confirmButtonText: 'Eliminar',
                            confirmButtonColor: '#dc3545',
                            showCancelButton: true,
                            cancelButtonText: 'Cancelar'
                        }).then( res => {
                            if(res.value) {
                                let idPrecio = deletePrecioBtn[i].getAttribute('delete-id');
                                myFunctions.execAjax('delete', `_SeminariosLive.php?btn=deletePrecio`, '', idPrecio);
                            }
                        });
                    });
                }
            }





        /* Fin Formulario Seminarios */

    
})();