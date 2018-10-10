<?php

namespace App\Controller;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
Use App\Entity\UserLabels;

class CsvController extends Controller
{
    // afin de respecter la spécification MVC du test une page d'accueil permettra de faire une vue, comme le reste des demandes est du webservice => json
    public function index()
    {
         return $this->render('index.html.twig');
    }

    // pour la route test1 : si pas de paramètre dans la request_uri lister tous les comptes
    // si un paramètre est passé on renvoie les détail d'un user ou un message "Aucun adhérent ne correspond à votre demande"
    public function getAdherentById($id)
    {
        // pas de paramètre passé dans l'URL => resultat total
        if ($id == -1){
            $adherents = $this->getAdherents();
            return $this->customJsonEnconding($adherents);
        } else { //un paramètre a été passé dans l'URL
            // récupération du tableau correspondant à la lecture du fichier .csv
            $adherents = $this->getAdherents();
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
            return $this->customJsonEnconding(isset($returnKey) ? $adherents[$returnKey] : "Aucun adhérent ne correspond à votre demande" );
        }
    }

    //  pour la route /test2
    public function getAllAdherentWithCountSorted() {
        // récupération du tableau correspondant à la lecture du fichier .csv
        $adherents = $this->getAdherents();
        // si le fichier csv est rempli on renvoie ces résultats sous forme json
        if (isset($adherents)) {
            $this->sortAdherents($adherents);
            return $this->customJsonEnconding($adherents, $yesGiveCount = true);
        } else { // si le fichier csv est vide on renvoie un message spécifique
            return $this->customJsonEnconding("Aucun adhérent n’est présent");
        }
    }

    private function getAdherents() {
        // $row defini le numéro de ligne lue dans le fichier csv
        $row = 0;
        // en cas de probleme dans la lecture du fichier (fichier absent par exemple, ou mal formé, on retournera une 404 "Le fichier d’entrée est introuvable "
        try {
            // Import du fichier CSV
            if (($handle = fopen(__DIR__ . "/../../public/donnees.csv", "r")) !== FALSE) {
                $data = fgetcsv($handle, 1000, ";");
                // une lecture de la première ligne du fichier permet de fixer les en-tetes de colonne, dans le cadre d'un projet international par exemple
                if ($data !== FALSE) {
                    $num = count($data); // Nombre d'éléments sur la ligne traitée
                    // l'utilisation d'une entité pour ce cas est uniquement dans le cadre du test pour respeceter le modele MVC mais n'est pas le fruit d'un choix technique
                    $userLabels = new UserLabels();
                    $userLabels->setId($data[0]);
                    $userLabels->setLastName($data[1]);
                    $userLabels->setFirstName($data[2]);
                    $userLabels->setPhoneNumber($data[3]);
                }
                // ensuite on rempli un tableau avec les valeurs lues dans le fichier . si une des cases est manquente entre 2 ";" on met un message spécifique
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) { // Eléments séparés par un point-virgule, à modifier si necessaire
                    $row++;
                    for ($c = 0; $c < $num; $c++) {
                        $adherents[$row] = array(
                            $userLabels->getId() => isset($data[0])?$data[0]:"donnée absente du fichier",
                            $userLabels->getLastName() => isset($data[1])?$data[1]:"donnée absente du fichier",
                            $userLabels->getFirstName() => isset($data[2])?$data[2]:"donnée absente du fichier",
                            $userLabels->getPhoneNumber() => isset($data[3])?$data[3]:"donnée absente du fichier",
                        );
                    }
                }
                fclose($handle);

            } else {
                // si pas de ligne présente alors $adherents n'est pas défini on renvoie vers l'exception du try-catch
                throw new Exception();
            }
            // retour de fonction uniquement si une donnée est à retourner : au moins la ligne des en-têtes
            if (isset($adherents)) {
                return $adherents;
            }
        // sinon 404 "Le fichier d’entrée est introuvable "
        } catch (\Exception $exception) {
            throw new NotFoundHttpException("Le fichier d’entrée est introuvable", $exception);
        }
    }

    // trie le tableau des adhérents par ordre prénom- nom
    private function sortAdherents($adherents) {
        // premier tri par le prénom du tableau, ordre 2 du tri
        $prenom = array();
        foreach ($adherents as $key => $row)
        {
            $prenom[$key] = $row['prenom'];
        }
        array_multisort($prenom, SORT_ASC, $adherents);

        // second tri par le nom du tableau, qui sera l'ordre 1 du tri
        $nom = array();
        foreach ($adherents as $key => $row)
        {
            $nom[$key] = $row['nom'];
        }

        // le tableau est maintenant trié il est renvoyé au controller
        return array_multisort($nom, SORT_ASC, $adherents);
    }

    /* pour bypasser un probleme d'encodage sur la fonction Symfony4 JsonResponse spécifique aux tableaux,
      on passe par une fonction custom appelant une méthode php classique qui répond à nos besoin
      cette fonction doit etre appelée aussi bien par un controller sans compte sur les élements qu'avec compte => param $withcount optionnel
    */
    private function customJsonEnconding($returnArray, $withCount = null) {
        $response = new Response(json_encode(isset($withCount) ? array('numberOfAdeherents' => sizeof($returnArray))+$returnArray : $returnArray, JSON_UNESCAPED_UNICODE));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}