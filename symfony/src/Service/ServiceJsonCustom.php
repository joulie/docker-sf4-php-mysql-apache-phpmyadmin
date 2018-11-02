<?php

namespace App\Service;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
Use App\Entity\UserLabels;
Use App\Entity\Product;

class ServiceJsonCustom
{
    /* pour bypasser un probleme d'encodage sur la fonction Symfony4 JsonResponse spécifique aux tableaux,
          on passe par une fonction custom appelant une méthode php classique qui répond à nos besoins
          cette fonction doit etre appelée aussi bien par un controller sans compte sur les élements qu'avec compte => param $withcount optionnel
        */
    public function customJsonEnconding($returnArray, $withCount = null) {
        $response = new Response(json_encode(isset($withCount) ? array('numberOfAdeherents' => sizeof($returnArray))+$returnArray : $returnArray, JSON_UNESCAPED_UNICODE));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}