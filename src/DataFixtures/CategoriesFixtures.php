<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categories;

class CategoriesFixtures extends Fixture
{
    private $counter = 1;

    public function load(ObjectManager $manager): void
    {
        // Créer un nouvel objet Categorie
        $parent = new Categories();

        // Nourrir l'objet Categorie
        $parent->setName('Informatique');

        // Persister les données
        $manager->persist($parent);





         // Créer un nouvel objet Categorie
         $category = new Categories();

         // Nourrir l'objet Categorie
         $category->setName('Ordinateur');

         // Création du parent
         $category->setParent($parent);
 
         // Persister les données
         $manager->persist($category);

         $this->addReference('cat-'.$this->counter, $category);
         $this->counter++;
 
         // Pusher le tout dans la BDD
         $manager->flush();

    }
}
