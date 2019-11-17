<?php

/* @var $this yii\web\View */

$this->title = 'Homeocare';
?>
<!--
<section class="content-header">
    <h1 style="padding-top: 10px;
    padding-bottom: 10px;">
        Homeocare           </h1>

</section>-->
<div class="row">
    <a style=" color:white" href="category">
        <div class="info-box bg-green" style="width: 20%;float: left;margin: 0 5px 50px 70px;">
            <span class="info-box-icon"><i class="fa fa-asterisk"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Category</span>
                <h3><?= \common\models\Category::find()->where(['pid' => NULL])->count() ?></h3>
            </div>
            <!-- /.info-box-content -->
        </div>
    </a>

    <a style=" color:white" href="category">
        <div class="info-box bg-red" style="width: 20%;float: left;margin: 0 5px 50px 70px;">
            <span class="info-box-icon"><i class="fa fa-asterisk"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Sub Category</span>
                <h3><?= \common\models\Category::find()->where(['not', ['pid' => NULL]])->count() ?></h3>
            </div>
            <!-- /.info-box-content -->
        </div>
    </a>

    <a style=" color:white" href="medicines">
        <div class="info-box bg-yellow" style="width: 20%;float: left;margin: 0 5px 50px 70px;">
            <span class="info-box-icon"><i class="fa fa-briefcase"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Medicines</span>
                <h3><?= \common\models\Medicines::find()->count() ?></h3>
            </div>
            <!-- /.info-box-content -->
        </div>
    </a>

    <a style=" color:white" href="user">
        <div class="info-box bg-pink" style="width: 20%;float: left;margin: 0 5px 50px 70px;">
            <span class="info-box-icon"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">All Users</span>
                <h3><?= \common\models\User::find()->count() ?></h3>
            </div>
            <!-- /.info-box-content -->
        </div>
    </a>
    <a style=" color:white" href="cart">
        <div class="info-box bg-teal" style="width: 20%;float: left;margin: 0 5px 50px 70px;">
            <span class="info-box-icon"><i class="fa fa-shopping-cart"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Cart</span>
                <h3><?= \common\models\Cart::find()->count() ?></h3>
            </div>
            <!-- /.info-box-content -->
        </div>
    </a>
    <a style=" color:white" href="orders">
        <div class="info-box bg-light-blue" style="width: 20%;float: left;margin: 0 5px 50px 70px;">
            <span class="info-box-icon"><i class="fa fa-first-order"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Order</span>
                <h3><?= \common\models\Orders::find()->count() ?></h3>
            </div>
            <!-- /.info-box-content -->
        </div>
    </a>
    <a style=" color:white" href="appoinment-booking">
        <div class="info-box"
             style="background-color: #6330b5;width: 20%;float: left;margin: 0 5px 50px 70px;">
            <span class="info-box-icon"><i class="fa fa-ticket"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Booking</span>
                <h3><?= \common\models\Orders::find()->count() ?></h3>
            </div>
            <!-- /.info-box-content -->
        </div>
    </a>
    <a style=" color:white" href="blogs">
        <div class="info-box"
             style="background-color: #b5ab30;width: 20%;float: left;margin: 0 5px 50px 70px;">
            <span class="info-box-icon"><i class="fa fa-dot-circle-o"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Blogs</span>
                <h3><?= \common\models\Blogs::find()->count() ?></h3>
            </div>
            <!-- /.info-box-content -->
        </div>
    </a>
    <a style=" color:white" href="countries">
        <div class="info-box"
             style="background-color: #b53092;width: 20%;float: left;margin: 0 5px 50px 70px;">
            <span class="info-box-icon"><i class="fa fa-dot-circle-o"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Countries</span>
                <h3><?= \common\models\Countries::find()->count() ?></h3>
            </div>
            <!-- /.info-box-content -->
        </div>
    </a>
    <a style=" color:white" href="cities">
        <div class="info-box"
             style="background-color: #cfe233;width: 20%;float: left;margin: 0 5px 50px 70px;">
            <span class="info-box-icon"><i class="fa fa-dot-circle-o"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Cities</span>
                <h3><?= \common\models\Cities::find()->count() ?></h3>
            </div>
            <!-- /.info-box-content -->
        </div>
    </a>
    <a style=" color:white" href="states">
        <div class="info-box"
             style="background-color: #008080;width: 20%;float: left;margin: 0 5px 50px 70px;">
            <span class="info-box-icon"><i class="fa fa-dot-circle-o"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">States</span>
                <h3><?= \common\models\States::find()->count() ?></h3>
            </div>
            <!-- /.info-box-content -->
        </div>
    </a>
    <a style=" color:white" href="payment-methods">
        <div class="info-box"
             style="background-color:#E6B0AA;width: 20%;float: left;margin: 0 5px 50px 70px;">
            <span class="info-box-icon"><i class="fa fa-inr"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Payment Methods</span>
                <h3><?= \common\models\PaymentMethods::find()->count() ?></h3>
            </div>
            <!-- /.info-box-content -->
        </div>
    </a>
    <a style=" color:white" href="types">
        <div class="info-box"
             style="background-color:#F39C12 ;width: 20%;float: left;margin: 0 5px 50px 70px;">
            <span class="info-box-icon"><i class="fa fa-star"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Types</span>
                <h3><?= \common\models\Type::find()->count() ?></h3>
            </div>
            <!-- /.info-box-content -->
        </div>
    </a>
    <a style=" color:white" href="conditions">
        <div class="info-box"
             style="background-color:#f31299 ;width: 20%;float: left;margin: 0 5px 50px 70px;">
            <span class="info-box-icon"><i class="fa fa-star"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Condition</span>
                <h3><?= \common\models\Conditions::find()->count() ?></h3>
            </div>
            <!-- /.info-box-content -->
        </div>
    </a>
    <a style=" color:white" href="brand">
        <div class="info-box"
             style="background-color:#5D6D7E   ;width: 20%;float: left;margin: 0 5px 50px 70px;">
            <span class="info-box-icon"><i class="fa fa-star"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Brand</span>
                <h3><?= \common\models\Brand::find()->count() ?></h3>
            </div>
            <!-- /.info-box-content -->
        </div>
    </a>
    <a style=" color:white" href="composition">
        <div class="info-box"
             style="background-color:#CB4335;width: 20%;float: left;margin: 0 5px 50px 70px;">
            <span class="info-box-icon"><i class="fa fa-star"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Composition</span>
                <h3><?= \common\models\Composition::find()->count() ?></h3>
            </div>
            <!-- /.info-box-content -->
        </div>
    </a>
    <a style=" color:white" href="ingredients">
        <div class="info-box"
             style="background-color:#82E0AA ;width: 20%;float: left;margin: 0 5px 50px 70px;">
            <span class="info-box-icon"><i class="fa fa-star"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Ingredients</span>
                <h3><?= \common\models\Ingredients::find()->count() ?></h3>
            </div>
            <!-- /.info-box-content -->
        </div>
    </a>
    <a style=" color:white" href="packing">
        <div class="info-box"
             style="background-color:#A2F121 ;width: 20%;float: left;margin: 0 5px 50px 70px;">
            <span class="info-box-icon"><i class="fa fa-shopping-bag"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Packing</span>
                <h3><?= \common\models\Packing::find()->count() ?></h3>
            </div>
            <!-- /.info-box-content -->
        </div>
    </a>
    <a style=" color:white" href="contact-us">
        <div class="info-box"
             style="background-color:#F1216A  ;width: 20%;float: left;margin: 0 5px 50px 70px;">
            <span class="info-box-icon"><i class="fa fa-star"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Contact Us</span>
                <h3><?= \common\models\ContactUs::find()->count() ?></h3>
            </div>
            <!-- /.info-box-content -->
        </div>
    </a>
    <a style=" color:white" href="about-us">
        <div class="info-box"
             style="background-color:#F1CE21 ;width: 20%;float: left;margin: 0 5px 50px 70px;">
            <span class="info-box-icon"><i class="fa fa-star"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">About Us</span>
                <h3><?= \common\models\AboutUs::find()->count() ?></h3>
            </div>
            <!-- /.info-box-content -->
        </div>
    </a>
    <a style=" color:white" href="time-slot">
        <div class="info-box"
             style="background-color:#C8CD29 ;width: 20%;float: left;margin: 0 5px 50px 70px;">
            <span class="info-box-icon"><i class="fa fa-clock-o"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Time Slot</span>
                <h3><?= \common\models\TimeSlot::find()->count() ?></h3>
            </div>
            <!-- /.info-box-content -->
        </div>
    </a>
    <a style=" color:white" href="age-group">
        <div class="info-box"
             style="background-color:#BC29CD   ;width: 20%;float: left;margin: 0 5px 50px 70px;">
            <span class="info-box-icon"><i class="fa fa-star"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Age Group</span>
                <h3><?= \common\models\AgeGroup::find()->count() ?></h3>
            </div>
            <!-- /.info-box-content -->
        </div>
    </a>
</div>