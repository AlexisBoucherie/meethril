<?php

namespace App\DataFixtures;

use App\Entity\Session;
use App\Entity\User;
use App\Entity\UserSession;
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
        $users = [];
        $sessions = [];

        // --- User Fixtures ---

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
            $city = ['Bordeaux', 'Angoulême', 'Poitiers', 'Libourne', 'Toulouse'];
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
            $user->setAge($faker->numberBetween(18, 42));
            $user->setCity($city[$faker->numberBetween(0, 4)]);
            $user->setBiography($faker->paragraph($faker->numberBetween(1, 3)));
            $user->setPlaysSince('20' . rand(15, 23));
            $user->setPlayerOrDM($playerOrDm[$faker->numberBetween(0, 2)]);
            $user->setGames($games[$faker->numberBetween(0, 7)]);
            $user->setCreatedAt($faker->dateTimeBetween('-3 month'));
            $manager->persist($user);
            $users[] = $user;
        }

        // --- Session Fixtures ---

        for ($i = 0; $i < 5; $i++) {
            $name = ['D&D v5', 'INS-MV v4', 'Star Wars D20'];
            $place = ['Bordeaux', 'Toulouse', 'En ligne'];
            $type = ['One-Shot', 'Campagne'];
            $image = [
                'https://images.ctfassets.net/swt2dsco9mfe/2jKQC6i2BM1HNQIzau3Biv/01bee47c8170a7d7f3f54f79777c4f3e/158867_670x370.jpg',
                'https://is5-ssl.mzstatic.com/image/thumb/Purple113/v4/96/a9/a7/96a9a723-0d41-b970-4257-ff0a160746ac/AppIcon-0-1x_U007emarketing-0-0-0-7-0-0-85-220.png/256x256bb.jpg',
                'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSJHTHRJ8xuoFqkwmzz8Qf7DkI9lmyn2WSHVw&usqp=CAU',
                'https://is5-ssl.mzstatic.com/image/thumb/Purple112/v4/c8/ae/27/c8ae27d8-a67e-d840-e097-86d993cb9b3a/AppIcon-0-0-1x_U007emarketing-0-0-0-7-0-0-sRGB-0-0-0-GLES2_U002c0-512MB-85-220-0-0.png/256x256bb.jpg',
                'https://images.ctfassets.net/swt2dsco9mfe/sG9OBgz3121mNJx9xFLkI/d4f07f919f46c7a87b38e3cca35e7773/670x370-essentials.jpg?w=365&h=196&fit=thumb',
            ];

            $session = new Session();
            $session->setName($name[$faker->numberBetween(0, 2)]);
            $session->setPlace($place[$faker->numberBetween(0, 2)]);
            $session->setDate($faker->dateTimeBetween('now', '+1 month'));
            $session->setType($type[$faker->numberBetween(0, 1)]);
            $session->setMaxPlayerNb($faker->numberBetween(3, 5));
            $session->setCurrentPlayerNb(0);
            $session->setDescription($faker->paragraph($faker->numberBetween(2, 3)));
            $session->setImage($image[$i]);
            $session->setCreatedAt($faker->dateTimeBetween('-1 month'));
            $manager->persist($session);
            $sessions[] = $session;
        }

        // --- UserSession Fixtures ---

        for ($i = 0; $i < 5; $i++) {
            $userSession = new UserSession();
            $userSession->setUserId($users[rand(0, count($users))]);
            $userSession->setSessionId($sessions[$i]);
            $userSession->setUserIsOwner(true);
            $manager->persist($userSession);
        }
        $manager->flush();
    }
}
