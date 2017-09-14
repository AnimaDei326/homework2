<?php
$price = '';

if($this->params['basket']){
    echo '<a class="myButton" href="\order">Оформить заказ</a>';
    foreach ($this->params['basket'] as $items) {
        foreach ($items as $item){
            echo '<div class="good"><h2><a class="detail" href="\good\detail?id='.$item['id'] .'">' . $item['good_name'] . '</a></h2><h3 class="price">US $ ' . $item['price'] . ' / шт.</h3><img src="/images/' . $item['path'] . '" /><br/><a class="myButton" href="\basket\delete?id='.$item['id'] .'">убрать из корзины</a></div>';
            $price+=$item['price'];
        }
    }
    echo '<h2>Стоимость заказа: $ ' . $price .'</h2>';
}else{
    echo 'В Вашей корзине нет товаров';
}