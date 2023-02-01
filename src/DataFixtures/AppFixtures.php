<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $admin = new User();
        $admin->setEmail('admin@me.fr');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin'));
        $admin->setIsVerified(true);
        $admin->setUsername('Super Admin');
        $admin->setFirstname('Alexis');
        $admin->setLastname('Boucherie');
        $admin->setGender('Homme');
        $admin->setAge(34);
        $admin->setCity('Bordeaux');
        $admin->setBiography($faker->paragraph(2));
        $admin->setPlaysSince('2005');
        $admin->setPlayerOrDM('Les deux');
        $admin->setGames('D&D, INS-MV');
        $admin->setCreatedAt($faker->dateTimeBetween('-3 month'));
        $manager->persist($admin);

        for ($i = 0; $i < 20; $i++) {
            $gender = ['Homme', 'Femme'];
            $city = ['Bordeaux', 'Lyon', 'Marseille', 'Angoulême', 'Poitiers', 'Libourne', 'Lille', 'Metz', 'Renne', 'Montpellier'];
            $playerOrDm = ['Joueur', 'Maître de Jeu', 'Les deux !'];
            $games = ['Star Wars', 'D&D', 'INS-MV', 'Pathfinder', 'Vampires', 'Shadowrun', 'LotR', 'Star Gate'];

            $user = new User();
            $user->setEmail($faker->email());
            $user->setRoles([]);
            $user->setPassword($this->passwordHasher->hashPassword($user, 'user'));
            $user->setIsVerified(true);
            $user->setUsername($faker->userName());
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setGender($gender[$faker->numberBetween(0, 1)]);
            $user->setAge($faker->numberBetween(16, 42));
            $user->setCity($city[$faker->numberBetween(0, 9)]);
            $user->setBiography($faker->paragraph($faker->numberBetween(1, 3)));
            $user->setPlaysSince('20'. rand(10, 23));
            $user->setPlayerOrDM($playerOrDm[$faker->numberBetween(0, 2)]);
            $user->setGames($games[$faker->numberBetween(0, 7)]);
            $user->setCreatedAt($faker->dateTimeBetween('-3 month'));
            $manager->persist($user);
        }
        $manager->flush();
    }
}
