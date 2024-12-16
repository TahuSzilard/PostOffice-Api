<?php

namespace App\Repositories;

use App\Database\DB;
//use App\Interfaces\DBInterface;

/**
 * Osztály: BaseRepository
 * 
 * Az adatbázis-repozitórium alapvető CRUD műveletek megvalósítására szolgál.
 * Az osztály a táblanév alapján dinamikusan kezeli az adatokat, támogatva a létrehozás, lekérdezés, frissítés és törlés funkciókat.
 */
class BaseRepository extends DB // implements DBInterface
{
/**
     * Az adatbázis tábla neve, amelyen a műveleteket végezzük.
     * 
     * @var string
     */
 
    protected string $tableName;
    /**
     * Az alapértelmezett oszlopnév, amely alapján az adatokat rendezi.
     * 
     * @var string
     */
    protected string $defaultOrderColumn = 'city';
   /**
     * Az alapértelmezett oszlopnév, amely alapján az adatokat rendezi.
     * 
     * @var string
     */

    /**
     * @param array $data
     * @return void
     */
    public function create(array $data): ?int
    {
           /**
        * Az alapértelmezett oszlopnév, amely alapján az adatokat rendezi.
        * 
        * @var string
        */        
        $fields = '';
        $values = '';
        foreach ($data as $field => $value) {
            if ($fields > '') {
                $fields .= ',' . $field;
            } else
                $fields .= $field;

            if ($values > '') {
                $values .= ',' . "'$value'";
            } else
                $values .= "'$value'";
        }
        $sql = "INSERT INTO `%s` (%s) VALUES (%s)";
        $sql = sprintf($sql, $this->tableName, $fields, $values);
        $this->mysqli->query($sql);

        $lastInserted = $this->mysqli->query("SELECT LAST_INSERT_ID() id;")->fetch_assoc();

        return $lastInserted['id'];
    }

    public function find(int $id): array
    {
         /**
         * Rekord keresése név alapján.
         * 
         * @param string $name A rekord neve.
         * 
         * @return array A megtalált rekord adatai, vagy üres tömb, ha nincs találat.
         */
        $query = $this->select() . "WHERE id = $id";
        /**
        * Az összes rekord lekérdezése az adatbázisból.
        * 
        * @return array Az összes rekord adatai tömbként, vagy üres tömb, ha nincs adat.
        */
        $result = $this->mysqli->query($query)->fetch_assoc();
        if (!$result) {
            $result = [];
        }

        return $result;
    }

    public function getByName(string $name): array
    {
        $query = $this->select() . "WHERE name = '$name'";

        return $this->mysqli->query($query)->fetch_assoc();
    }


    public function getAll(): array
    {
    /**
     * Rekord frissítése egyedi azonosító alapján.
     * 
     * @param int $id A frissítendő rekord egyedi azonosítója.
     * @param array $data A frissített adatok kulcs-érték párok formájában.
     * 
     * @return array A frissített rekord adatai.
     */
        $query = $this->select() . " ORDER BY " . $this->defaultOrderColumn;
    
        return $this->mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
    }
    


    public function update(int $id, array $data)
    {         
        /**
        * Rekord törlése egyedi azonosító alapján.
        * 
        * @param int $id A törlendő rekord egyedi azonosítója.
        * 
        * @return bool Igaz, ha a törlés sikeres volt, egyébként hamis.
        */
        $set = '';
        foreach ($data as $field => $value) {
            if ($set > '') {
                $set .= ", $field = '$value'";
            } else
                $set .= "$field = '$value'";
        }

        $query = "UPDATE `{$this->tableName}` SET %s WHERE id = $id;";
        $query = sprintf($query, $set);
        $this->mysqli->query($query);

        return $this->find($id);
    }

    public function delete(int $id)
    {
    /**
     * Rekordok keresése név alapján (LIKE operátorral).
     * 
     * @param string $needle A keresett név vagy szöveg.
     * 
     * @return array A keresésnek megfelelő rekordok listája.
     */
        $query = "DELETE FROM `{$this->tableName}` WHERE id = $id";

        return $this->mysqli->query($query);
    }

    public function findByName($needle)
    {
    /**
     * Rekordok számának lekérdezése az adatbázis táblájában.
     * 
     * @return int A rekordok száma.
     */
        $query = $this->select() . "WHERE name LIKE '%$needle%' ORDER BY name";

        return $this->mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
    }

//    public function truncate()
//    {
//        $query = "TRUNCATE TABLE makers;";
//
//        return $this->mysqli->query($query);
//    }

    public function getCount()
    {
    /**
     * Alapértelmezett SELECT lekérdezés létrehozása az adott táblára.
     * 
     * @return string A SELECT lekérdezés SQL szintaxisa.
     */
        $query = "SELECT COUNT(1) AS cnt FROM `{$this->tableName}`;";

        $result = $this->mysqli->query($query)->fetch_assoc();

        return $result['cnt'];
    }

    public function select()
    {
        return "SELECT * FROM `{$this->tableName}` ";
    }
}