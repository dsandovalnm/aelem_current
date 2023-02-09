// @ts-nocheck
(function(){
    'use strict';

    let contenidoArticulo = document.getElementById('contenido_articulo');
    let contArt;
    
    /* TextEditor */
        if(contenidoArticulo !== null) {
            ClassicEditor
                .create(contenidoArticulo, {
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
                            'redo'
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
                    // window.contenido_articulo = editor;
                    contArt = editorSup;
                })
                .catch(error => {
                    console.error(error);
                })
        }
    /* Fin Editor Texto */

    /* ************************************************ */
    /* RECORTAR Y AJUSTAR IMAGEN DEL ARTICULO */

        let articleImage = document.getElementById('imagen_articulo');
        let cancelCropBtn = document.getElementsByClassName('cancel-crop');
        let articleCode = document.getElementById('codigo_articulo');
        let imageCrop = document.getElementById('image-demo');
        let uploadImageModal = $('#uploadImageModal');
        let cropper;
        
        if(articleImage !== null) {
            
            articleImage.addEventListener('change', () => {

                let reader = new FileReader();

                reader.onload = () => {
                    imageCrop.setAttribute('src', reader.result);
                }
    
                reader.readAsDataURL(articleImage.files[0]);
                uploadImageModal.modal('show');
            });
        }

        $(uploadImageModal).on('shown.bs.modal', () => {

            cropper = new Cropper(imageCrop, {
                aspectRatio : 730 / 450,
                viewMode : 3,
                preview : '.preview',
                setDragMove : 'move'
            });

        }).on('hidden.bs.modal', () => {

            cropper.destroy();
            articleImage.value = '';

        })

            /* Aceptar cambios recortar imagen y subir */
                let cropImgBtn = document.getElementById('crop-img-btn');
                let pictureBox = document.getElementById('img-up');

                if(cropImgBtn !== null) {
                    cropImgBtn.addEventListener('click', e => {

                        let canvas = cropper.getCroppedCanvas({
                            width : 730,
                            height : 450
                        });

                        canvas.toBlob( blob => {
                            let url = URL.createObjectURL(blob);
                            let reader = new FileReader();
                            let base64data;

                            reader.readAsDataURL(blob);
                            reader.onload = () => {
                                base64data = reader.result;

                                uploadImageModal.modal('hide');
                                pictureBox.setAttribute('src', base64data);

                                let croppedImage = document.getElementById('imagen_articulo_cropped');
                                croppedImage.setAttribute('value', base64data);
                            }
                        }, 'image/jpeg', 0.70);
                    });
                }

    /* ************************************************ */
    /* AGREGAR Y EDITAR ARTICULO */
        let submit = document.getElementById('articulo_submit_btn');
        let action = document.getElementById('action');
        let form = document.getElementById('articulos_form');

        if(form !== '' && form !== null){

            submit.addEventListener('click', e => {

                e.preventDefault();
                contArt.updateSourceElement();

                    if(validateFormFields(form)) {
                        setArticle(`${action.value}`);
                    }else {
                        Swal.fire({
                            icon : 'warning',
                            title : 'Campos incompletos',
                            text : 'Es necesario que completes todos los campos'
                        });
                    }


            });
        }

        
    /* ************************************************ */
    /* FUNCION AJAX ARTICULOS */        
        function setArticle(boton) {

            let xhr = new XMLHttpRequest;
            xhr.open('POST', `models/_Articulos.php?btn=${boton}`, true);

            let swal = false;
            xhr.upload.onprogress = data => {

                if(!swal) {

                    swal = true;

                    Swal.fire({
                        title: 'Procesando datos...',
                        allowOutsideClick: false,
                        grow: 'fullscreen',
                        background: '#ffffffa1',
                        onBeforeOpen: () => {
                            Swal.showLoading();
                        }
                    });
                }

                if(data.loaded == data.total) {
                    swal = false;
                    Swal.close();
                }
            }

            xhr.onload = ()=>{

                // document.write(xhr.response);

                let res = JSON.parse(xhr.response);

                if(res.status === true) {
                    Swal.fire({
                        icon: 'success',
                        title: res.title,
                        text: res.text,
                        showConfirmButton: true,
                        confirmButtonText: 'Aceptar',
                        onClose: () => {
                            window.location.href = `${res.link}`
                        }
                    });

                    form.reset();
                }else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: res.text,
                        showConfirmButton: true,
                        confirmButtonText: 'Aceptar'
                    })
                }

            }
            
            xhr.send(new FormData(form));
            
        }


    /* ************************************************ */
    /* FUNCION VERIFICAR CAMPOS DE FORMULARIO */
        function validateFormFields(form) {

            let err = 0;

            for(let i=0;i<form.length;i++) {

                if(form[i].value == '' || form[i].value == ' ' || form[i].value == 'Elija Profesional') {
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
})();