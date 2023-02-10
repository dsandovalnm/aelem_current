<?php 

/* FUNCION PARA CONVERTIR IMAGEN Y SUBIR AL SERVIDOR */
	function addImage($img64, $route, $name) {
		$img_arr1 = explode(';', $img64);
		$img_arr2 = explode(',', $img_arr1[1]);
		$basedecode = base64_decode($img_arr2[1]);

		$filename = $name;

				if(is_dir($route)){
					$uploaded = file_put_contents($route.'/'.$filename, $basedecode);
				}else {
					mkdir($route, 0777, true);
					$uploaded = file_put_contents($route.'/'.$filename, $basedecode);
				}
	}