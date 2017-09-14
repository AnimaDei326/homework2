<?php
if($this->params['orders']){
    foreach ($this->params['orders'] as $item){
        echo '<div><a href="/order/details?id=' . $item['id'] . '">Заказ № ' . $item['id'] . ' от '.  $item['datetime_created'] . '</a></div><br/>';
    }
}else{
    echo "Нет заказов";
}
