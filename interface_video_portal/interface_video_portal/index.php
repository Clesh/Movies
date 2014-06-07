<?php
include_once 'dbase.php';
include_once 'model/setdata/main.php';
include_once 'img_editor.php';
echo phpversion() ;
echo $_GET['customUrl'];

/*$arr_film=array('Аватар','Странные Дни', 'Правдивая лож', 'Титаник',
    'Бездна','Чужие','Рембо','Познер','Шоу атакует','Чужие из бездны',
    'Чужие из бездны','Час','Демократия Сейчас');
$description=array('Джейк Салли — бывший морской пехотинец, прикованный к инвалидному креслу. Несмотря на немощное тело, Джейк в душе по-прежнему остается воином. Он получает задание совершить путешествие в несколько световых лет к базе землян на планете Пандора, где корпорации добывают редкий минерал, имеющий огромное значение для выхода Земли из энергетического кризиса.',
        'История противостояния солдата Кайла Риза и киборга-терминатора, прибывших в 1984-й год из пост-апокалиптического будущего, где миром правят машины-убийцы, а человечество находится на грани вымирания. Цель киборга: убить девушку по имени Сара Коннор, чей ещё нерождённый сын к 2029 году выиграет войну человечества с машинами. Цель Риза: спасти Сару и остановить Терминатора любой ценой.',
    'Подросток Марти с помощью машины времени, сооруженной его другом профессором доком Брауном, попадает из 80-х в далекие 50-е. Там он встречается со своими будущими родителями, еще подростками, и другом-профессором, совсем молодым.',
    '1999 год. Огромной популярностью пользуется новое изобретение, разработанное ФБР в целях слежки и попавшее на «черный» рынок. Надев на голову небольшое приспособление с датчиками, можно записать ощущения и «пережить» их через проигрыватель, причем с абсолютной достоверностью.');
$slogan=array ('Мы измеряем сотые доли секунды, которые отделяют победителя от участника.','Лишние бумаги – вне игры.','Остальным придётся догонять','Разрушь то, что разрушает тебя.'); //5
$genr=array('анимация','боевик','вестерн','истерн','криминал','детектив','триллер');
$year=array('1941','1945','1991','2014','2016');
$budget=1000000;
$fees_world=100000;
$fees_usa=990000;
$fees_rus=777777;
$date_premiere_world=date('Y-m-d');
$date_premiere_rus=date('Y-m-d');
$date_release_rus=date('Y-m-d');
$date_release_blu_ray=date('Y-m-d');
$rest_age=18;
$duration=196;
$rated=78;*/
$arr_film=array
(
    'name'=>'Аватар',
    'slogan'=>'Мы измеряем сотые доли секунды, которые отделяют победителя от участника.', 
    'year'=>'1991', 
    'budget'=>'3000000', 
    'fees_world'=>'1000000',
    'fees_usa'=>'2000000', 
    'fees_rus'=>'3000000',
    'date_premiere_world'=>'2014-05-04', 
    'date_premiere_rus'=>'2014-06-08', 
    'date_release_rus'=>'2014-06-07',
    'date_release_blu-ray'=>'2013-07-21', 
    'rest_age'=>'12',
    'duration'=>'120',
    'rated'=>'95',
    'description'=>'жейк Салли — бывший морской пехотинец, прикованный к инвалидному креслу. Несмотря на немощное тело, Джейк в душе по-прежнему остается воином. Он получает задание совершить путешествие в несколько световых лет к базе землян на планете Пандора, где корпорации добывают редкий минерал, имеющий огромное значение для выхода Земли из энергетического кризиса'
   
);
$arr_genre=array('анимация','боевик','вестерн','истерн','юмор');
$arr_staff[]=array(
    'id_career'=>'37',
    'first_name'=>'Том',
    'last_name'=>'Круз', 
    'date_birth'=>'1991-06-13', 
    'place_birth'=>'Санкт-Петербург',
    'genre'=>array('боевик','вестерн','истерн'),
    'honors'=>'null',
    'photo'=>'null'
    
);
$arr_honors_staff[]=array
(
    'name'=>'оскар',
    'description'=>'оскар-это такая золотая вещица, типа человека',
    'year'=>'1980'
);
$arr_honors_film[]=array
(
    'name'=>'золотой орел',
    'description'=>'оскар-это такая золотая вещица, типа человека',
    'year'=>'1980'
);
$arr_photo[]= array(
    'min'=>'photo_min',
    'main'=>'photo_main',
    'max'=>'photo_max',
    'type'=>'1'
);
$arr_staff[]=array(
    
    'id_career'=>'37',
    'first_name'=>'Джимм',
    'last_name'=>'Керре', 
    'date_birth'=>'1991-06-13', 
    'place_birth'=>'Канада, Торонто',
    'genre'=>array('боевик','вестерн','истерн'),
    'honors'=>$arr_honors_staff,
    'photo'=>$arr_photo
        
);
$arr_country=array ('Россия','Белоруссия', 'Новороссия');

/*$main=new main();
$main->set_film($arr_film, $arr_staff, $arr_genre,$arr_honors_film, $arr_photo, $arr_country);
      */ 
//$name="4f.jpg";

//imgEgitor($name);
/*
for($i=0;$i<=100; $i++)
{
$rf=rand(0, 11);
$rd=rand(0, 3);
$sr=rand(0,3);
$gr=rand(0,6);
$yr=rand(0,4);
$q="INSERT INTO ".dbase::FILMS." (`id`, `name`, `slogan`, `year`, `budget`, 
 `fees_world`, `fees_usa`, `fees_rus`, `date_premiere_world`, 
 `date_premiere_rus`, `date_release_rus`, `date_release_blu-ray`, 
 `rest_age`, `duration`, `rated`, `description`) 
 VALUES (NULL, '".$arr_film[$rf]."', '".$slogan[$sr]."', '".$year[$yr]."', '".$budget."', '".$fees_world."', '".$fees_usa."', '".$fees_rus."', 
 '".$date_premiere_world."', '".$date_premiere_rus."', '".$date_release_rus."', '".$date_release_blu_ray."', 
 '".$rest_age."', '".$duration."', '".$rated."', '".$description[$rd]."')";
$result=dbase::db()->query($q);
}*/
/*
$career=array('Актёр','Бутафор','Гримёр','Звукорежиссёр','Режиссёр-постановщик',
    'Костюмер');
for($z=0; $z<count($career); $z++)
{
    $q2="INSERT INTO ".dbase::CAREER." (`id` ,`carrer`)VALUES (NULL ,'".$career[$z]."');";
    $result=dbase::db()->query($q2);
}*/
/*
$first_name=array('Том','Джим','Николас','Эдди','Мел');
$last_name=array('Круз', 'Керри','Кейдж','Киано','Мёрфи' );
for($f=0; $f<=11; $f++)
{
    $fnr=  rand(0, 4);
    $fln=  rand(0, 4);
    $q3="INSERT INTO ".dbase::STAFF." (`id`, `first_name`, `last_name`, `date_birth`, `place_birth`)VALUES (NULL, '".$first_name[$fnr]."', '".$last_name[$fln]."', '2014-05-21', 'Санкт-Петербург');";
    $result=dbase::db()->query($q3);
}
*/