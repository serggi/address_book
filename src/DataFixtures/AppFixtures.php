<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    const START_DATE = '1901-01-01';
    const END_DATE   = '2003-12-31';

    public function load(ObjectManager $manager)
    {
        for ($i = 0;$i < 1000; $i++) {
            $user = new User();
            $firstName = $this->getRandomFirstName();
            $lastName  = $this->getRandomLastName();
            $user
                ->setFirstName($firstName)
                ->setLastName($lastName)
                ->setBirthday($this->getRandomDob())
                ->setPhoneNumber($this->getRandomPhone())
                ->setEmail($this->getEmail($firstName, $lastName));
            $address = new Address();
            $address
                ->setCountry($this->getCountry())
                ->setCity($this->getRandomCity())
                ->setZip($this->getRandomZip())
                ->setStreet($this->getRandomStreet())
                ->setNumber($this->getRandomAddressNumber());
            $user->setAddress($address);
            $manager->persist($user);
        }

        $manager->flush();
    }

    private function getCountry(): string
    {
        return 'DE';
    }

    private function getRandomString(array $data): string
    {
        return $data[mt_rand(0, count($data) - 1)];
    }

    private function getRandomAddressNumber(): string
    {
        $number = mt_rand(1, 98);
        $suffixRange = range('A', 'D');
        $suffix = mt_rand(1, 5) === 5 ? $this->getRandomString($suffixRange): '';

        return rtrim(sprintf('%s-%s',$number, $suffix), '-');
    }

    private function getRandomDob(): \DateTimeImmutable
    {
        $startTime  = strtotime(self::START_DATE);
        $endTime    = strtotime(self::END_DATE);
        $randomDate = date('Y-m-d', mt_rand($startTime, $endTime));

        return new \DateTimeImmutable($randomDate);
    }

    private function getRandomCity(): string
    {
        $data = [
            'Augsburg',
            'Berlin',
            'Bonn',
            'Bremen',
            'Cologne',
            'Dortmund',
            'Dresden',
            'Düsseldorf',
            'Erfurt',
            'Essen',
            'Frankfurt',
            'Hamburg',
            'Hannover',
            'Kaiserslautern',
            'Karlsruhe',
            'Leipzig',
            'Leverkusen',
            'Mannheim',
            'Munich',
            'Münster',
            'Nuremberg',
            'Rostock',
            'Stuttgart',
            'Wolfsburg',
        ];

        return $this->getRandomString($data);
    }

    private function getRandomZip(): int
    {
        return mt_rand(11000, 97999);
    }

    private function getRandomPhone(): string
    {
        return '+490'.mt_rand(300000000, 899999999);
    }

    private function getEmail(string $firstName, string $lastName): string
    {
        $data = [
            'gmail.com',
            'hotline.com',
            'outlook.com',
            'yahoo.com',
        ];

        return sprintf('%s.%s%s@%s', $firstName, $lastName, mt_rand(10, 2021), $this->getRandomString($data));
    }

    private function getRandomFirstName(): string
    {
        $data = [
            'Anna',
            'Anton',
            'Ben',
            'Clara',
            'Elias',
            'Ella',
            'Emil',
            'Emilia',
            'Emily',
            'Emma',
            'Felix',
            'Finn',
            'Frieda',
            'Hannah',
            'Henry',
            'Ida',
            'Jakob',
            'Jonas',
            'Lea',
            'Lena',
            'Leni',
            'Leo',
            'Leon',
            'Lia',
            'Liam',
            'Lina',
            'Luca',
            'Luis',
            'Luisa',
            'Lukas',
            'Marie',
            'Mathilda',
            'Matteo',
            'Maximilian',
            'Mia',
            'Mila',
            'Noah',
            'Paul',
            'Sofia',
            'Theo',
        ];

        return $this->getRandomString($data);
    }

    private function getRandomLastName(): string
    {
        $data = [
            'Aber',
            'Ackermann',
            'Ahmann',
            'Apfelbaum',
            'Bauer',
            'Baumann',
            'Beck',
            'Becker',
            'Berger',
            'Bergmann',
            'Braun',
            'Busch',
            'Candler',
            'Christen',
            'Clemens',
            'Dahlem',
            'Dahlheimer',
            'Degenhardt',
            'Fischer',
            'Fuchs',
            'Groß',
            'Haas',
            'Hahn',
            'Hartmann',
            'Herrmann',
            'Hoffmann',
            'Hofmann',
            'Huber',
            'Jung',
            'Kaiser',
            'Keller',
            'Klein',
            'Koch',
            'Kraus',
            'Krause',
            'Krämer',
            'Krüger',
            'Kuhn',
            'Köhler',
            'König',
            'Kühn',
            'Lange',
            'Lehmann',
            'Maier',
            'Mayer',
            'Meier',
            'Meyer',
            'Möller',
            'Müller',
            'Neumann',
            'Ohlendorf',
            'Oppenheim',
            'Otto',
            'Parlow',
            'Peltzer',
            'Peters',
            'Pfeiffer',
            'Quandt',
            'Quillman',
            'Quiring',
            'Richter',
            'Sauer',
            'Salinger',
            'Schmid',
            'Schmidt',
            'Schmitt',
            'Schmitz',
            'Schneider',
            'Scholz',
            'Schreiber',
            'Schröder',
            'Schubert',
            'Schulz',
            'Schulze',
            'Schumacher',
            'Schuster',
            'Schwarz',
            'Schäfer',
            'Seidel',
            'Sommer',
            'Stein',
            'Tasler',
            'Tennenbaum',
            'Teubner',
            'Thomas',
            'Tober',
            'Tritschler',
            'Trotter',
            'Trummer',
            'Uhler',
            'Ulmer',
            'Umberger',
            'Veitenheimer',
            'Viehmann',
            'Voehl',
            'Vogel',
            'Vogt',
            'Voigt',
            'Wagner',
            'Walter',
            'Weber',
            'Weiß',
            'Werner',
            'Winkler',
            'Wolf',
            'Wolff',
            'Ziegler',
            'Zimmermann',
            'Zoeller',
            'Zwiebel',
        ];

        return $this->getRandomString($data);
    }

    private function getRandomStreet(): string
    {
        $data = [
            'Ahornweg',
            'Am Kapf',
            'Amsinckstraße',
            'An der Krähenheide',
            'An Der Urania',
            'Bergstraße',
            'Büsingstraße',
            'Carl-Haas-Straße',
            'Fritz-Reim-Straße',
            'Gotthardstraße',
            'Gotzkowskystraße',
            'Grüne',
            'Havelmatensteig',
            'Herschelstraße',
            'Hochstraße',
            'Hollander',
            'Joachimstaler',
            'Kirchenäcker',
            'Kraichgaustraße',
            'Kurfuerstendamm',
            'Kurfürstenstraße',
            'Leipziger',
            'Leipziger',
            'Leopoldstraße',
            'Los-Angeles-Platz',
            'Mellingburgredder',
            'Mollstraße',
            'Muttert',
            'Rhinstraße',
            'Rudower Chaussee',
            'Schillerstraße',
            'Schmarjestraße',
            'Schoenebergerstraße',
            'Weiherrain',
            'Wiesenweg',
            'Wilhelm-von-Leibniz-Straße',
            'Winzerkellerstraße',
        ];

        return $this->getRandomString($data);
    }
}
