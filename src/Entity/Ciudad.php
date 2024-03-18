<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CiudadRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CiudadRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['ciudad:read']],
    denormalizationContext: ['groups' => ['ciudad:write']],
)]
class Ciudad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    #[Groups(['ciudad:read', 'ciudad:write', 'provincia:read'])]
    private ?string $descripcion = null;

    #[ORM\ManyToOne(inversedBy: 'ciudads')]
    #[Groups(['ciudad:read', 'ciudad:write'])]
    private ?Provincia $provincia = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getProvincia(): ?Provincia
    {
        return $this->provincia;
    }

    public function setProvincia(?Provincia $provincia): static
    {
        $this->provincia = $provincia;

        return $this;
    }
}
