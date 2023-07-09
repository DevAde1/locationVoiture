<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Vehicule;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for($j=1; $j<=mt_rand(7,9); $j++)
        {
            $vehicule = new Vehicule;
            $vehicule->setTitre($this->faker->sentence(2))
                    ->setMarque($this->faker->sentence(1))
                    ->setDescription($this->faker->paragraph())
                    ->setPhoto($this->faker->imageUrl(200, 300))
                    ->setPrixJournalier($this->faker->randomFloat(2, 10, 100))
                    ->setDateEnregistrement($this->faker->dateTimeBetween('-10 months'))
                    ->setModele($this->faker->sentence(1));
            $manager->persist($vehicule);
        
        }
        $manager->flush();
    }
}