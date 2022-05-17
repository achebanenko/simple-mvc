<h1>Index page</h1>

<?php foreach ($news as $item) :?>
<h3>
    <?= $item['title'];?>
</h3>
<p>
    <?= $item['description'];?>
</p>
<hr />
<?php endforeach;
