<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

use App\Entity\Images;

class ImagesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        // function imageUrl(
        //     int $width = 640,
        //     int $height = 480,
        //     ?string $category = null, /* used as text on the image */
        //     bool $randomize = true,
        //     ?string $word = null,
        //     bool $gray = false,
        //     string $format = 'png'
        // ): string;

        for($img = 1; $img <= 100; $img++){
            $image = new Images();
            // $image->setName($faker->image(null, 640, 480));
            // $image->setName($faker->imageUrl(null, 640, 480));
            $image->setName($faker->regexify('[A-Za-z0-9]{10}') . '.jpg');

            $product = $this->getReference('prod-'.rand(1, 10));
            $image->setProducts($product);
            $manager->persist($image);
        }

        $manager->flush();
    }

    public function getDependencies():array
    {
        return[
            //mettre les fixtures qui doivent être exécuter avant Images
            ProductsFixtures::class
        ];
    }
}
