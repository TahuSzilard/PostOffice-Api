<?php
namespace App\Repositories;

/**
 * Osztály: CityRepository
 * 
 * Ez az osztály a `cities` adatbázis tábla kezelésére szolgál. Az alapvető CRUD műveleteket 
 * az `BaseRepository` osztályból örökli, és a városokkal kapcsolatos specifikus műveleteket valósítja meg.
 */
class CityRepository extends BaseRepository
{
    /**
     * Az alapértelmezett oszlop, amely alapján a rekordok rendezésre kerülnek.
     * 
     * @var string
     */
    protected string $defaultOrderColumn = 'zip_code'; 

    /**
     * Konstruktor
     * 
     * Inicializálja a `CityRepository` példányt, és beállítja a `cities` tábla nevét.
     * 
     * @param string $host Az adatbázis hosztja (alapértelmezett: `localhost`).
     * @param string $user Az adatbázis felhasználóneve (alapértelmezett: `root`).
     * @param string|null $password Az adatbázis jelszava (alapértelmezett: `null`).
     * @param string $database Az adatbázis neve (alapértelmezett: `postoffice`).
     */
    function __construct(
        $host = self::HOST, 
        $user = self::USER,
        $password = self::PASSWORD,
        $database = self::DATABASE
    ) {
        parent::__construct($host, $user, $password, $database);
        $this->tableName = 'cities';
    }
}
