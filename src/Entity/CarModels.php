<?php

namespace App\Entity;

use App\Repository\CarModelsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CarModelsRepository::class)
 */
class CarModels
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Assert\Type("integer")
     * @Assert\NotNull
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Type("string")
     * @Assert\Length(max=100)
     * @Assert\NotBlank
     */
    private $model;

    /**
     * @ORM\ManyToOne(targetEntity=CarBrands::class, inversedBy="carModels")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_car_brand;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Type("string")
     * @Assert\Length(max=100)
     * @Assert\NotBlank
     */
    private $car_brand;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getIdCarBrand(): ?CarBrands
    {
        return $this->id_car_brand;
    }

    public function setIdCarBrand(?CarBrands $id_car_brand): self
    {
        $this->id_car_brand = $id_car_brand;

        return $this;
    }

    public function getCarBrand(): ?string
    {
        return $this->car_brand;
    }

    public function setCarBrand(string $car_brand): self
    {
        $this->car_brand = $car_brand;

        return $this;
    }
}
