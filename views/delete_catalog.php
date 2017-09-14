<h2>Вы уверены, что хотите удалить каталог "<?=$this->params['item'][0]['catalog_name']?>" ?</h2>
<form action="/catalog/deleting" method="POST">
    <input name="id" type="hidden" value="<?=$this->params['item'][0]['id']?>">
    <input name="catalog_name" type="hidden" value="<?=$this->params['item'][0]['catalog_name']?>">
    <button class="myButton" type="submit">Да</button>
</form>