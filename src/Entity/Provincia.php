<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\ProvinciaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProvinciaRepository::class)]
#[ApiResource(
    shortName: 'Provincia',
    description: 'Entidad Provincia',
    normalizationContext: ['groups' => ['provincia:read']],
    denormalizationContext: ['groups' => ['provincia:write']],
    operations: [
        new GetCollection(
            openapiContext: [
                'summary' => 'Obtiene la lista de provincias',
            ],
            output: [
                'class' => Provincia::class,
                'collection' => true,]
        ),
        new Get(
            openapiContext: [
                'summary' => 'Obtiene una provincia por su id',
            ],
            output: Provincia::class,
        ),
        new Post(
            openapiContext: [
                'summary' => 'Agrega una provincia',
            ],
            inputFormats: ['json' => ['application/json']],
            output: Provincia::class,
        ),
        new Put(
            openapiContext: [
                'summary' => 'Actualiza una provincia',
            ],
            input: Provincia::class,
            output: Provincia::class,
        ),
        new Delete(
            openapiContext: [
                'summary' => 'Elimina una provincia',
            ],
            input: Provincia::class,
        ),
    ]
)]
class Provincia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    #[Groups(['provincia:read', 'provincia:write', 'ciudad:item:get'])]
    private ?string $descripcion = null;

    #[ORM\OneToMany(targetEntity: Ciudad::class, mappedBy: 'provincia')]
    #[Groups(['provincia:read'])]
    private Collection $ciudads;

    public function __construct()
    {
        $this->ciudads = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Ciudad>
     */
    public function getCiudads(): Collection
    {
        return $this->ciudads;
    }

    public function addCiudad(Ciudad $ciudad): static
    {
        if (!$this->ciudads->contains($ciudad)) {
            $this->ciudads->add($ciudad);
            $ciudad->setProvincia($this);
        }

        return $this;
    }

    public function removeCiudad(Ciudad $ciudad): static
    {
        if ($this->ciudads->removeElement($ciudad)) {
            // set the owning side to null (unless already changed)
            if ($ciudad->getProvincia() === $this) {
                $ciudad->setProvincia(null);
            }
        }

        return $this;
    }
}
