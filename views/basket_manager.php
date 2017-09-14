<?php

if($this->params['basket']){
    echo "<h4>Адрес доставки: {$this->params['order'][0]['address']} </h4>";
    echo "<h4>Комментарий к заказу: {$this->params['order'][0]['comment']} </h4>";
    echo "<h4>Стоимость: $ {$this->params['order'][0]['price']} </h4>";
    echo "<h4>Дата создания: {$this->params['order'][0]['datetime_created']} </h4>";
    echo $this->params['order'][0]['id_status'] == 3 ?
        "<a class='myButton' href='\order\openAgain?id={$this->params['order'][0]['id']}' >Открыть заказ снова</a>" :
        "<a class='myButton' href='\order\close?id={$this->params['order'][0]['id']}' >Закрыть заказ</a>" ;
    foreach ($this->params['basket'] as $items) {
        foreach ($items as $item){
            echo '<div class="good"><h2><a class="detail" href="\good\detail?id='.$item['id'] .'">' . $item['good_name'] . '</a></h2><h3 class="price">US $ ' . $item['price'] . ' / шт.</h3><img src="/images/' . $item['path'] . '" /></div><br/>';
        }
    }
}else{
    echo 'Товаров у заказа нет, возможно, товары были удалены.';
}