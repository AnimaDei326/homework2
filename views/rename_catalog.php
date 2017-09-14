<form action="/catalog/renaming" method="POST">
    <input name="catalogName" value="<?=$this->params['item'][0]['catalog_name']?>" required>
    <input name="id" type="hidden" value="<?=$this->params['item'][0]['id']?>">
    <button class="myButton" type="submit">Изменить</button>
</form>