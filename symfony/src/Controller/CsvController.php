<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
Use App\Service\ServiceAdherents;
use App\Service\ServiceJsonCustom;
use Unirest;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class CsvController extends Controller
{
    //declaration des services qui vont être utilisés
    private $serviceAdherents;
    private $serviceJsonCustom;
    public function __construct(ServiceAdherents $serviceAdherents, ServiceJsonCustom $serviceJsonCustom)
    {
        $this->serviceAdherents = $serviceAdherents;
        $this->serviceJsonCustom = $serviceJsonCustom;
        //$this->mailer = $mailer;
    }
    // fin de déclaration des services

    /**
     * @Route("/", name="index")
     * afin de respecter la spécification MVC du test une page d'accueil permettra de faire une vue, comme le reste des demandes est du webservice => json
     */
    public function index()
    {
         return $this->render('index.html.twig');
    }

    /**
    * @Route("/test1/{id}", name="test1route")
    * @param string $id
    * @return json
    * pour la route test1 : si pas de paramètre dans la request_uri lister tous les comptes
    * si un paramètre est passé on renvoie les détail d'un user ou un message "Aucun adhérent ne correspond à votre demande"
    */
    public function getAdherentById($id=-1)
    {
        // pas de paramètre passé dans l'URL => resultat total
        if ($id == -1){
            $adherents = $this->serviceAdherents->getAdherents();
            return $this->serviceJsonCustom->customJsonEnconding($adherents);
        } else { //un paramètre a été passé dans l'URL
            // récupération du tableau correspondant à la lecture du fichier .csv
            $adherents = $this->serviceAdherents->getAdherents();
            // vérification que l'identifiant est présent dans les données ; sinon $returnkey sera not set et ça nous permettra de renvoyer un message spécifique
            $i=0;
            foreach ($adherents as $adherent) {
                $i++;
                foreach ($adherent as $key => $values) {
                    if ($values == $id) {
                        $returnKey = $i;
                    }
                }
            }
            // si l'identifiant existe on renvoie les détails de l'adhérent, sinon un message d'erreur
            return $this->serviceJsonCustom->customJsonEnconding(isset($returnKey) ? array(1 => $adherents[$returnKey]) : "Aucun adhérent ne correspond à votre demande" );
        }
    }

    /**
    * @Route("/test2", name="test2route")
    * @return json
    * pour la route /test2 : retourner tous les adherents triés
    */
    public function getAllAdherentWithCountSorted() {
        // récupération du tableau correspondant à la lecture du fichier .csv
        $adherents = $this->serviceAdherents->getAdherents();
        // si le fichier csv est rempli on renvoie ces résultats sous forme json
        if (isset($adherents)) {
            $this->serviceAdherents->sortAdherents($adherents);
            return $this->serviceJsonCustom->customJsonEnconding($adherents, $yesGiveCount = true);
        } else { // si le fichier csv est vide on renvoie un message spécifique
            return $this->serviceJsonCustom->customJsonEnconding("Aucun adhérent n’est présent");
        }
    }

    /**
     * @Route("/test3", name="test3route")
     * @return json
     * pour la route /test3 : affichage du résultat sous forme lisible
     */
    public function test3() {
        // récupération du tableau correspondant à la lecture du fichier .csv
        $adherents = $this->serviceAdherents->getAdherentsEntities();
        // si le fichier csv est rempli on renvoie ces résultats sous forme json
        if (isset($adherents)) {
            //$this->serviceAdherents->sortAdherents($adherents);
            return $this->render('test3.html.twig', array('adherents' => $adherents[0], 'titles' => $adherents[1]));
        } else { // si le fichier csv est vide on renvoie un message spécifique
            return $this->serviceJsonCustom->customJsonEnconding("Aucun adhérent n’est présent");
        }
    }

    /**
     * @Route("/test4/{id}", name="test4route")
     * @param string $id
     * @return template
     * pour la route /test4 : affichage du résultat par récupération du webservice via appel curl
     */
    public function test4($id=-1) {
        $headers = array('Accept' => 'application/json');
        $response = Unirest\Request::get('http://sf4.local/test1/'.$id,$headers);
        $dataencoded = json_encode($response->body, true);
        $datadecoded=json_decode($dataencoded,true);
        dump($datadecoded);

        if (isset($datadecoded)) {
            //$this->serviceAdherents->sortAdherents($adherents);
            return $this->render('test4.html.twig', array('adherents' => $datadecoded));
        } else { // si le fichier csv est vide on renvoie un message spécifique
            return $this->serviceJsonCustom->customJsonEnconding("Aucun adhérent n’est présent");
        }
    }

    /**
     * @Route("/test5", name="test5route")
     * pour la route /test5 : affichage du résultat par récupération intra sf
     */
    public function test5() {
        $data = $this->forward('app.csvcontroller:getAdherentById', array('id' => -1));
        $datadecoded = json_decode($data->getContent(), true);

        if (isset($datadecoded)) {
            //$this->serviceAdherents->sortAdherents($adherents);
            return $this->render('test5.html.twig', array('adherents' => $datadecoded));
        } else { // si le fichier csv est vide on renvoie un message spécifique
            return $this->serviceJsonCustom->customJsonEnconding("Aucun adhérent n’est présent");
        }
    }

    /**
     * @Route("/test6", name="test6route")
     * pour la route /test6 : récupération en ajax de l'apel aux données lues dans le fichier csv
     */
    public function test6() {
        return $this->render('test6.html.twig');
    }

    /**
     * @Route("/test6ajax", name="test6ajaxroute")
     * pour la route /test6ajax : possibilité de refresh
     */
    public function test6ajax() {
        $data = $this->forward('app.csvcontroller:getAdherentById', array('id' => -1));
        $datadecoded = json_decode($data->getContent(), true);

        if (isset($datadecoded)) {
            //$this->serviceAdherents->sortAdherents($adherents);
            return $this->render('test6SubDivAjax.html.twig', array('adherents' => $datadecoded));
        } else { // si le fichier csv est vide on renvoie un message spécifique
            return $this->serviceJsonCustom->customJsonEnconding("Aucun adhérent n’est présent");
        }
    }
}