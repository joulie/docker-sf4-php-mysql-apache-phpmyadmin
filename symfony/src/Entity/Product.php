<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 15/11/18
 * Time: 20:32
 */
// src/Entity/Product.php
namespace App\Entity;


class Product
{
    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload the product brochure as a PDF file.")
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    private $brochure;

    public function getBrochure()
    {
        return $this->brochure;
    }

    public function setBrochure($brochure)
    {
        $this->brochure = $brochure;

        return $this;
    }
}