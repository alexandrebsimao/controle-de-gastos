<?php
	
	if(!function_exists('bd2valor')){
		function bd2valor($valor){
			if($valor < 0){
				$valor = $valor * -1;
			}
			//$valor = str_replace('.', ',', $valor);
			$valor = (float) $valor;
			$valor = number_format($valor,2,',','.');
			return $valor;
		}
	}

	if(!function_exists('valor2bd')){
		function valor2bd($valor){
			$valor = str_replace(',', '.', $valor);
			return $valor;
		}
	}

	if(!function_exists('bd2data')){
		function bd2data($data){
			if($data == ' ')
				return '';

			$data = explode('-', $data);

			return $data[2] . '/' . $data[1] . '/' . $data[0];
		}
	}

	if(!function_exists('data2bd')){
		function data2bd($data){
			if($data == ' ')
				return '';

			$data = explode('/', $data);

			return $data[2] . '-' . $data[1] . '-' . $data[0];
		}
	}	
	
?>