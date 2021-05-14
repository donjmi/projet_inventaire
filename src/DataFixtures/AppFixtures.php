<?php

namespace App\DataFixtures;

use Faker;
use Faker\Factory;
use App\Entity\User;
use App\Entity\State;
use App\Entity\Bulding;
use App\Entity\Category;
use App\Entity\Planning;
use App\Entity\Equipment;
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

            $this->addReference('user_' . $u, $user);
            $manager->flush();
        }

        // tableau préparation données fixtures 
        $categories = ['Armoire', 'Bureau', 'Chaise', 'Fauteuil', 'Equipement sportif', 'Matériel de santé', 'Matériel crèche', 'FIPHP'];
        $buldings = ['Centre administratif', 'Hotel de ville', 'CTM', 'Atelier', 'Garage', 'MDQ 4chemins', 'MDQ courtillières', 'Crèches courtillières'];
        $plannings = ['', '2022', '2023', '2024', '2025', '2026', '2027'];
        $states = ['Bon', 'Moyen', 'Mauvais', 'A changer d\'urgence'];

        // fixtures categories
        foreach ($categories as $key => $item) {
            $category = new Category();
            $category->setName($item);
            $manager->persist($category);

            $this->addReference('cat_' . $key, $category);
        }

        // création Etat du bien
        foreach ($states as $key => $item) {
            $state = new State();
            $state->setName($item);
            $manager->persist($state);

            $this->addReference('state_' . $key, $state);
        }

        // création année de changement du bien
        foreach ($plannings as $key => $item) {
            $planning = new Planning();
            $planning->setYear($item);
            $manager->persist($planning);

            $this->addReference('planning_' . $key, $planning);
        }
        // création lieu du bien
        foreach ($buldings as $key => $item) {
            $bulding = new Bulding();
            $bulding->setCode('NUM' . $faker->numberBetween(100, 150));
            $bulding->setDescription($item);
            $bulding->SetRoom("Bureau");
            $bulding->setName($item);
            $manager->persist($bulding);

            $this->addReference('build_' . $key, $bulding);
        }

        for ($i = 0; $i < 30; $i++) {
            $catego = $this->getReference('cat_' . $faker->numberBetween(0, 7));
            $stat = $this->getReference('state_' . $faker->numberBetween(0, 3));
            $shed = $this->getReference('planning_' . $faker->numberBetween(0, 5));
            $buil = $this->getReference('build_' . $faker->numberBetween(0, 7));
            $users = $this->getReference('user_' . $faker->numberBetween(1, 5));

            $equipment = new Equipment();
            $equipment->setAmount('1');
            // $equipment->setDescription($faker->text($maxNbChars = 100));
            $equipment->setDescription($faker->randomElement(['Armoire haute', 'Armoire basse', 'Fauteuil de bureu', 'Réfrigérateur', 'Plaque de cuisson', 'Lits bébé', 'Panier de basket', 'matériel dentiste']));
            $equipment->setCategory($catego);
            $equipment->setState($stat);
            $equipment->setPlanning($shed);
            $equipment->setBulding($buil);
            $equipment->setUser($users);


            $manager->persist($equipment);
        }

        $manager->flush();
    }
}