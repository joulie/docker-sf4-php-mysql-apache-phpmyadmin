<?php
// src/Service/MessageGenerator.php
namespace App\Service;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
Use App\Entity\UserLabels;
Use App\Entity\Product;

class ServiceAdherents
{
    public function getAdherents() {
        // $row defini le numéro de ligne lue dans le fichier csv
        $row = 0;
        // en cas de probleme dans la lecture du fichier (fichier absent par exemple, ou mal formé, on retournera une 404 "Le fichier d’entrée est introuvable "
        try {
            // Import du fichier CSV
            if (($handle = fopen(__DIR__ . "/../../public/csv/donnees.csv", "r")) !== FALSE) {
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
    public function sortAdherents($adherents) {
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
}