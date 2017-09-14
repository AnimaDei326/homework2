<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="/css/style.css" />
    <link href="http://php.net/favicon.ico" rel="shortcut icon" type="image/x-icon"/>
    <title><?=$this->params['title']?></title>
</head>
<body>
<div class="menu">
    <ul>
        <li><a href="/">Новости</a></li>
        <li><a href="/good">Товары</a></li>
        <li><a href="/basket">Корзина</a></li>
        <li><a href="/admin/ShowUsers">Пользователи</a></li>
        <li><a href="/admin/ShowManagers">Менеджеры</a></li>
        <li><a href="/order/myOrder">Мои заказы</a></li>
        <li><a href="/user">Личный кабинет</a></li>
        <li><a href="/user/logout">Выход</a></li>
    </ul>
</div>
<div class="content"></div>
</body>
</html>