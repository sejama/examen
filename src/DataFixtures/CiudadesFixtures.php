<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Ciudad;
use App\DataFixtures\ProvinciaFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CiudadesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $ciudad = new Ciudad();
        $ciudad->setDescripcion('Santa Fe');
        $ciudad->setProvincia($this->getReference(ProvinciaFixtures::PROVINCIAS['Santa Fe']));
        $manager->persist($ciudad);

        $ciudad = new Ciudad();
        $ciudad->setDescripcion('Rosario');
        $ciudad->setProvincia($this->getReference(ProvinciaFixtures::PROVINCIAS['Santa Fe']));
        $manager->persist($ciudad);

        $ciudad = new Ciudad();
        $ciudad->setDescripcion('Corrientes');
        $ciudad->setProvincia($this->getReference(ProvinciaFixtures::PROVINCIAS['Corrientes']));
        $manager->persist($ciudad);

        $ciudad = new Ciudad();
        $ciudad->setDescripcion('La Matanza');
        $ciudad->setProvincia($this->getReference(ProvinciaFixtures::PROVINCIAS['Buenos Aires']));
        $manager->persist($ciudad);
        
        $ciudad = new Ciudad();
        $ciudad->setDescripcion('Lanús');
        $ciudad->setProvincia($this->getReference(ProvinciaFixtures::PROVINCIAS['Buenos Aires']));
        $manager->persist($ciudad);
        
        $ciudad = new Ciudad();
        $ciudad->setDescripcion('La Plata');
        $ciudad->setProvincia($this->getReference(ProvinciaFixtures::PROVINCIAS['Buenos Aires']));
        $manager->persist($ciudad);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProvinciaFixtures::class,
        ];
    }
}
