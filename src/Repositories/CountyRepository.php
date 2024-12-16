<?php
namespace App\Repositories;

/**
 * Osztály: CountyRepository
 * 
 * Ez az osztály a `counties` adatbázis tábla kezelésére szolgál. Az alapvető CRUD műveleteket 
 * az `BaseRepository` osztályból örökli, és a megyékkel kapcsolatos specifikus műveleteket valósítja meg.
 */
class CountyRepository extends BaseRepository
{
    /**
     * Az alapértelmezett oszlop, amely alapján a rekordok rendezésre kerülnek.
     * 
     * @var string
     */
    protected string $defaultOrderColumn = 'name'; 

    /**
     * Konstruktor
     * 
     * Inicializálja a `CountyRepository` példányt, és beállítja a `counties` tábla nevét.
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
        $this->tableName = 'counties';
    }
}
