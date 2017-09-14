<?php
if($this->params['orders']){
    foreach ($this->params['orders'] as $item){
        echo '<div><a class="detail" href="/order/detail?id=' . $item['id'] . '">Заказ № ' . $item['id'] . ' от '.  $item['datetime_created'] . '</a></div><br/>';
    }
}else{
    echo "Нет заказов";
}
