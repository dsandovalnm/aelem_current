
    let search = document.getElementById('search-argument');
    let prof = document.getElementById('search-prof');
    let searchBtn = document.getElementById('search-art-btn');

    let opts = (prof !== null) ? prof.options.length : '';
    let profId = '';

    searchBtn.addEventListener('click', e=> {

        e.preventDefault();

        for(i=1;i<opts;i++) {
            if(prof.options[i].selected) {
                profId = prof.options[i].value;
            }
        }

        let argument = search.value;
        
        if(argument === '' && profId === '') {
            Swal.fire({
                title: 'No hay argumentos para buscar',
                text: 'Por favor ingrese algún criterio de búsqueda',
                showConfirmButton: true,
                confirmButtonText: 'Aceptar'
            });
        }else {

            let xhr = new XMLHttpRequest();
            let form = document.getElementById('request-form');

            xhr.open('POST','/search.php');

            xhr.upload.onprogress = ()=>{
                Swal.fire({
                    timer: 1000,
                    showConfirmButton: false,
                    background: `rgba(255,255,255,0)`,
                    backdrop: `rgba(0,0,123,0.2)`,
                    html: `
                        <div class="spinner-border text-info" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>`
                });
            }

            xhr.onload = ()=>{

                // document.write(xhr.response);

                let res = JSON.parse(xhr.response);

                if(xhr.status === 200) {

                    let resultsBox = document.getElementById('results');
                    resultsBox.innerHTML = '';

                    let resultados = res.articulos.length;                    

                    Swal.fire({
                        title: `Se han encontrado ${resultados} resultados`,
                        showConfirmButton: true,
                        confirmButtonText: 'Aceptar'
                    });

                    if(resultados > 0) {

                    /* Los resultados varían dependiendo de la sección donde se use el buscador */

                        for(let i=0; i<(resultados); i++) {

                            let tituloArt = res.articulos[i].titulo;
                            let profImg = (res.articulos[i].profesional !== undefined) ? res.articulos[i].profesional.imagen : null;
                            let profNombre = (res.articulos[i].profesional !== undefined) ? res.articulos[i].profesional.nombre + ' ' + res.articulos[i].profesional.apellido : res.articulos[i].autor;
                            let codigoArt = res.articulos[i].codigo;

                            if(profImg !== null && profNombre !== null) {
                                resultsBox.innerHTML += `
                                    <div class="result-box">
                                        <a href="/articulos/${codigoArt}">
                                            <p class="title">${tituloArt}</p>
                                        </a>
                                        <div class="profesional-box">
                                            <figure class="author-figure mb-0 mr-3 float-left"><img src="/${profImg}" alt="Imagen Profesional" class="img-fluid"></figure>
                                            <p class="d-inline-block mt-1"><a href="/profesional/4">${profNombre}</a></p>
                                        </div>
                                    </div>
                                `;
                            }else {
                                resultsBox.innerHTML += `
                                    <div class="result-box">
                                        <a href="/articulo_para_leer/${codigoArt}">
                                            <p class="title">${tituloArt}</p>
                                        </a>
                                        <div class="profesional-box col-3">
                                            <p class="d-inline-block mt-1">${profNombre}</p>
                                        </div>
                                    </div>
                                `;
                            }
                        }

                    }else {

                        resultsBox.innerHTML += `
                            <div class="result-box">
                                <div class="articulo-titulo-resultado">
                                    <p class="title">Se encontraron 0 resultados para "${search.value}"</p>
                                </div>
                            </div>
                        `;
                    }

                    form.reset();
                    
                }
                
            }

            xhr.send(new FormData(form));
        }
    })
