<?php
// src/Entity/UserLabels.php : récupération identifiant;nom;prenom;telephone dans le but d'utiliser une entité dans le test, sans avoir le temps de réfléchir à son utilité

namespace App\Entity;

class UserLabels
{
    protected $id;

    protected $lastName;

    protected $firstName;

    protected $phoneNumber;



    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
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