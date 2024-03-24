<?php

namespace App\Http\Services;

use DateTime;

class Helpers
{

	// validaCPF
	public static function validaCPF($cpf) {
		// Extrai somente os números
		$cpf = preg_replace('/[^0-9]/is', '', $cpf);

		// Verifica se foi informado todos os digitos corretamente
		if (strlen($cpf) != 11) {
			return false;
		}

		// Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
		if (preg_match('/(\d)\1{10}/', $cpf)) {
			return false;
		}

		// Faz o calculo para validar o CPF
		for ($t = 9; $t < 11; $t++) {
			for ($d = 0, $c = 0; $c < $t; $c++) {
				$d += $cpf[$c] * (($t + 1) - $c);
			}
			$d = ((10 * $d) % 11) % 10;
			if ($cpf[$c] != $d) {
				return false;
			}
		}
		return true;
	}

	// validaCNPJ
	public static function validaCNPJ($cnpj) {
		$cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);

		// Valida tamanho
		if (strlen($cnpj) != 14)
			return false;

		// Verifica se todos os digitos são iguais
		if (preg_match('/(\d)\1{13}/', $cnpj))
			return false;

		// Valida primeiro dígito verificador
		for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
			$soma += $cnpj[$i] * $j;
			$j = ($j == 2) ? 9 : $j - 1;
		}

		$resto = $soma % 11;

		if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
			return false;

		// Valida segundo dígito verificador
		for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
			$soma += $cnpj[$i] * $j;
			$j = ($j == 2) ? 9 : $j - 1;
		}

		$resto = $soma % 11;

		return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
	}

	// validaDocumento
	public static function validaDocumento($cnpjcpfInformado) {
		$cnpjcpf = preg_replace('/[^0-9]/is', '', $cnpjcpfInformado);
		if (strlen($cnpjcpf) == 11) {
			if (Helpers::validaCPF($cnpjcpf) == false) {
				return (object) array(
					'status'	=> false,
					'title'	 => 'ATENÇÃO',
					'text'		=> 'CPF `'.$cnpjcpfInformado.'` inválido!',
					'icon'		=> 'error',
					'debug'	 => Helpers::validaCPF($cnpjcpf),
					'cnpjcpf' => $cnpjcpf
				);
				exit;
			}

			$msgDeSucesso = 'CPF válido!';
		} else if (strlen($cnpjcpf) == 14) {
			if (Helpers::validaCNPJ($cnpjcpf) == false) {
				return (object) array(
					'status'	=> false,
					'title'	 => 'ATENÇÃO',
					'text'		=> 'CNPJ `'.$cnpjcpfInformado.'` inválido!',
					'icon'		=> 'error',
					'debug'	 => Helpers::validaCNPJ($cnpjcpf),
					'cnpjcpf' => $cnpjcpf
				);
				exit;
			}

			$msgDeSucesso = 'CNPJ válido!';
		} else {
			return (object) array(
				'status'	=> false,
				'title'	 => 'ATENÇÃO',
				'text'		=> 'Erro na quantidade de caracteres do CNPJ/CPF informado! `'.$cnpjcpf.'`',
				'icon'		=> 'error',
				'debug'	 => strlen($cnpjcpf),
				'cnpjcpf' => $cnpjcpf
			);
			exit;
		}

		return (object) array(
			'status'	=> true,
			'title'	 => 'SUCESSO',
			'text'		=> $msgDeSucesso,
			'icon'		=> 'success',
			'debug'	 => $cnpjcpfInformado,
			'cnpjcpf' => $cnpjcpf
		);
		exit;
	}

	// convertToFloat()
	public static function convertToFloat($number) {
		$number = str_replace(".", "", $number );
		$number = str_replace(",", ".", $number );
		return floatval($number);
	}


	// removerAcento
	public static function removerAcento($str)
	{
		// remover acentuação
		return str_replace( array(' ', 'à','á','â','ã','ä', 'ç', 'è','é','ê','ë', 'ì','í','î','ï', 'ñ', 'ò','ó','ô','õ','ö', 'ù','ú','û','ü', 'ý','ÿ', 'À','Á','Â','Ã','Ä', 'Ç', 'È','É','Ê','Ë', 'Ì','Í','Î','Ï', 'Ñ', 'Ò','Ó','Ô','Õ','Ö', 'Ù','Ú','Û','Ü', 'Ý'), array(' ', 'a','a','a','a','a', 'c', 'e','e','e','e', 'i','i','i','i', 'n', 'o','o','o','o','o', 'u','u','u','u', 'y','y', 'A','A','A','A','A', 'C', 'E','E','E','E', 'I','I','I','I', 'N', 'O','O','O','O','O', 'U','U','U','U', 'Y'), $str);
	}

	// removeCaracteresEspeciais
	public static function removeCaracteresEspeciais($str) {
		$str = preg_replace('/[áàãâä]/ui', 'a', $str);
		$str = preg_replace('/[éèêë]/ui', 'e', $str);
		$str = preg_replace('/[íìîï]/ui', 'i', $str);
		$str = preg_replace('/[óòõôö]/ui', 'o', $str);
		$str = preg_replace('/[úùûü]/ui', 'u', $str);
		$str = preg_replace('/[ç]/ui', 'c', $str);
		$str = preg_replace('/[^a-z0-9]/i', '', $str);
		$str = preg_replace('/_+/', '', $str);
		return $str;
	}

	// mask
	public static function mask($val, $mask) {
		$maskared = '';
		$k = 0;
		for($i = 0; $i<=strlen($mask)-1; $i++) {
			if($mask[$i] == '#') {
				if(isset($val[$k])) $maskared .= $val[$k++];
			} else {
				if(isset($mask[$i])) $maskared .= $mask[$i];
			}
		}
		return $maskared;
	}

	// adicionaMascaraCPF
	public static function adicionaMascaraCPF(string $cpfSemMascara){
		return Helpers::mask($cpfSemMascara, "###.###.###-##");
	}

	// adicionaMascaraCNPJ
	public static function adicionaMascaraCNPJ(string $cnpjSemMascara){
		return Helpers::mask($cnpjSemMascara, "##.###.###/####-##");
	}

	// adicionaMascaraCEP
	public static function adicionaMascaraCEP(string $cepMascara){
		return Helpers::mask($cepMascara, "#####-###");
	}

	// adicionaMascaraCPFouCNPJ
	public static function adicionaMascaraCPFouCNPJ(string $cnpjcpfInformado){
		$cnpjcpf = preg_replace('/[^0-9]/is', '', $cnpjcpfInformado);
		if (strlen($cnpjcpf) == 11) {
			return Helpers::adicionaMascaraCPF($cnpjcpf);
		} else if (strlen($cnpjcpf) == 14) {
			return Helpers::adicionaMascaraCNPJ($cnpjcpf);
		} else {
			return $cnpjcpf;
		}
	}

	// formatoDataBrasil
	public static function formatoDataBrasil(string $dataFormatoIngles){
		$date = new DateTime($dataFormatoIngles);
		if(strlen($dataFormatoIngles) == 10){
			return $date->format('d/m/Y');
		}else if(strlen($dataFormatoIngles) == 19){
			return $date->format('d/m/Y H:i:s');
		}
	}

	// jsonDecodeReplace
  public static function jsonDecodeReplace($texto, $procurarPor="'", $substituirPor='"'){
    return json_decode(str_replace($procurarPor, $substituirPor, $texto));
  }

  // jsonEncodeReplace
  public static function jsonEncodeReplace($texto, $procurarPor='"', $substituirPor="'"){
    return str_replace($procurarPor, $substituirPor, json_encode($texto));
  }
}