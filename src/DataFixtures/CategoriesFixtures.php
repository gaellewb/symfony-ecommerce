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
        $parent = new Categories();
        $parent->setName('Informatique');
        $manager->persist($parent);

        $category = new Categories();
        $category->setName('Ordinateurs portables');
        $category->setParent($parent);
        $manager->persist($category);

        $category = new Categories();
        $category->setName('Ecrans');
        $category->setParent($parent);
        $manager->persist($category);

        $this->addReference('cat-'.$this->counter, $category);
        $this->counter++;

        $manager->flush();
    }
}
