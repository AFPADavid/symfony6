<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;
use App\Entity\User;

class UsersFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordEncoder)
    {

    }


    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('David.Grillon@afpa.fr');
        $admin->setLastname('GRILLON');
        $admin->setFirstname('David');
        $admin->setAdress('6 rue Georges et Mai Politzer');
        $admin->setZipcode('75012');
        $admin->setCity('Paris');
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin,"passwordAdmin")
        );
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);



        $faker = Faker\Factory::create('fr_FR');

        for($usr=1; $usr<=5; $usr++){

            $user = new User();
            $user->setEmail($faker->email);
            $user->setLastname($faker->lastname);
            $user->setFirstname($faker->firstname);
            $user->setAdress($faker->streetAddress);
            $user->setZipcode(str_replace(' ','',$faker->postcode));
            $user->setCity($faker->city);
            $user->setPassword(
                $this->passwordEncoder->hashPassword($user,"mdpuser")
            );
    
            $manager->persist($user);

        }




        $manager->flush();
    }
}
