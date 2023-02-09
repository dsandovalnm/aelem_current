// @ts-nocheck
import * as myFunctions from './Functions.js';

(function(){
    'use strict';

    /* =================================================================================== */
    /* ================================== USUARIO ======================================== */
    /* =================================================================================== */

        /* LINKEAR BOXES DE LOS CURSOS */
            let coursesBoxes = document.getElementsByClassName('course-box');

            if(coursesBoxes.length > 0) {
                for(let i=0; i<coursesBoxes.length; i++) {
                    coursesBoxes[i].addEventListener('click', e => {
                        e.preventDefault();
                        let page = coursesBoxes[i].getAttribute('go-page');
                        let idCode = coursesBoxes[i].getAttribute('id');

                        window.location.href = `/plataforma/index.php?page=${page}&view=ver&id=${idCode}`;
                    });
                }
            }

        /* VIDEO FRAMES CARGADOS */
            myFunctions.iframesPreloader();

        /* ACORDEON NIVELES */
            let levelTab = document.getElementsByClassName('level-tab');
            let levelContent = document.getElementsByClassName('level-content');

            if(levelTab !== null && levelContent !== null
                && levelTab !== undefined && levelContent !== undefined) {
                    for(let i=0; i<levelTab.length; i++) {
                        $(levelContent[i]).hide();

                        levelTab[i].addEventListener('click', e => {
                            let currentLevel = levelTab[i].getAttribute('data-target');
                            let arrow = levelTab[i].childNodes[3];

                            $(levelTab[i]).toggleClass('open');

                                if(levelTab[i].classList.contains('open')) {
                                    arrow.style.rotate = '180deg';
                                }else {
                                    arrow.style.rotate = '0deg';
                                }

                            $(levelContent[i]).stop();
                            $(levelContent[i]).slideToggle();
                        });
                    }
            }
        
        /* ACORDEON LECCIONES */
            let lessonTab = document.getElementsByClassName('lesson-tab');
            let lessonContent = document.getElementsByClassName('lesson-content');

            if(lessonTab !== null && lessonContent !== null
                && lessonTab !== undefined && lessonContent !== undefined) {
                    for(let i=0; i<lessonTab.length; i++) {
                        $(lessonContent[i]).hide();

                        lessonTab[i].addEventListener('click', e => {
                            let currentLesson = lessonTab[i].getAttribute('data-target');
                            let arrow = lessonTab[i].childNodes[3];

                            $(lessonTab[i]).toggleClass('open');
                            
                                if(lessonTab[i].classList.contains('open')) {
                                    arrow.style.rotate = '180deg';
                                }else {
                                    arrow.style.rotate = '0deg';
                                }

                            $(lessonContent[i]).stop();
                            $(lessonContent[i]).slideToggle();
                        });
                    }
            }

    /* FUNCIONES VISTA ADMINISTRADOR */
        /* AGREGAR Y EDITAR CURSO */
            let submitBtnAddEditCourse = document.getElementById('edit-curso-seminario-btn') !== null ? document.getElementById('edit-curso-seminario-btn') : document.getElementById('add-curso-seminario-btn');
            
            if(submitBtnAddEditCourse !== null) {
                submitBtnAddEditCourse.addEventListener('click', e => {
                    e.preventDefault();

                    let cursoForm = document.getElementById('curso-seminario-form');
                    let action = submitBtnAddEditCourse.id == 'add-curso-seminario-btn' ? 'add' : 'edit';

                    if(myFunctions.validateFormFields(cursoForm)) {
                        myFunctions.execAjax(action, '_Cursos_Seminarios.php', cursoForm);
                    }else {
                        Swal.fire({
                            icon : 'warning',
                            title: 'Formulario Incompleto',
                            text: 'Es necesario completar todos los campos para crear el curso'
                        });
                    }

                })
            }

        /* RECORTAR IMAGEN CURSO */
            let imageField = document.getElementById('curso-seminario-imagen');
            let imageDemoViewer = document.getElementById('image-demo');
            let imageModal = $('#uploadImageModal');
            let cropImageBtn = document.getElementById('crop-img-btn');
            let croppedImage = document.getElementById('curso-seminario-imagen-cropped');
            let pictureBox = document.getElementById('img-up');

            if(imageField !== null) {
                myFunctions.cropImage(imageField, imageDemoViewer, imageModal);

                if(cropImageBtn !== null) {
                    myFunctions.setCroppedImage(cropImageBtn, 730, 450, croppedImage, imageModal, pictureBox);
                }
            }

        
        /* MOSTRAR CAMPOS DE FORMULARIO, AGREGAR LECCION Y EDITAR LECCION */
            let tipoContenido = document.getElementById('leccion-tipo');
            
            let fileBox = document.getElementById('type-file');
            let linkBox = document.getElementById('type-link');
            let videoBox = document.getElementById('type-video');
            
            let inputFile = document.getElementById('leccion-archivo');
            let inputLink = document.getElementById('leccion-enlace');
            let inputVideo = document.getElementById('leccion-video');

            let submitBtnAddLesson = document.getElementById('submit-btn-add-lesson');
            let editBtnLesson = document.getElementById('btn-edit-lesson');
            let lessonForm = document.getElementById('lesson-cur-sem-form');

            if(tipoContenido !== null) {

                fileBox.style.display = 'none';
                linkBox.style.display = 'none';
                videoBox.style.display = 'none';
                submitBtnAddLesson.style.display = 'none';

                tipoContenido.addEventListener('change', e => {
                    let tipoContenidoValue = tipoContenido.value;

                    submitBtnAddLesson.style.display = 'inline-block';

                    switch(tipoContenidoValue) {
                        case 'file' :
                            fileBox.style.display = 'inline-block';
                            inputFile.required = true;
                            
                            linkBox.style.display = 'none';
                            inputLink.required = false;

                            videoBox.style.display = 'none';
                            inputVideo.required = false;

                        break;
                        case 'link' :
                            fileBox.style.display = 'none';
                            inputFile.required = false;
                            
                            linkBox.style.display = 'inline-block';
                            inputLink.required = true;
                            
                            videoBox.style.display = 'none';
                            inputVideo.required = false;

                        break;
                        case 'video' :
                            fileBox.style.display = 'none';
                            inputFile.required = false;
                            
                            linkBox.style.display = 'none';
                            inputLink.required = false;
                            
                            videoBox.style.display = 'inline-block';
                            inputVideo.required = true;

                        break;
                    }
                });
            }

                /* Agregar Lección */
                submitBtnAddLesson?.addEventListener('click', e => {
                    e.preventDefault();

                    if(!myFunctions.validateFormFields(lessonForm)) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Formulario Incompleto',
                            text: 'Todos los campos deben estar completados',
                            showConfirmButton: true,
                            textConfirmButton: 'Verificar'
                        });
                    } else {
                        myFunctions.execAjax('add', '_Cursos_Seminarios.php', lessonForm);
                        lessonForm.reset();
                    }
                });

                /* Editar Leccion */
                editBtnLesson?.addEventListener('click', e => {
                    e.preventDefault();

                    alert('Leccion editada correctamente');
                });


        /* AGREGAR NUEVO NIVEL */
            let btnAddLevel = document.getElementById('add-btn-lvl');

            btnAddLevel?.addEventListener('click', e => {
                e.preventDefault();

                let courseCode = btnAddLevel.getAttribute('cur-sem-code');

                myFunctions.execAjax('add', '_Cursos_Seminarios.php', '', courseCode);
            });

        /* MOSTRAR (FORMULARIO AGREGAR LECCIÓN) O (CONTENIDO LECCIÓN) */
            let addLessonFormBox = $('#add-new-lesson');
            let adminLessonContentBox = $('#admin-view-lesson');
            let addLessonBtn = document.getElementById('add-lesson-btn');

            addLessonFormBox.hide();
            adminLessonContentBox.hide();

            addLessonBtn?.addEventListener('click', e => {
                e.preventDefault();

                adminLessonContentBox.fadeOut();
                setTimeout(() => {
                    addLessonFormBox.fadeIn();
                },500);
            });
            
        /* CAMBIAR NIVEL - CARGAR LECCIONES Y CARGAR CONTENIDO*/
            let levelButtons = document.getElementsByClassName('btn-level-tab');

            if(levelButtons.length > 0) {
                for(let i=0; i < levelButtons.length; i++) {
                    let levelCode = levelButtons[i].getAttribute('level_code');
                    
                    levelButtons[i].addEventListener('click', e => {
                        e.preventDefault();

                        addLessonFormBox.fadeOut();
                        adminLessonContentBox.fadeOut();

                        myFunctions.loadLevelLessons(levelButtons, levelCode, 'lessons-tabs', 'lesson-tab', e, addLessonFormBox, adminLessonContentBox);
                    });                    
                }
            }
    
})();