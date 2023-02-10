// @ts-nocheck

var baseURL = 'models/';
var cropper;


/* ********************************************************************************************************* */
/* ********************************************************************************************************* */

/* DEFINE A NEW URL */

    export function setUrl(stringUrl) {
        baseURL = stringUrl;
    }



/* ********************************************************************************************************* */
/* ********************************************************************************************************* */

/* 1. VALIDATE FORM FIELDS */

    export function validateFormFields(form) {

        let err = 0;

        for(let i=0;i<form.length;i++) {
            if(form[i].value == '' || form[i].value == ' ') {
                if(form[i].required) {
                    err++;
                }
            }
        }

        if(err > 0) {
            return false;
        }

        return true;
    }



/* ********************************************************************************************************* */
/* ********************************************************************************************************* */

/* 2. VALIDATE EMAIL ADDRESS */

    export function validateEmail(email) {
        let regEx = /^[a-zA-Z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
        return(regEx.test(email));
    }




/* ********************************************************************************************************* */
/* ********************************************************************************************************* */

/* 3. VALIDATE PASSWORD */

    export function validatePassword(password) {
        let regEx = /^(?=.*\w*\d)(?=.*\w*[A-Z])(?=.*\w*[a-z])\S{8,}$/;
        return(regEx.test(password));
    }


/* ********************************************************************************************************* */
/* ********************************************************************************************************* */

/* 4. COMPARE PASSWORDS */
    export function comparePasswords(password1, password2) {
        if(password1 !== password2) {
            return false
        }
        return true;
    }


/* ********************************************************************************************************* */
/* ********************************************************************************************************* */

/* FULL VALIDATION MERGE(1, 2, 3, 4) */
    export function fullValidation(form, email, password1=null, password2=null) {
        if(!validateFormFields(form)) {
            return 1;
        }else if(!validateEmail(email)) {
            return 2;
        }else if(password1 !== null && password2 !== null) {
            if(!validatePassword(password1)) {
                return 3;
            }else if(!comparePasswords(password1, password2)) {
                return 4;
            }else {
                return 0;
            }
        }else {
            return 0;
        }
    }


/* ********************************************************************************************************* */
/* ********************************************************************************************************* */

/* LOAD CALLING CODE ON SELECTED COUNTRY */

    export function loadCallingCode(pais, telefono) {
        let ind = '';
        pais.onchange = () => {
                
            for(let i=0; i<pais.options.length; i++) {
                if(pais.options[i].selected == true) {
                    ind = pais.options[i].getAttribute('pais-ind');
                }
            }

                telefono.value = ind;
                if((pais.value).trim() != '') {
                    telefono.disabled = false;
            } else {
                    telefono.disabled = true
            }
        }

        telefono.onkeyup = e => {
            let nums_v = telefono.value.match(/\d+/g);
            if (nums_v != null) {
                telefono.value = '+'+((nums_v).toString().replace(/\,/, ''));
            } else { 
                    telefono.value = ind;
                }
        }
    }


/* ********************************************************************************************************* */
/* ********************************************************************************************************* */

/* PRELOADER PARA VIDEOS IFRAME */

    export function iframesPreloader() {
        let iFrames = document.getElementsByTagName('iframe');
        let iFramesLoaded = 0;
        let loadingWindow = document.getElementById('loading-window');

        if(loadingWindow !== null) {
            if(iFrames.length > 0) {
                for(let i=0; i<iFrames.length; i++) {
                    iFrames[i].addEventListener('load', () => {
                        iFramesLoaded ++;
                        
                        if(iFramesLoaded === iFrames.length) {
                            loadingWindow.style.opacity = 0;
                            setTimeout(() => {
                                loadingWindow.remove();
                            }, 600);
                        }
                    });
                }
            }else {
                loadingWindow.remove();
            }
        }
    }


/* ********************************************************************************************************* */
/* ********************************************************************************************************* */
/* KEEP IN MIND THAT IS NECESARY TO CREATE THE MODAL AND FORM FIELDS WITH THE RIGTH ELEMENTS' IDs */

/* CROP IMAGE WITH CROPPED */
    /* Cropper variable is defined at the top as global */
/* Step 1 */
    export function cropImage(image_field, image_demo_viewer, image_modal) {
        image_field.addEventListener('change', e => {
            let reader = new FileReader();

            reader.onload = () => {
                image_demo_viewer.setAttribute('src', reader.result);
            }

            reader.readAsDataURL(image_field.files[0]);
            image_modal.modal('show');
        });

        $(image_modal).on('shown.bs.modal', () => {

            cropper = new Cropper(image_demo_viewer, {
                viewMode : 3,
                preview : '.preview',
                setDragMove : 'move'
            });

        }).on('hidden.bs.modal', () => {

            cropper.destroy();
            image_field.value = '';

        });
    }

/* Step 2 */
    export function setCroppedImage(crop_image_btn, canvasW, canvasH, cropped_image, image_modal, picture_box) {

        crop_image_btn.addEventListener('click', e => {
            let canvas = cropper.getCroppedCanvas({
                width : canvasW,
                height : canvasH
            });

            canvas.toBlob( blob => {
                let url = URL.createObjectURL(blob);
                let reader = new FileReader();
                let base64data;

                reader.readAsDataURL(blob);
                reader.onload = () => {
                    base64data = reader.result;

                    image_modal.modal('hide');
                    picture_box.setAttribute('src', base64data);

                    cropped_image.setAttribute('value', base64data);
                }
            }, 'image/jpeg', 0.75);
        });
    }

/* ********************************************************************************************************* */
/* ********************************************************************************************************* */

/* LOAD LEVELS - LESSONS AND LESSONS CONTENT (CURSOS - SEMINARIOS)*/
    export function loadLevelLessons(levelButtons, levelCode, lessonsTabBoxId, classLessonTab, element, box1, box2) {

        for(let j=0; j<levelButtons.length; j++) {
            levelButtons[j].classList.remove('active');
        }

        element.target.classList.add('active');

        let currentLessons = [];

        let data = {
            action:'view',
            content: 'lessons',
            levelCode:levelCode
        };

        let lessonsTabsBox = document.getElementById(lessonsTabBoxId);

        this.execAjax('get', '_Cursos_Seminarios.php', '', '', data,false);

        setTimeout(() => {
            for(let i=0; i<localStorage.length; i++) {
                currentLessons.push(JSON.parse(localStorage.getItem(i)));
            }

            let lessonsTabsBoxJQ = $('#lessons-tabs');

            localStorage.clear();
            lessonsTabsBoxJQ.slideUp();
            lessonsTabsBox.innerHTML = '';

            setTimeout(() => {
                for(let i=0; i<currentLessons.length; i++) {
                    lessonsTabsBox.innerHTML += `
                        <div id="lesson-tab-${i+1}" lesson="${i+1}" class="lesson-tab">
                            <small>Lección ${i+1}</small>
                            <i class="fas fa-play"></i>
                        </div>
                    `;
                }
                lessonsTabsBoxJQ.slideDown();
            },500);
        }, 500);

        setTimeout(() => {
            let lessonTabButtons = document.getElementsByClassName(classLessonTab);
            
            if(lessonTabButtons.length > 0) {
                for(let l=0; l<lessonTabButtons.length; l++) {
                    lessonTabButtons[l].addEventListener('click', e => {
                        e.preventDefault();

                        let lessonNumber = '';
                        let lessonContent = [];

                            if(e.target.getAttribute('lesson') == null) {
                                lessonNumber = e.target.parentNode.getAttribute('lesson');
                            }else {
                                lessonNumber = e.target.getAttribute('lesson');
                            }

                            lessonNumber = {
                                action: 'view',
                                content: 'lessonContent',
                                lessonCode: levelCode + '_' + lessonNumber
                            }
                            
                            this.execAjax('get', '_Cursos_Seminarios.php', '', '', lessonNumber);

                            setTimeout(() => {
                                lessonContent.push(JSON.parse(localStorage.getItem(0)));

                                let adminLessonContentBox = box2[0];

                                localStorage.clear();

                                adminLessonContentBox.innerHTML = `
                                    <div class="lesson-video-box col-12 col-sm-4">
                                        <form id="video-lesson-form">
                                            <input type="text" id="lesson-name" name="lesson-name" value="${lessonContent[0].nombre}">
                                            <iframe src="https://player.vimeo.com/video/${lessonContent[0].src}" width="100%" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                                            <input type="text" id="video-code" name="video-code" value="${lessonContent[0].src}">
                                            <div class="botones-box text-center py-2">
                                                <button id="btn-edit-lesson" lesson-code="${lessonContent[0].codigo_leccion}" class="btn btn-success"><small>Guardar</small></button>
                                                <button id="del-edit-lesson" class="btn btn-danger"><small>Eliminar</small></button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="documents-material col-12 col-sm-4">
                                        <p class="title text-center">Material Actual</p>

                                        <div class="botones-box text-center py-2">
                                            <button class="btn btn-primary">
                                                <small>Agregar</small>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="external-material col-12 col-sm-4">
                                        <p class="title text-center">Material Externo</p>
                                        <div class="botones-box text-center py-2">
                                            <button class="btn btn-primary">
                                                <small>Agregar</small>
                                            </button>
                                        </div>
                                    </div>
                                `;

                                let btnEditLesson = document.getElementById('btn-edit-lesson');
                                btnEditLesson.addEventListener('click', e => {
                                    e.preventDefault();

                                    let lessonName = document.getElementById('lesson-name').value;
                                    let videoCode = document.getElementById('video-code').value;
                                    let lessonCode = btnEditLesson.getAttribute('lesson-code');

                                    let lessonFormData = {
                                        action: 'edit',
                                        content : 'lessonContent',
                                        lessonName,
                                        videoCode,
                                        lessonCode
                                    }

                                    this.execAjax('edit', '_Cursos_Seminarios.php', '', '', lessonFormData);

                                });
                            },500);
                        
                        box1.fadeOut();
                        setTimeout(() => {
                            box2.fadeIn();
                        }, 500);
                    });
                }
            }
        },1200);


    }


/* ********************************************************************************************************* */
/* ********************************************************************************************************* */

/* AJAX FUNCTION */

    export function execAjax(action, url, form=null, id=null, data=null, preloader=true) {

        let xhr = new XMLHttpRequest();

                /* Verificar que se envíen datos */
            if(form === null && id === null && data === null) {
                return('There is not data to send');
            }

        /* Open */
        if(form !== null && form !== '') {
            xhr.open('POST', baseURL+url, true);
        }else {
            xhr.open('POST', baseURL+url, true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        }


        /* Loading */
        let swal = false;
        if(preloader) {
            xhr.upload.onprogress = data => {
                
                if(!swal) {
    
                    swal = true;
    
                    Swal.fire({
                        title: 'Procesando datos...',
                        allowOutsideClick: false,
                        grow: 'fullscreen',
                        background: 'rgba(255,255,255,0.2)',
                        onBeforeOpen: () => {
                            Swal.showLoading();
                        }
                    });
    
                    if(action === 'get') {
                        setTimeout(() => {
                            Swal.close();
                        }, 1000);
                    }
                }
            }
        }

        /* Loaded */
        xhr.onload = () => {

            if(xhr.status == 200) {

                // document.write(xhr.response);

                console.log(xhr.response);

                let res = JSON.parse(xhr.response);

                if(res.status === true) {

                    if(res.return === true) {
                        for(let i=0; i<res.response.length; i++) {
                            localStorage.setItem(i, JSON.stringify(res.response[i]) );
                        }
                    }else {
                        let swalIcon = res.icon !== undefined ? res.icon : 'success';

                        console.log(swalIcon);

                        Swal.fire({
                            icon: swalIcon,
                            title: res.title,
                            text: res.message,
                            showConfirmButton: true,
                            confirmButtonText: 'Aceptar',
                            onClose: () => {
                                if(res.link)  {
                                    window.location.href = `${res.link}`
                                }

                                if( res.action === 'reload') {
                                    document.location.reload();
                                }
                            }
                        });
                    }
                }else {
                    console.log(res.error);
                    Swal.fire({
                        icon: 'error',
                        title: res.title,
                        text: res.message,
                        showConfirmButton: false,
                        timer: 4000
                    })
                }
            }

            
        }

        /* Send */
        if(form !== null && form !== '') {
            xhr.send(new FormData(form));
        }else if(id !== null && id !== '') {
            xhr.send(`ajaxId=${id}`);
        }else {
            xhr.send('data='+JSON.stringify(data));
        }
    }