<?php
if($this->params['users']){
    foreach ($this->params['users'] as $item){
        echo '<div><h2>ID: ' . $item['id'] . '</h2>';
        echo '<h2>Имя: ' . $item['username'] . '</h2>';
        echo '<a class="myButton" href="/admin/newUser?id=' . $item['id'] . '">назначить обычным пользователем</a><br/>';
        echo '<a class="myButton" href="/admin/newAdmin?id=' . $item['id'] . '">назначить администратором</a></div><br/>';
    }
}else{
    echo "Нет ни одного менеджера";
}
