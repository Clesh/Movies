<?php
include_once 'main_dao.php';
include_once 'main_to.php';
 
class main {
 
    public $id_film;
    
    function __construct() 
    {
      /* $id_film=main_dao::set_film($arr_film);
       
       $this->id_fil=$id_film;*/
    }
    public function set_film($arr_film, $arr_staff, $arr_ganre, $arr_honors_film, $arr_photo, $arr_country)
    {
        return main_dao::set_film($arr_film, $arr_staff, $arr_ganre, $arr_honors_film, $arr_photo, $arr_country);
    }

    public function set_staff($arr_staff, $type)
    {
        $id_film=$this->id_film;
        return main_dao::set_staff($id_film, $arr_staff, $type);
    }
     public function set_genre($arr_genre)
    {
        $id_film=$this->id_film;
        return main_dao::set_genre($id_film, $arr_genre);
    }
    
    public function set_photo($arr_photo, $type)
    {
        $id_film=$this->id_film;
        return main_dao::set_photo($id_film, $arr_photo, $type);
    }
    
    public function set_video($arr_video, $type)
    {
         $id_film=$this->id_film;
         return main_dao::set_video($id_film, $arr_video, $type);
    }
    public function set_country($name)
    {
        
        return main_dao::set_country($name);
    }
    
    public function set_honors($arr_honors)
    {
        //$id_film=$this->id_film;
        return main_dao::set_honors($arr_honors);
    }


    /*   public function set_scenario($arr_scenario)
    {
        
    }
    public function set_producer($arr_producer)
    {
        
    }
    public function set_operator($arr_operator)
    {
        
    }
    public function set_composer($arr_composer) //композитор
    {
        
    }
    public function set_painter($arr_painter)
    {
        
    }
    public function set_mounting($arr_mounting)
    {
        
    }
    public function set_actors($arr_actors)
    {
        
    }
    public function set_genre($arr_genre)
    {
        
    }*/
}
