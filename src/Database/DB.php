<?php
namespace App\Database;

/**
 * Osztály: DB
 * 
 * Ez az osztály egy egyszerű interfészt biztosít az adatbázis-kapcsolatok kezelésére MySQLi használatával.
 * A kapcsolat inicializálása, a karakterkészlet beállítása és az automatikus lezárás is támogatott.
 */
class DB
{
    /**
     * Az adatbázis hosztja
     * @var string
     */
    const HOST = 'localhost';

    /**
     * Az adatbázis felhasználóneve
     * @var string
     */
    const USER = 'root';

    /**
     * Az adatbázis jelszava
     * @var string|null
     */
    const PASSWORD = null;

    /**
     * Az adatbázis neve
     * @var string
     */
    const DATABASE = 'postoffice';

    /**
     * MySQLi kapcsolat példánya
     * @var \mysqli
     */
    protected $mysqli;

    /**
     * Konstruktor
     * 
     * Inicializálja az adatbázis kapcsolatot a megadott paraméterekkel.
     * 
     * @param string $host Az adatbázis hosztja (alapértelmezett: 'localhost')
     * @param string $user Az adatbázis felhasználóneve (alapértelmezett: 'root')
     * @param string|null $password Az adatbázis jelszava (alapértelmezett: null)
     * @param string $database Az adatbázis neve (alapértelmezett: 'postoffice')
     * 
     * @throws \Exception Ha a kapcsolat nem jön létre.
     */
    function __construct(
        $host = self::HOST, 
        $user = self::USER, 
        $password = self::PASSWORD, 
        $database = self::DATABASE
    ) {
        $this->mysqli = mysqli_connect(
            $host, 
            $user, 
            $password, 
            $database
        );

        if (!$this->mysqli) {
            die("Kapcsolódási hiba: " . mysqli_connect_error());
        }
        $this->mysqli->set_charset("utf8mb4");
    }

    /**
     * Destruktor
     * 
     * Lezárja az adatbázis kapcsolatot.
     */
    function __destruct()
    {
        $this->mysqli->close();
    }
}
