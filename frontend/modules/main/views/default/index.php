<?php

use common\widgets\CategoriesWidget;

$this->title = 'Microwave Electronics Warehouse';

?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Warehouse!</h1>

        <p class="lead">Projects, Units, Boards, Orders, Elements, Matherials and others.</p>

        <input class="btn-lg" placeholder="Not work yet"> <a class="btn btn-lg btn-success" href="">Search</a></input>
        
       <?php // <p><a class="btn btn-lg btn-success" href="">Search</a></p>?>
        
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Orders by Projects</h2>

                <ul>
                    <li><a href="requests/index" title="Текущие заявки">Current Requests</a></li>
                    <li><a href="orders/index" title="Обработанные заказы">Orders in work</a></li>
                    <li><a href="receipt/index" title="Последние поступления">Recent Onstock</a></li>
                    <li><a href="orders/index" title="Заказы по поставщикам">Orders by Suppliers</a></li>
                    <li><a href="invoices/index" title="Все счета">All Invoices</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h2>Projects</h2>
                
               <ul><?php 
                    foreach (\common\models\Themes::find()->where(['status'=> 1])->all() as $theme): ?>
                     <li><a href="themes/units/<?php echo $theme->idtheme;?>"><?php echo $theme->name ?></a></li>
                    <?php endforeach;?>
                </ul>
               

            </div>
           
        </div>
        <hr/>
        <div class="row">
            <h2>Catalogs</h2>
            <div class="col-lg-4">
               <h4>Products</h4>
                <ul>
                <li><a href="elements/index" title="Cписок электронных компонентов">Electronics components</a></li>
                <li><a href="elements/index" title="Список материалов">Matherials</a></li>
                <li><a href="elements/index" title="Список компьютеров">Computers</a></li>
                <li><a href="elements/index" title="Список оборудования">Equipments</a></li>
                </ul>
                <p><a class="btn btn-default" href="elements/index">All products</a></p>
            </div>
            
             <div class="col-lg-4">
             <h4>Categories of electronic components</h4>
               <?php 
                     CategoriesWidget::begin();?>
               <?php CategoriesWidget::end(); ?>
             </div>
        </div>
    </div>
</div>
