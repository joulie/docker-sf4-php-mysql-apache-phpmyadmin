<?php
// src/Entity/UserLabels.php : récupération identifiant;nom;prenom;telephone dans le but d'utiliser une entité dans le test, sans avoir le temps de réfléchir à son utilité

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserLabelsRepository")
 */
class UserLabels
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $idCsv;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $phoneNumber;



    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }


    public function setIdCsv($idCsv)
    {
        $this->idCsv = $idCsv;
    }
    public function getIdCsv()
    {
        return $this->idCsv;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }
    public function getLastName()
    {
        return $this->lastName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }
        public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }
}