<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <!-- <div class="user-panel">
            <div class="pull-left image">
                <img src="<?/*= $directoryAsset */

        use dmstr\widgets\Menu; ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
-->
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu Homeocare', 'options' => ['class' => 'header']],
                    // ['label'=>'auth genrate','url'=>['/auth/rbac']],
                    ['label' => 'Dashboard', 'icon' => 'dashboard', 'url' => ['/']],
                    // ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    /* [
                         'label' => 'Some tools',
                         'icon' => 'share',
                         'url' => '#',
                         'items' => [
                             ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                             ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                             [
                                 'label' => 'Level One',
                                 'icon' => 'circle-o',
                                 'url' => '#',
                                 'items' => [
                                     ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                     [
                                         'label' => 'Level Two',
                                         'icon' => 'circle-o',
                                         'url' => '#',
                                         'items' => [
                                             ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                             ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                         ],
                                     ],
                                 ],
                             ],
                         ],
                     ],*/
                    [
                        'label' => 'User',
                        'icon' => 'user',
                        'url' => '/user',
                        
                    ],
                    [
                        'label' => 'Countries',
                        'icon' => 'dot-circle-o',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Country List', 'icon' => 'list', 'url' => ['/countries'],],
                            ['label' => 'Add Country', 'icon' => 'glyphicon glyphicon-plus', 'url' => ['/countries/create'],],

                        ],
                    ],
                    [
                        'label' => 'States',
                        'icon' => 'dot-circle-o',
                        'url' => '#',
                        'items' => [
                            ['label' => 'State List', 'icon' => 'list', 'url' => ['/states'],],
                            ['label' => 'Add State', 'icon' => 'glyphicon glyphicon-plus', 'url' => ['/states/create'],],

                        ],
                    ],
                    [
                        'label' => 'Cities',
                        'icon' => 'dot-circle-o',
                        'url' => '#',
                        'items' => [
                            ['label' => 'city List', 'icon' => 'list', 'url' => ['/cities'],],
                            ['label' => 'Add city', 'icon' => 'glyphicon glyphicon-plus', 'url' => ['/cities/create'],],

                        ],
                    ],
                    [
                        'label' => 'Payment Methods',
                        'icon' => 'inr',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Method List', 'icon' => 'list', 'url' => ['/payment-methods'],],
                            ['label' => 'Add Method', 'icon' => 'glyphicon glyphicon-plus', 'url' => ['/payment-methods/create'],],
                        ],
                    ],
//                    [
//                        'label' => 'Language',
//                        //'icon' => 'category',
//                        'url' => '#',
//                        'items' => [
//                            ['label' => 'Language List', 'icon' => 'list', 'url' => ['/language'],],
//                            ['label' => 'Add Language', 'icon' => 'glyphicon glyphicon-plus', 'url' => ['/language/create'],],
//                        ],
//                    ],
                    [
                        'label' => 'Medicine Category',
                        'icon' => 'asterisk',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Category List', 'icon' => 'list', 'url' => ['/category'],],
                            ['label' => 'Add Category', 'icon' => 'glyphicon glyphicon-plus', 'url' => ['/category/create'],],
                        ],
                    ],
                    [
                        'label' => 'Medicine Type',
                        'icon' => 'star',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Type List', 'icon' => 'list', 'url' => ['/type'],],
                            ['label' => 'Add Type ', 'icon' => 'glyphicon glyphicon-plus', 'url' => ['/type/create'],],
                        ],
                    ],
                    [
                        'label' => 'Medicine Brand',
                        'icon' => 'star',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Brand List', 'icon' => 'list', 'url' => ['/brand'],],
                            ['label' => 'Add Brand ', 'icon' => 'glyphicon glyphicon-plus', 'url' => ['/brand/create'],],
                        ],
                    ],
                    [
                        'label' => 'Medicine Composition',
                        'icon' => 'star',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Composition List', 'icon' => 'list', 'url' => ['/composition'],],
                            ['label' => 'Add Composition ', 'icon' => 'glyphicon glyphicon-plus', 'url' => ['/composition/create'],],
                        ],
                    ],
                    [
                        'label' => 'Medicine Ingredients',
                        'icon' => 'star',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Ingredients List', 'icon' => 'list', 'url' => ['/ingredients'],],
                            ['label' => 'Add Ingredients ', 'icon' => 'glyphicon glyphicon-plus', 'url' => ['/ingredients/create'],],
                        ],
                    ],
                    [
                        'label' => 'Medicine Packing weight',
                        'icon' => 'shopping-bag',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Packing weight List', 'icon' => 'list', 'url' => ['/packing'],],
                            ['label' => 'Add Packing weight ', 'icon' => 'glyphicon glyphicon-plus', 'url' => ['/packing/create'],],
                        ],
                    ],

                    [
                        'label' => 'Conditions',
                        'icon' => 'star',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Condition List', 'icon' => 'list', 'url' => ['/conditions'],],
                            ['label' => 'Add Conditions ', 'icon' => 'glyphicon glyphicon-plus', 'url' => ['/conditions/create'],],
                        ],
                    ],
                    [
                        'label' => 'Medicine',
                        'icon' => 'briefcase',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Medicine List', 'icon' => 'list', 'url' => ['/medicines'],],
                            ['label' => 'Add Medicine ', 'icon' => 'glyphicon glyphicon-plus', 'url' => ['/medicines/create'],],
                        ],
                    ],
                    [
                        'label' => 'Blogs',
                        'icon' => 'dot-circle-o',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Blog List', 'icon' => 'list', 'url' => ['/blogs'],],
                            ['label' => 'Add Blog ', 'icon' => 'glyphicon glyphicon-plus', 'url' => ['/blogs/create'],],
                        ],
                    ],
                    [
                        'label' => 'Contact Us',
                        'icon' => 'star',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Contact Detail', 'icon' => 'list', 'url' => ['/contact-us'],],
                            ['label' => 'Add Contact Detail', 'icon' => 'glyphicon glyphicon-plus', 'url' => ['/contact-us/create'],],

                        ],
                    ],
                    [
                        'label' => 'About Us',
                        'icon' => 'star',
                        'url' => '#',
                        'items' => [
                            ['label' => 'AboutUs List', 'icon' => 'list', 'url' => ['/about-us'],],
                            ['label' => 'Add AboutUs Detail', 'icon' => 'glyphicon glyphicon-plus', 'url' => ['/about-us/create'],],

                        ],
                    ],
                    [
                        'label' => 'Age Group',
                        'icon' => 'star',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Age Group List', 'icon' => 'list', 'url' => ['/age-group'],],
                            ['label' => 'Add Age Group', 'icon' => 'glyphicon glyphicon-plus', 'url' => ['/age-group/create'],],

                        ],
                    ],
                    [
                        'label' => 'Time Slot',
                        'icon' => 'clock-o',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Time Slot List', 'icon' => 'list', 'url' => ['/time-slot'],],
                            ['label' => 'Add time slot', 'icon' => 'glyphicon glyphicon-plus', 'url' => ['/time-slot/create'],],

                        ],
                    ],
                    [
                        'label' => 'Appoinment Bookings',
                        'icon' => 'ticket',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Booking List', 'icon' => 'list', 'url' => ['/appoinment-booking'],],
                        ],
                    ],
                    [
                        'label' => 'Cart',
                        'icon' => 'shopping-cart',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Cart List', 'icon' => 'list', 'url' => ['/cart'],],
                        ],
                    ],
                    [
                        'label' => 'Orders',
                        'icon' => 'first-order',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Order List', 'icon' => 'list', 'url' => ['/orders'],],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
