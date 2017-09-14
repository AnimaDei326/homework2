<a href="/good" class="detail">вернуться</a><div class="detail_good"><h2><?=$this->params['item'][0]['good_name']?></h2><h3 class="price">US $ <?=$this->params['item'][0]['price']?> / шт.</h3><img src="/images/<?=$this->params['item'][0]['path']?>" />
    <p><?=$this->params['item'][0]['description']?></p></div>

<a class="myButton" href="/basket/add?id=<?=$this->params['item'][0]['id']?>">Добавить в корзину</a>