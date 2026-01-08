<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\AuctionState;
use App\Enums\CategoryType;
use App\Enums\Condition;
use App\Models\Auction;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            "kacper" => [
                "firstname" => "Kacper",
                "surname" => "Walenga",
                "phone" => "+48500600700",
                "email" => "kacper@demo.local",
                "password" => "password",
                "city" => "Kraków",
            ],
            "jan" => [
                "firstname" => "Jan",
                "surname" => "Kowalski",
                "phone" => "+48213721372",
                "email" => "jan@demo.local",
                "password" => "password",
                "city" => "Legnica",
            ],

            "anna" => [
                "firstname" => "Anna",
                "surname" => "Nowak",
                "phone" => "+48501111222",
                "email" => "anna@demo.local",
                "password" => "password",
                "city" => "Warszawa",
            ],
            "piotr" => [
                "firstname" => "Piotr",
                "surname" => "Zieliński",
                "phone" => "+48502222333",
                "email" => "piotr@demo.local",
                "password" => "password",
                "city" => "Poznań",
            ],
            "magda" => [
                "firstname" => "Magdalena",
                "surname" => "Kaczmarek",
                "phone" => "+48503333444",
                "email" => "magda@demo.local",
                "password" => "password",
                "city" => "Wrocław",
            ],
            "tomasz" => [
                "firstname" => "Tomasz",
                "surname" => "Lewandowski",
                "phone" => "+48504444555",
                "email" => "tomasz@demo.local",
                "password" => "password",
                "city" => "Gdańsk",
            ],
            "pawel" => [
                "firstname" => "Paweł",
                "surname" => "Dąbrowski",
                "phone" => "+48505555666",
                "email" => "pawel@demo.local",
                "password" => "password",
                "city" => "Gdynia",
            ],
            "agnieszka" => [
                "firstname" => "Agnieszka",
                "surname" => "Piotrowska",
                "phone" => "+48506666777",
                "email" => "agnieszka@demo.local",
                "password" => "password",
                "city" => "Szczecin",
            ],
            "mateusz" => [
                "firstname" => "Mateusz",
                "surname" => "Grabowski",
                "phone" => "+48507777888",
                "email" => "mateusz@demo.local",
                "password" => "password",
                "city" => "Rzeszów",
            ],
            "karolina" => [
                "firstname" => "Karolina",
                "surname" => "Wójcik",
                "phone" => "+48508888999",
                "email" => "karolina@demo.local",
                "password" => "password",
                "city" => "Lublin",
            ],
            "lukasz" => [
                "firstname" => "Łukasz",
                "surname" => "Kamiński",
                "phone" => "+48509999000",
                "email" => "lukasz@demo.local",
                "password" => "password",
                "city" => "Białystok",
            ],
            "michal" => [
                "firstname" => "Michał",
                "surname" => "Kozłowski",
                "phone" => "+48501234123",
                "email" => "michal@demo.local",
                "password" => "password",
                "city" => "Olsztyn",
            ],
            "natalia" => [
                "firstname" => "Natalia",
                "surname" => "Mazur",
                "phone" => "+48502345234",
                "email" => "natalia@demo.local",
                "password" => "password",
                "city" => "Opole",
            ],
            "bartek" => [
                "firstname" => "Bartosz",
                "surname" => "Kubiak",
                "phone" => "+48503456345",
                "email" => "bartek@demo.local",
                "password" => "password",
                "city" => "Zielona Góra",
            ],
            "monika" => [
                "firstname" => "Monika",
                "surname" => "Szymańska",
                "phone" => "+48504567456",
                "email" => "monika@demo.local",
                "password" => "password",
                "city" => "Katowice",
            ],
            "rafal" => [
                "firstname" => "Rafał",
                "surname" => "Woźniak",
                "phone" => "+48505678567",
                "email" => "rafal@demo.local",
                "password" => "password",
                "city" => "Gliwice",
            ],
            "justyna" => [
                "firstname" => "Justyna",
                "surname" => "Kalinowska",
                "phone" => "+48506789678",
                "email" => "justyna@demo.local",
                "password" => "password",
                "city" => "Toruń",
            ],
            "sebastian" => [
                "firstname" => "Sebastian",
                "surname" => "Pawlak",
                "phone" => "+48507890789",
                "email" => "sebastian@demo.local",
                "password" => "password",
                "city" => "Bydgoszcz",
            ],
            "klaudia" => [
                "firstname" => "Klaudia",
                "surname" => "Michalska",
                "phone" => "+48508901890",
                "email" => "klaudia@demo.local",
                "password" => "password",
                "city" => "Koszalin",
            ],
            "damian" => [
                "firstname" => "Damian",
                "surname" => "Jankowski",
                "phone" => "+48509012901",
                "email" => "damian@demo.local",
                "password" => "password",
                "city" => "Radom",
            ],
        ];

        /** @var array<string, User> $userByAlias */
        $userByAlias = [];
        $seedImagesDir = database_path("seeders/demo-images");

        foreach ($users as $alias => $data) {
            $userByAlias[$alias] = User::query()->firstOrCreate(
                ["email" => $data["email"]],
                [
                    "firstname" => $data["firstname"],
                    "surname" => $data["surname"],
                    "phone" => $data["phone"],
                    "name" => $data["firstname"] . " " . $data["surname"],
                    "password" => Hash::make($data["password"]),
                    "email_verified_at" => now(),
                ],
            );
        }

        $auctions = [
            [
                "title" => "FSC Żuk A11B Zbiornik paliwa",
                "price" => 1199.99,
                "description" => "GWARANCJA ROZRUCHOWA 14 DNI OD ZAKUPU , TYLKO NA TOWARY SPRAWNE ( USZKODZONE NIE PODLEGAJĄ ZWROTOM )...",
                "category" => CategoryType::FUEL_SYSTEM,
                "brand" => "FSC",
                "model" => "Zuk",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
                "created_at" => "2024-01-03 10:10:00",
            ],
            [
                "title" => "Silnik kompletny S21",
                "description" => "Silnik kompletny jak na zdjęciach. 20 lat temu został zdemontowany z zuka. Pracował do samego końca. Przechowywany w suchym garażu.",
                "price" => 100.00,
                "category" => CategoryType::ENGINE,
                "brand" => "FSC",
                "model" => "Zuk",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],
            [
                "title" => "Silnik Andoria Żuk",
                "description" => "Witam, Mam na sprzedaż części z silnka 4CT90.",
                "price" => 100.00,
                "category" => CategoryType::ENGINE,
                "brand" => "FSC",
                "model" => "Zuk",
                "condition" => Condition::FOR_PARTS,
                "state" => AuctionState::ACTIVE,
            ],
            [
                "title" => "Silnik Żuk S21 – benzyna",
                "description" => "Na sprzedaż silnik benzynowy S21 z Żuka. Możliwość sprawdzenia silnika w aucie przed zakupem – pracuje i odpala.",
                "price" => 1500.00,
                "category" => CategoryType::ENGINE,
                "brand" => "FSC",
                "model" => "Zuk",
                "condition" => Condition::GOOD_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],
            [
                "title" => "LICZNIK FSC ŻUK 2.1 B",
                "description" => "LICZNIK FSC ŻUK",
                "price" => 71.00,
                "category" => CategoryType::INTERIOR,
                "brand" => "FSC",
                "model" => "Zuk",
                "condition" => Condition::GOOD_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],
            [
                "title" => "Żuk tylny most skracany kompletny",
                "description" => "Żuk tylny most skracany kompletny sprawny odległości między tarczami kotwicznymi 110cm",
                "price" => 450.00,
                "category" => CategoryType::AXLE,
                "brand" => "FSC",
                "model" => "Zuk",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],
            [
                "title" => "licznik Warszawa , Nysa ,Żuk",
                "description" => "Witam. Sprzedam licznik i zegar do samochodu Żuk , Nysa ,Warszawa. Zegar sprawny licznik po przekręcaniu linką wskazuje prędkość. Cena za komplet.",
                "price" => 80.00,
                "category" => CategoryType::INTERIOR,
                "brand" => "FSC",
                "model" => "Zuk",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],
            [
                "title" => "BMW F10 DRZWI LEWY TYŁ 375",
                "description" => "BMW F10 DRZWI LEWY TYŁ KOD LAKIERU: 354 ",
                "price" => 600.00,
                "category" => CategoryType::DOORS,
                "brand" => "BMW",
                "model" => "5 Series",
                "condition" => Condition::NEARLY_NEW,
                "state" => AuctionState::ACTIVE,
            ],
            [
                "title" => "BMW F10 LIFT FOTELE KANAPA",
                "description" => "BMW F10 LIFT FOTELE KANAPA BOCZKI GRZANE ANGLIK",
                "price" => 880.00,
                "category" => CategoryType::INTERIOR,
                "brand" => "BMW",
                "model" => "5 Series",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],
            [
                "title" => "Kierownica ford focus mk3 lift",
                "description" => "Sprzedam kierownicę do Forda Focusa Mk3 po lifcie (2014–2018).",
                "price" => 150.00,
                "category" => CategoryType::INTERIOR,
                "brand" => "FSC",
                "model" => "Zuk",
                "condition" => Condition::GOOD_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],
            [
                "title" => "SKRZYNIA BIEGÓW FORD PUMA L1TR7002CFC 2690271 L1TR7002CFB BRATFORD RADOM",
                "description" => "Części do Forda Bratford Radom Serwis Montaż Gwarancja Profesjonalne usługi tylko Ford Jesteśmy specjalistą tylko Ford Masz problem z Fordem to dzwoń Posiadamy wszystkie części do Forda Bratford Radom Serwis Montaż Gwarancja",
                "price" => 5000.00,
                "category" => CategoryType::INTERIOR,
                "brand" => "brand",
                "model" => "model",
                "image" => "image",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],
            [
                "title" => "SKRZYNIA BIEGÓW FORD PUMA L1TR7002CFC 2690271 L1TR7002CFB BRATFORD RADOM",
                "description" => "Części do Forda Bratford Radom Serwis Montaż Gwarancja Profesjonalne usługi tylko Ford Jesteśmy specjalistą tylko Ford Masz problem z Fordem to dzwoń Posiadamy wszystkie części do Forda Bratford Radom Serwis Montaż Gwarancja",
                "price" => 5000.00,
                "category" => CategoryType::INTERIOR,
                "brand" => "brand",
                "model" => "model",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],
            [
                "title" => "SKRZYNIA BIEGÓW FORD PUMA L1TR7002CFC 2690271 L1TR7002CFB BRATFORD RADOM",
                "description" => "Części do Forda Bratford Radom Serwis Montaż Gwarancja Profesjonalne usługi tylko Ford Jesteśmy specjalistą tylko Ford Masz problem z Fordem to dzwoń Posiadamy wszystkie części do Forda Bratford Radom Serwis Montaż Gwarancja",
                "price" => 5000.00,
                "category" => CategoryType::GEARBOX,
                "brand" => "Ford",
                "model" => "Puma",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "TYLNA KLAPA HONDA CRV IV 12-18 LAK NH731P",
                "description" => "WITAM. MAM DO SPRZEDANIA: TYLNA KLAPA HONDA CRV IV 12-18 LAK: NH731P (20.03.25)",
                "price" => 3499.00,
                "category" => CategoryType::BODY,
                "brand" => "Honda",
                "model" => "CR-V",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "Silnik Ford YMCB YMR6 YLF6 YLCA YMFS YMF6 YNRA YMRA BLRA",
                "description" => "Części do Forda Bratford Radom Serwis montaż gwarancja Jesteśmy specjalistą od Forda Masz problem z Fordem to dzwoń Posiadamy wszystkie części do Forda Bratford Radom Serwis Montaż Gwarancja Profesjonalne usługi tylko Ford",
                "price" => 21500.00,
                "category" => CategoryType::ENGINE,
                "brand" => "Ford",
                "model" => "Galaxy",
                "condition" => Condition::GOOD_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "SILNIK D4HA 2.0 CRDI EU5 KIA SPORTAGE HYUNDAI IX35 MANUAL",
                "description" => "SILNIK D4HA 2.0 CRDI EU5 KIA SPORTAGE HYUNDAI IX35 Silnik z osprzętem jak na foto . 2013 przebieg 112 tys. km stan bardzo dobry jak na zamieszczonych zdjęciach ! Przed demontażem odpalony , nagrany film , moge przeslać . posiadam inne cześci do tego modelu , zobacz inne moje ogłoszenia ! ODBIÓR OSOBISTY LUB MOGĘ TEŻ WYSŁAĆ ! koszt wysyłki uzależniony od wagi i wielkości przedmiotu .",
                "price" => 8700.00,
                "category" => CategoryType::ENGINE,
                "brand" => "Kia",
                "model" => "Sportage",
                "condition" => Condition::GOOD_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "Skrzynia biegów Ford Transit GK3R7003GB BRATFORD RADOM",
                "description" => "Części do Forda Bratford Radom Serwis montaż gwarancja",
                "price" => 7000.00,
                "category" => CategoryType::GEARBOX,
                "brand" => "Ford",
                "model" => "Transit",
                "condition" => Condition::NEARLY_NEW,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "Fiat 125p kierownica",
                "description" => "Sprzedam kierownicę z ringiem do Fiata 125p ST 67-73r niekompletna brak sprężyny przycisku sygnału cena 350zl stan kierownicy widoczny na zdjęciach posiadam inne kierownice kompletne i do skompletowania informacje na tel.",
                "price" => 350.00,
                "category" => CategoryType::STEERING,
                "brand" => "FSO",
                "model" => "Polski Fiat 125p",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "Kierownica Poduszka Kierownicy Mercedes W221",
                "description" => "Na sprzedaż kierownica skórzana z przełącznikami zmiany biegów z Mercedesa W221 w komplecie z poduszką lub osobno. Stan dobry. Zapraszam do kontaktu.",
                "price" => 200.00,
                "category" => CategoryType::STEERING,
                "brand" => "Mercedes-Benz",
                "model" => "S-Class",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "TYLNA KLAPA SKODA OCTAVIA KOMBI BEZ RDZY 04-13 LAK LA7W 8E8E 9156",
                "description" => "WITAM. MAM DO SPRZEDANIA : TYLNA KLAPA SKODA OCTAVIA KOMBI BEZ RDZY 04-13 LAK: LA7W 8E8E 9156 (03.07.2025)",
                "price" => 2299.00,
                "category" => CategoryType::BODY,
                "brand" => "Skoda",
                "model" => "Octavia",
                "condition" => Condition::GOOD_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "ZDERZAK PRZÓD KOMPLETNY RENAULT SCENIC III LIFT LAK TERPB",
                "description" => "WITAM. MAM DO SPRZEDANIA: ZDERZAK PRZÓD KOMPLETNY RENAULT SCENIC III LIFT LAK: TERPB (10.04.2025)",
                "price" => 2999.00,
                "category" => CategoryType::BODY,
                "brand" => "Renault",
                "model" => "Scenic",
                "condition" => Condition::GOOD_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "ZACISK HAMULCOWY LEWY PRZÓD VW NEW BEETLE 2.0B",
                "description" => "ZACISK HAMULCOWY LEWY PRZÓD VW NEW BEETLE ORYGINAŁ STAN WIDOCZNY NA ZDJĘCIACH",
                "price" => 50.00,
                "category" => CategoryType::BRAKES,
                "brand" => "Volkswagen",
                "model" => "model",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "Tarcze Kotwiczne Osłona Tarczy 312mm Audi A4 B5 A6 C5",
                "description" => "Na sprzedaż Tarcze kotwiczne przeznaczone do zestawu tarcz 312mm w Audi A4 B5 A6 C5 i nie tylko Stan bardzo dobry, jedna była malowana lakierem FOLIATEC. Cena za komplet ( 2szt) Możliwa wysyła siedem dziewięć trzy zero dwanaście pięć pięć jeden",
                "price" => 40.00,
                "category" => CategoryType::BRAKES,
                "brand" => "Audi",
                "model" => "A4",
                "condition" => Condition::GOOD_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "Mercedes-Benz W124 Serwo hamulca pompa ATE",
                "description" => "Kod części: 2034301730 Strona zabudowy: - Model: E W124 Rodzaj nadwozia: Kombi Lata produkcji: 1987 Pojemnosc silnika: 2.0 L Skrzynia biegow: Mechaniczna A1P1513 . Część jest sprawna. Stan widoczny na zdjęciach. W razie pytań służymy pomocą tel********* W naszych magazynach znajduje się kilka tysięcy części. Jeżeli nie możesz znaleźć szukanej pozycji na naszych aukcjach skontaktuj się z nami telefonicznie pod numerem *********. Posiadamy części do Mercedesów W108, W109, W115, W114, W116, W123, W124, W126, W201 oraz innych.",
                "price" => 99.00,
                "category" => CategoryType::BRAKES,
                "brand" => "Mercedes-Benz",
                "model" => "E-Class",
                "condition" => Condition::GOOD_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "Tarcza hamulcowa przód Fusion Mondeo mk5 mkV średnica 300 mm",
                "description" => "Sprzedam tarczę hamulcową przód Ford Fusion Mondeo mk5 mkV średnica 300 mm. Preferowany odbiór osobisty.",
                "price" => 40.00,
                "category" => CategoryType::BRAKES,
                "brand" => "Ford",
                "model" => "Mondeo",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "POMPA ABS 476601406R Renault Kangoo II (2008- )",
                "description" => "POMPA ABS 476601406R Renault Kangoo II (2008- ) ID:541037 Oferowana część pochodzi z pojazdu: Marka:Renault Model:Kangoo Podmodel:II (2008- ) Rocznik:2018 Pojemność silnika:1461 Paliwo:Diesel Numer producenta:476601406R Udzielamy 90 dni gwarancji na zakupioną część.",
                "price" => 99.00,
                "category" => CategoryType::BRAKES,
                "brand" => "Renault",
                "model" => "Kangoo",
                "condition" => Condition::GOOD_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "Tarcze Hamulcowe Ford Fokus Mk1 1.8 Tddi",
                "description" => "Witam mam do sprzedania tarcze hamulcowe tylne do Forda Fokusa Mk1 z 2001r 1.8 tddi 90KM kod lakieru R8 posiadam także inne części do w/w auta. Mozliwa wysyłka. Polecam",
                "price" => 30.00,
                "category" => CategoryType::BRAKES,
                "brand" => "Ford",
                "model" => "Focus",
                "condition" => Condition::GOOD_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "Czujnik NOX FORD TRANSIT 2601469 GK215E145AE BRATFORD 2665334 GK215E145AF",
                "description" => "Części do Forda Bratford Radom Serwis montaż gwarancja Profesjonalne usługi tylko Ford Jesteśmy specjalistą tylko Ford Masz problem z Fordem to dzwoń",
                "price" => 1400.00,
                "category" => CategoryType::EXHAUST,
                "brand" => "Ford",
                "model" => "Transit",
                "condition" => Condition::GOOD_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "KOMPUTER STEROWNIK 37820-RB0-E14 -WYSYŁKA- K4",
                "description" => "WITAM. Mam do sprzedania komputer o numerze 37820-RB0-E14.",
                "price" => 150.00,
                "category" => CategoryType::ELECTRICAL,
                "brand" => "Honda",
                "model" => "Jazz",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "MODUŁ START STOP CITROEN PEUGEOT 1.6HDI KOMPLETNY 9805721280 9802096780 K1",
                "description" => "WITAM. MAM DO SPRZEDANIA: MODUŁ START STOP CITROEN PEUGEOT 1.6HDI KOMPLETNY 9805721280 9802096780 *K1 (07.02.25)",
                "price" => 399.00,
                "category" => CategoryType::ELECTRICAL,
                "brand" => "Peugeot",
                "model" => "308",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "Silnik wycieraczki szyby tylnej klapy Zafira C Orlando",
                "description" => "Ładny Opel Zafira C, cały na części. Ogłoszenie dotyczy silniczka tylnej wycieraczki. Widoczny na zdjęciach. Oznaczenia: 13256923 . Stosowany w wielu modelach: ( Zafira C , Orlando ). Więcej informacji telefonicznie - *** *** *** . Polecam i zapraszam na pozostałe moje ogłoszenia. // ...",
                "price" => 100.00,
                "category" => CategoryType::ELECTRICAL,
                "brand" => "Opel",
                "model" => "Zafira",
                "condition" => Condition::GOOD_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "KOMPUTER STEROWNIK 0261S04473 K34 -WYSYŁKA-",
                "description" => "Witam. Mam do sprzedania komputer, sterownik o numerze 0261S04473. Jak na widocznym zdjęciu.",
                "price" => 45.00,
                "category" => CategoryType::ELECTRICAL,
                "brand" => "Suzuki",
                "model" => "Alto",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "KOMPUTER STEROWNIK 03C906027BJ 0261S07086 K33",
                "description" => "Witam. Mam do sprzedania KOMPUTER / STEROWNIK 03C906027BJ 0261S07086 *K33",
                "price" => 1200.00,
                "category" => CategoryType::ELECTRICAL,
                "brand" => "Volkswagen",
                "model" => "Golf",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "MERCEDES W204 ZAMEK KLAPY BAGAŻNIKA A2047500185",
                "description" => "PRZEDMIOTEM SPRZEDAŻY JEST: ORYGINALNY ZAMEK KLAPY BAGAŻNIKA Nr części A2047500185 MARKA: MERCEDES - BENZ W204 W212 Stan bardzo dobry",
                "price" => 45.00,
                "category" => CategoryType::BODY,
                "brand" => "Mercedes-Benz",
                "model" => "C-Class",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "KOMPUTEROWY STEROWNIK SILNIKA TOYOTA 89661-05N70",
                "description" => "Przedmiotem aukcji jest oryginalny Moduł KOMPUTEROWY STEROWNIK SILNIKA TOYOTA NR 89661-05N70 Rok produkcji 2014 Firma DENSO",
                "price" => 700.00,
                "category" => CategoryType::ELECTRICAL,
                "brand" => "Toyota",
                "model" => "Corolla",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "PRZEKAŹNIK STEROWNIK ŚWIEC ŻAROWYCH 779800003 N47",
                "description" => "STEROWNIK PRZEKAŹNIK ŚWIEC ŻAROWYCH ... MARKA : BMW MODEL : E60 E61 E90 E87 E83 ROK PRODUKCJI : 2003-2010 ...",
                "price" => 200.00,
                "category" => CategoryType::ELECTRICAL,
                "brand" => "BMW",
                "model" => "5 Series",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "AUDI A6 A7 A8 moduł sterownik hamulca 4H0907801G",
                "description" => "Przedmiotem aukcji jest oryginalny sterownik STEROWNIK HAMULCA RĘCZNEGO AUDI A6 A7 A8 CZEŚĆ ORYGINALNA Nr części 4H0907801G",
                "price" => 99.00,
                "category" => CategoryType::BRAKES,
                "brand" => "Audi",
                "model" => "A6",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "KOMPUTER STER 8V41-12A650-AD 9EBD 5WS40583D-T K1",
                "description" => "WITAM. MAM DO SPRZEDANIA: KOMPUTER STEROWNIK 8V41-12A650-AD 9EBD 5WS40583D-T (16.04.21)",
                "price" => 1100.00,
                "category" => CategoryType::ELECTRICAL,
                "brand" => "Ford",
                "model" => "Kuga",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "Skrzynka bezpieczników Mini S R50 R52 R53 6906614",
                "description" => "Witam. Mam do sprzedania skrzynka bezpieczników do Mini S R50 R52 R53 6906614-04.",
                "price" => 99.00,
                "category" => CategoryType::ELECTRICAL,
                "brand" => "MINI",
                "model" => "Mini Hatch",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "Przekładnia kierownicza pompa wspomagania",
                "description" => "Ogłoszenie dotyczy tylko maglownicy - przekładni kierowniczej. ... Zastosowanie - Opel Vectra C, Signum. ...",
                "price" => 300.00,
                "category" => CategoryType::STEERING,
                "brand" => "Opel",
                "model" => "Vectra",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "Drążki kierownicze Peugeot 5008 II 3008 II",
                "description" => "Drążki kierownicze Peugeot 5008,3008 Stan jak nowe.Podana cena dotyczy kompletu lewej oraz prawej strony.",
                "price" => 100.00,
                "category" => CategoryType::STEERING,
                "brand" => "Peugeot",
                "model" => "5008",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "VW Passat B5 fl TDI kolumna kierownicza z wałkiem komplet",
                "description" => "VW Passat B5 fl TDI/ kompletna kolumna kierownicza z wałkiem komplet ...",
                "price" => 300.00,
                "category" => CategoryType::STEERING,
                "brand" => "Volkswagen",
                "model" => "Passat",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "Mocowanie-podpora maglownicy Ducato,Boxer,Jumper",
                "description" => "Sprzedam mocowanie przekładni kierowniczej Ducato,Boxer,Jumper po 2006r.",
                "price" => 150.00,
                "category" => CategoryType::STEERING,
                "brand" => "Fiat",
                "model" => "Ducato",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "Krzyżak Maglownicy TOYOTA RAV 4 Hybryda",
                "description" => "Krzyżak maglownicy TOYOTA RAV4 2020r.",
                "price" => 130.00,
                "category" => CategoryType::STEERING,
                "brand" => "Toyota",
                "model" => "RAV4",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "Drążki kierownicze BMW F20,F30",
                "description" => "Drążki kierownicze BMW F20,F30 Stan bardzo dobry.Podana cena dotyczy kompletu.",
                "price" => 70.00,
                "category" => CategoryType::STEERING,
                "brand" => "BMW",
                "model" => "1 Series",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "Waz-przewod-rurka Cherokee Wk2",
                "description" => "Przewody wspomagania Cherokee Wk 2 Wersja europa.Podana cena dotyczy kompletu.",
                "price" => 180.00,
                "category" => CategoryType::STEERING,
                "brand" => "Jeep",
                "model" => "Cherokee",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "Mocowanie-podpora maglownicy VW Sharan",
                "description" => "Mocowanie maglownicy VW Sharan,Alhambra,Galaxy",
                "price" => 80.00,
                "category" => CategoryType::STEERING,
                "brand" => "Volkswagen",
                "model" => "Sharan",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "Krzyżak-Sztyca maglownicy Opel Astra H",
                "description" => "Krzyżak maglownicy Opel Astra H",
                "price" => 80.00,
                "category" => CategoryType::STEERING,
                "brand" => "Opel",
                "model" => "Astra",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "Wiązka maglownicy Kia Sportage IV",
                "description" => "Wiązka przekładni kierowniczej Kia Sportage IV",
                "price" => 60.00,
                "category" => CategoryType::STEERING,
                "brand" => "Kia",
                "model" => "Sportage",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "Waz-przewod-rurka wspomagania Ford Focus 2",
                "description" => "Sprzedam przewody wspomagania do Forda Focusa 2 cena podana za komplet.Wersja europejska.",
                "price" => 80.00,
                "category" => CategoryType::STEERING,
                "brand" => "Ford",
                "model" => "Focus",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "Zbiorniczek wspomagania Audi A6 C5 VW Passat B5 Skoda itd.",
                "description" => "Witam!Mam do sprzedania używany sprawny oryginalny 8D0422373C zbiorniczek wspomagania ... Pasuje także ... Audi A4 ... A6 C5, VW Golfa IV ...",
                "price" => 30.00,
                "category" => CategoryType::STEERING,
                "brand" => "Audi",
                "model" => "A6",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "BMW F20 F21 F30 F31 F34 DRĄŻEK KRZYŻAK KOLUMNY KIEROWNICZEJ 6791294",
                "description" => "6791294 BMW F20 F21 F30 F31 F34 DRĄŻEK KRZYŻAK KOLUMNY KIEROWNICZEJ ...",
                "price" => 296.01,
                "category" => CategoryType::STEERING,
                "brand" => "BMW",
                "model" => "1 Series",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "Pompa wspomagania AUDI A6 C6 2.0TFSI 07r. oryginał",
                "description" => "Do sprzedania oryginalna pompa wspomagania z : AUDI A6 C6 avant 2.0TFSI 2007r manual. ...",
                "price" => 150.00,
                "category" => CategoryType::STEERING,
                "brand" => "Audi",
                "model" => "A6",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "Kierownica bmw serii f",
                "description" => "Kierownica bmw serii f .posiadam wiecej czesci do tego modelu.",
                "price" => 199.00,
                "category" => CategoryType::STEERING,
                "brand" => "BMW",
                "model" => "model",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],

            [
                "title" => "Sprężyna Peugeot 807,C 8,Ulysse,Phedra",
                "description" => "Nowa sprężyna przód do Peugeota 807 i pokrewnych. Marka KAYABA nr.RC 2148.",
                "price" => 50.00,
                "category" => CategoryType::SUSPENSION,
                "brand" => "Peugeot",
                "model" => "model",
                "condition" => Condition::FAIR_CONDITION,
                "state" => AuctionState::ACTIVE,
            ],
        ];

        foreach ($auctions as $a) {
            $ownerAlias = $a["owner"] ?? array_rand($users);

            if ($ownerAlias && isset($userByAlias[$ownerAlias])) {
                $owner = $userByAlias[$ownerAlias];
            } else {
                $owner = collect($userByAlias)->random();
            }

            $brand = Brand::query()->firstOrCreate([
                "name" => $a["brand"],
            ]);

            $model = CarModel::query()->firstOrCreate([
                "name" => $a["model"],
                "brand_id" => $brand->id,
            ]);

            $category = Category::query()->firstOrCreate([
                "name" => $a["category"],
            ]);

            $unique = [
                "owner_id" => $owner->id,
                "name" => $a["title"],
                "price" => $a["price"],
            ];

            $payload = [
                "description" => $a["description"] ?? "",
                "city" => $a["city"] ?? $users[$ownerAlias]["city"] ?? "",
                "model_id" => $model->id,
                "category_id" => $category->id,
                "condition" => $a["condition"] ?? Condition::GOOD_CONDITION,
                "auction_state" => $a["state"] ?? AuctionState::ACTIVE,
            ];

            /** @var Auction $auction */
            $auction = Auction::query()->updateOrCreate($unique, $payload);

            if (!empty($a["created_at"])) {
                $dt = Carbon::parse($a["created_at"]);
            } else {
                $dt = Carbon::now()->subDays(rand(0, 365 * 4));
            }

            $auction->created_at = $dt;
            $auction->updated_at = $dt;
            $auction->save();

            $images = $a["images"] ?? [$a["title"] . ".png"];
            $first = $images[0] ?? null;

            if ($first) {
                $sourcePath = $seedImagesDir . DIRECTORY_SEPARATOR . $first;

                if (!is_file($sourcePath)) {
                    throw new RuntimeException("Demo image not found: {$sourcePath}");
                }

                $data = file_get_contents($sourcePath);
                Storage::disk("auctionImage")->put($auction->id . ".png", $data);
            }
        }
    }
}
