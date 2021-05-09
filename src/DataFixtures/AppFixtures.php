<?php

namespace App\DataFixtures;

use App\Entity\User;
use Faker;
use Faker\Factory;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    // public function __construct(CategoryRepository $catRepo, UserRepository $userRepo, UserPasswordEncoderInterface $passwordEncoder)
    public function __construct(UserRepository $userRepo, UserPasswordEncoderInterface $passwordEncoder)
    {
        // $this->catRepo = $catRepo;
        $this->userRepo = $userRepo;
        $this->passwordEncoder = $passwordEncoder;
    }


    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $faker->seed(1337);

        for ($u = 1; $u <= 10; $u++) {
            $user = new User();
            $user->setEmail(sprintf("email+%d@ville-pantin.fr", $u));
            // $user->setEmail($faker->email);
            $user->setFirstname($faker->firstName($gender = 'male' | 'female'));
            $user->setLastname($faker->lastName);

            if ($u === 1)
                $user->setRoles(['ROLE_ADMIN']);
            else
                $user->setRoles(['ROLE_USER']);


            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    '000000'
                )
            );
            $user->setIsVerified($faker->numberBetween(0, 1));
            $manager->persist($user);
        }
        $manager->flush();
    }
}