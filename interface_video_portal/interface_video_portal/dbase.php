<?php


class dbase
  {
    private static $site_db = null;
    
    const HOST = 'localhost';
    const USER = 'root';
    const PASS = '';
    const DB   = 'sport_portal';
    
    const FILMS='films';
    const CAREER='career';
    const STAFF='staff';
    const STAFF_CAREER='staff_career';
    const STAFF_FILM='staff_film';
    const GENR='genre';
    const FILM_GENRE='film_genre';
    const STAFF_GANRE='staff_ganre';
    const HONORS='honors';
    const STAFF_HONORS='staff_honors';
    const FILM_HONORS='film_honors';
    const PHOTO='photo';
    const PHOTO_FILM='photo_film';
    const COUNTRY='country';
    const STAFF_PHOTO='staff_photo';
    const COUNTRY_FILM='country_film';




    static function activate()
    {
        self::$site_db = new mysqli(self::HOST,self::USER,self::PASS,self::DB);

        if(self::$site_db->connect_errno)
            echo 'Не удалось подключится к бд:'.self::$site_db->connect_error;

        self::$site_db->query('SET NAMES \'utf8\'');
        /*self::$site_db->client_encoding = 'UTF-8';
        self::$site_db->character_set_name = 'utf8_general_ci';*/

    }

    /**
     * @return mysqli
     */
    static function db()
    {
        if(!self::$site_db)
            self::activate();
        return self::$site_db;
    }


  }