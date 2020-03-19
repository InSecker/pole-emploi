<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GeoAPIService;
use App\Service\EtablissementPublicAPIService;

class FormController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request, GeoAPIService $geoAPI, EtablissementPublicAPIService $publicPlaces)
    {
    	  // Retrieve form data
    	  $city = $request->request->get('city');
	      $postal = (int)$request->request->get('postal');
	      $places= array();

	      $errors = array();

    	  if ($city === NULL OR $postal === NULL ) {
    	  	/*
    	  	 * FIRST CONNECTION
    	  	 * nothing here, just to exclude this case in else statement
    	  	 *
    	  	 */
	      } else if ( $postal === 0 ) {
    	  	// EMPTY FIELDS
					array_push( $errors, "Veuillez entrer un code postal.");
        } else {
    	  	// CORRECT FIELDS
		      $code = $geoAPI->areValidInputs($city, $postal);
		      if ($code === "down") {
			      array_push( $errors, "Données indisponibles. Veuillez réessayer ultérieurement.");
		      }  else if ($code) {
						$places = $publicPlaces->getPlaces($code);
					} else {
						array_push( $errors, "Le code postal entré n'existe pas.");
					}
	      }
        return $this->render('base.html.twig', [
            'errors' => $errors,
	          'city'   => $city,
	          'postal' => $postal,
	          'places' => $places
        ]);
    }
}
