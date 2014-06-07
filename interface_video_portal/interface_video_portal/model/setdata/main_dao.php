<?php


class main_dao 
{
    static function set_film($arr_film, $arr_staff, $arr_genre, $arr_honors_film, $arr_photo, $arr_country)
    {
        $q="INSERT INTO ".dbase::FILMS." (`id`, `name`, `slogan`, `year`, `budget`, 
        `fees_world`, `fees_usa`, `fees_rus`, `date_premiere_world`, 
        `date_premiere_rus`, `date_release_rus`, `date_release_blu-ray`, 
        `rest_age`, `duration`, `rated`, `description`) 
        VALUES (NULL, '".$arr_film['name']."', '".$arr_film['slogan']."', '".$arr_film['year']."', '".$arr_film['budget']."', '".$arr_film['fees_world']."', '".$arr_film['fees_usa']."', '".$arr_film['fees_rus']."', 
        '".$arr_film['date_premiere_world']."', '".$arr_film['date_premiere_rus']."', '".$arr_film['date_release_rus']."', '".$arr_film['date_release_blu-ray']."', 
        '".$arr_film['rest_age']."', '".$arr_film['duration']."', '".$arr_film['rated']."', '".$arr_film['description']."')";
        $result=dbase::db()->query($q);
        $id_film=dbase::db()->insert_id;
             if (!$result)
            return false;
             echo 1;
             echo '<br>';
        var_dump($arr_staff);
        //ПРОБЛЕМА
        $data=main_dao::set_staff($arr_staff);
        $arr_id_staff=$data['arr_id_staff'];
        $arr_id_career=$data['arr_id_career'];
        
        var_dump($arr_id_staff);
        for($i=0; $i<count($arr_id_staff); $i++)
        {
            $id_staff=$arr_id_staff[$i];
            $id_career=$arr_id_career[$i];
            $q2="INSERT INTO ".dbase::STAFF_FILM." (`id_film`, `id_staff`, `id_career`) VALUES ('".$id_film."', '".$id_staff."', '".$id_career."');";
            $result2=dbase::db()->query($q2);
             if (!$result2)
            return false;
             
             echo 2;echo '<br>';
        }
       
