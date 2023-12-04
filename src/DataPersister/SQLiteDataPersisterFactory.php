<?php

namespace Mihailvd\PrimeMultiplicationTable\DataPersister;

use PDO;

final class SQLiteDataPersisterFactory
{
    public static function create(string $sqliteFile): DataPersisterInterface
    {
        $pdo = new PDO('sqlite:' . $sqliteFile, '', '', [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

        return new SQLiteDataPersister($pdo);
    }
}
