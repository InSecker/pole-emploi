<?php

namespace App\Service;

class GeoAPIService
{
	public function areValidInputs($city, $postal) {
    // $this->isAnExistingCityName($city);
		$res = $this->isAnExistingPostalCode($postal);
		return $res;
	}

	private function isAnExistingCityName($city) {
		$ch = curl_init();
		$parametersArray = array("nom"=>$city);
		$parameters = http_build_query($parametersArray);
		$baseUrl = "https://geo.api.gouv.fr/communes?" . $parameters;
		curl_setopt($ch, CURLOPT_URL,  $baseUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_close($ch);
	}

	private function isAnExistingPostalCode($postal) {
		$ch = curl_init();
		$parametersArray = array("codePostal"=>$postal);
		$parameters = http_build_query($parametersArray);
		$baseUrl = "https://geo.api.gouv.fr/communes?" . $parameters;
		curl_setopt($ch, CURLOPT_URL,  $baseUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		curl_close($ch);
		if (!$result) {
			return "down";
		} else if ($result !== "[]" AND $result) {
			$result = json_decode($result, true);
			$result = $result[0]["code"];
			return $result;
		} else {
			return false;
		}
	}
}