<div id="menu">
    <a href="<?php echo $this->router->generate('home') ?>">Главная</a>
    <a href="<?php echo $this->router->generate('about') ?>">О нас</a>
    <a href="<?php echo $this->router->generate('contacts') ?>">Контакты</a>
    <a href="<?php echo $this->router->generate('user', array('id' => 89)) ?>">Профиль</a>
</div>