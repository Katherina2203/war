<ul><?php 
foreach ($models as $category): ?>
    <li><a href="category/items?id=<?php echo $category->idcategory; ?>"><?php echo $category->name_ru ?></a></li>
<?php endforeach;?>
</ul>