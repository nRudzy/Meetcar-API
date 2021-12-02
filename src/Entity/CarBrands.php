<?php

namespace App\Entity;

use App\Repository\CarBrandsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CarBrandsRepository::class)
 */
class CarBrands
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
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=CarModels::class, mappedBy="id_car_brand")
     * @ORM\JoinColumn(nullable=false)
     */
    private $carModels;

    public function __construct()
    {
        $this->carModels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|CarModels[]
     */
    public function getCarModels(): Collection
    {
        return $this->carModels;
    }

    public function addCarModel(CarModels $carModel): self
    {
        if (!$this->carModels->contains($carModel)) {
            $this->carModels[] = $carModel;
            $carModel->setIdCarBrand($this);
        }

        return $this;
    }

    public function removeCarModel(CarModels $carModel): self
    {
        if ($this->carModels->removeElement($carModel)) {
            // set the owning side to null (unless already changed)
            if ($carModel->getIdCarBrand() === $this) {
                $carModel->setIdCarBrand(null);
            }
        }

        return $this;
    }
}