        for($z=0; $z<count($arr_genre); $z++)
        {   $ganre=$arr_genre[$z];
           
            $id_genre=main_dao::set_genre($ganre);
            $q3="INSERT INTO ".dbase::FILM_GENRE." (`id_film`, `id_genre`) VALUES ('".$id_film."', '".$id_genre."');";
            $result3=dbase::db()->query($q3);
             if(!$result3)
            return false;
             echo 3;echo '<br>';
             //http://www.native-english.ru/articles/words
        }
        if($arr_honors_film!='null')
        {
            for($l=0; $l<count($arr_honors_film); $l++)
            {
                $arr_honors=$arr_honors_film[$l];
                $id_honors= main_dao::set_honnors($arr_honors);
                $q4="INSERT INTO ".dbase::FILM_HONORS." (`id_films`, `id_honors`) VALUES ('".$id_film."', '".$id_honors."');";
                $result4=dbase::db()->query($q4);
                if(!$result4)
                return false;
            
            }
        }
        if($arr_photo!='null')
        {
            for($p=0; $p<count($arr_photo); $p++)
            {
                $id_photo=main_dao::set_photo($arr_photo[$p]);
                $q5="INSERT INTO '.dbase::PHOTO_FILM.' (`id_film`, `id_photo`, `type`) VALUES ('".$id_film."', '".$id_photo."', '".$arr_photo[$p]['type']."');";
                      $result5=dbase::db()->query($q5);
                if(!$result5)
                return false;
            }
        }
        for($f=0; $f<count($arr_country); $f++)
        {
            $id_country=main_dao::set_country($arr_country[$f]);
            $q6="INSERT INTO ".dbase::COUNTRY_FILM." (`id_film`, `id_country`) VALUES ('".$id_film."', '".$id_country."');";
              $result6=dbase::db()->query($q6);
                if(!$result6)
                return false;
            
        }
        
  
      //  return dbase::db()->insert_id;
    }
    static function set_staff($arr_staff)
    {
        for($i=0; $i<count($arr_staff); $i++)
        {
            $id_career=$arr_staff[$i]['id_career'];
            $q="SELECT * FROM  ".dbase::STAFF." WHERE first_name =  '".$arr_staff[$i]['first_name']."' AND last_name =  '".$arr_staff[$i]['last_name']."'";
            $result=dbase::db()->query($q);
              if (!$result)
                return false;
              echo 4;echo '<br>';
            if($result->num_rows==0)
            {
                $q1="INSERT INTO ".dbase::STAFF." (`id`, `first_name`, `last_name`, `date_birth`, `place_birth`)"
                    . " VALUES (NULL, '".$arr_staff[$i]['first_name']."', '".$arr_staff[$i]['last_name']."', '".$arr_staff[$i]['date_birth']."', '".$arr_staff[$i]['place_birth']."');";
                $result1=dbase::db()->query($q1);
                if (!$result1)
                return false;
                echo 5;echo '<br>';
                $id_staff=dbase::db()->insert_id;
         
            }  else {
             
                $data = $result->fetch_assoc();
                $id_staff=$data['id'];
            }
            $q2="SELECT * FROM  ".dbase::STAFF_CAREER." WHERE id_staff =  '".$id_staff."' AND id_career =  '".$id_career."'";
            $result2=dbase::db()->query($q2);
            if (!$result2)
            return false;
            echo 6;echo '<br>';
            if($result2->num_rows==0)
            {
                $q3="INSERT INTO ".dbase::STAFF_CAREER." (`id_staff`, `id_career`) VALUES ('".$id_staff."', '".$id_career."')";
                $result3=dbase::db()->query($q3);
                if (!$result3)
                return false;  
                echo 7;echo '<br>';
            }
            $arr_id_staff[]=$id_staff;
            $arr_id_career[]=$id_career;
            for($k=0; $k<count($arr_staff[$i]['genre']);$k++)
            {
                $genre=$arr_staff[$i]['genre'][$k];
                $arr_genre['genre']=$genre;
                $id_genre=main_dao::set_genre($genre);
                $q4="INSERT INTO ".dbase::STAFF_GANRE." (`id_staff`, `id_ganre`) VALUES ('".$id_staff."', '".$id_genre."');";
                $result4=dbase::db()->query($q4);
                if (!$result4)
                return false;  
                echo 8;echo '<br>';
            }
            //еще жанр забыл 
            //Нужно запихать id карьеры человека в общий массив.
            for($q=0; $q<count($arr_staff[$i]['honors']); $q++)
            {
                if($arr_staff[$i]['honors']=='null')
                {
                    break;
                }
                $arr_honors=$arr_staff[$i]['honors'][$q];
                $id_honors=  main_dao::set_honnors($arr_honors);
                $q7="INSERT INTO ".dbase::STAFF_HONORS." (`id_staff`, `id_honors`) VALUES ('".$id_staff."', '".$id_honors."');";
                $result7=dbase::db()->query($q7);
                 if (!$result7)
                    return false;
            }
            for($m=0; $m<count($arr_staff[$i]['photo']); $m++)
            {
                  if($arr_staff[$i]['photo']=='null')
                {
                    break;
                }
                $arr_photo=$arr_staff[$i]['photo'][$m];
                $id_photo= main_dao::set_photo($arr_photo);
                $q8="INSERT INTO ".dbase::STAFF_PHOTO." (`id_staff`, `id_photo`) VALUES ('".$id_staff."', '".$id_photo."');";
                $result8=dbase::db()->query($q8);
                 if (!$result8)
                    return false;
            }
            
            
        }
        $data['arr_id_staff']=$arr_id_staff;
        $data['arr_id_career']=$arr_id_career;
        return $data;
       
    }
    static function set_genre ($genre)
    {
        //for($i=0; $i<=count($arr_genre); $i++)
        //{
        
            $q="SELECT * FROM  ".dbase::GENR." WHERE genre = '".$genre."'";
            $result=dbase::db()->query($q);
              if (!$result)
                return false;
              echo 9;echo '<br>';
            if($result->num_rows==0)
            {
                $q1="INSERT INTO ".dbase::GENR." (`id`, `genre`) VALUES (NULL, '".$genre."');";
                $result1=dbase::db()->query($q1);
                if (!$result1)
                return false;
                echo 10;echo '<br>';
                $id_genr=dbase::db()->insert_id;
                
            }else {
                
                $data = $result->fetch_assoc();
                $id_genr=$data['id'];
            }
            
            //$q2="INSERT INTO ".dbase::FILM_GENRE." (`id_film`, `id_genre`) VALUES ('".$id_film."', '".$id_genr."');";
           //$arr_id_genr[]=$id_genr;
            
       // }
        return $id_genr;
    }
    static function set_honnors($arr_honors)
    {
        $q="SELECT * FROM  ".dbase::HONORS." WHERE honors_name =  '".$arr_honors['name']."'";
        $result=dbase::db()->query($q);
        if (!$result)
        return false;
        $data = $result->fetch_assoc();
        $id_honors=$data['id'];
        if($result->num_rows==0)
        {
            $q1="INSERT INTO ".dbase::HONORS." (`id`, `honors_name`, `description`, `year`) VALUES (NULL, '".$arr_honors['name']."', '".$arr_honors['description']."', '".$arr_honors['year']."');";
            $result1=dbase::db()->query($q1);
            $id_honors=dbase::db()->insert_id;
            if (!$result1)
            return false;
                
        }
        return $id_honors;
    }
    static function set_photo($arr_photo)
    {
            $q="INSERT INTO ".dbase::PHOTO." (`id`, `photo_min`, `photo_main`, `photo_max`) VALUES (NULL, '".$arr_photo['min']."', '".$arr_photo['main']."', '".$arr_photo['max']."');";
            $result=dbase::db()->query($q);
            $id_photo=dbase::db()->insert_id;
            if (!$result)
            return false;
            return $id_photo;
                
    }
    static function set_video($id_film, $arr_video, $type)
    {
        
    }
    static function set_country($name)
    {
        //INSERT INTO `sport_portal`.`country` (`id`, `country`) VALUES (NULL, 'Авган');
        $q="SELECT * FROM  ".dbase::COUNTRY." WHERE country =  '".$name."'";
        $result=dbase::db()->query($q);
          if (!$result)
            return false;
         $data = $result->fetch_assoc();
        $id_photo=$data['id'];
        if($result->num_rows==0)
        {
            $q2="INSERT INTO ".dbase::COUNTRY." (`id`, `country`) VALUES (NULL, '".$name."');";
            $result2=dbase::db()->query($q2);
            $id_photo=dbase::db()->insert_id;
            if (!$result2)
            return false;
                
        }
        
    }
    
    
    static function set_staff_existing($id_film, $arr_staff, $type)
    {
        $q3="INSERT INTO ".dbase::STAFF." (`id`, `first_name`, `last_name`, `date_birth`, `place_birth`)VALUES (NULL, '".$first_name[$fnr]."', '".$last_name[$fln]."', '2014-05-21', 'Санкт-Петербург');";
        $result=dbase::db()->query($q3);
    }
}
