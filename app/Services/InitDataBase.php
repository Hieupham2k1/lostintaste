<?php
namespace App\Services;

class InitDataBase
{
    public function __construct()
    {
        if(!env("DB_HOST")){
            putenv ("DB_CONNECTION=mysql");
            putenv ("DB_HOST=localhost");
            putenv ("DB_PORT=3306");
            putenv ("DB_DATABASE=hieuptth_db");
            putenv ("DB_USERNAME=hieuptth_hieupt");
            putenv ("DB_PASSWORD=hieuptth_hieupt");
        }
    }
}