<?php

namespace App\Service;

class EtablissementPublicAPIService
{
	public function getPlaces($code) {
		$ch = curl_init();
		$baseUrl = "https://etablissements-publics.api.gouv.fr/v3/communes/" . $code . "/pole_emploi";
		curl_setopt($ch, CURLOPT_URL,  $baseUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = json_decode(curl_exec($ch), true);
		curl_close($ch);
		return $result["features"];
	}
}