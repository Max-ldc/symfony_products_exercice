<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private const NB_PRODUCTS = 50;
    private const NB_CATEGORIES = 15;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0, $categories = []; $i < self::NB_CATEGORIES; $i++) {
            $category = new Category();
            $category
                ->setName($faker->word())
                ->setDescription($faker->realTextBetween(20, 80));
            $categories[] = $category;

            $manager->persist($category);
        }

        for ($i = 0; $i < self::NB_PRODUCTS; $i++) {
            $product = new Product();
            $product
                ->setName($faker->realText(15))
                ->setVisible($faker->boolean(80))
                ->setDescription($faker->realTextBetween(50, 150))
                ->setCategory($faker->randomElement($categories))
                ->setBasePrice($faker->randomFloat(2, 0, 1000))
                ->setDiscount($faker->boolean(22));

            $manager->persist($product);
        }

        $manager->flush();
    }
}
