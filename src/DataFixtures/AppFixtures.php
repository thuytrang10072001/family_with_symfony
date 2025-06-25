<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Customer;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $customer = new Customer();
        $customer->setName('John Doe')
                ->setEmail('john_doe@example.com')
                ->setSize(42);

        $manager->persist($customer);

        $customer2 = new Customer();
        $customer2->setName('Jane Smith')
                  ->setEmail('jane_smith@example.com')
                  ->setSize(38);

        $manager->persist($customer2);
        
        $manager->flush();
    }
}
