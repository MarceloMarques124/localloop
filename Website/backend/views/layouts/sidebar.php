<?php

use hail812\adminlte\widgets\Menu;

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">

        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            if (Yii::$app->user->can('reviwer')) {

                echo Menu::widget([
                    'items' => [

                        ['label' => 'Yii2 PROVIDED', 'header' => true],
                        ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest],

                        ['label' => 'Dashboard', 'url' => ['/']],
                        ['label' => 'Users', 'url' => ['user-info/index']],
                        ['label' => 'Advertisements', 'url' => ['advertisement/index']],
                        [
                            'label' => 'Categories',
                            'items' => [
                                ['label' => 'Category', 'iconStyle' => 'far', 'url' => ['category/index']],
                                ['label' => 'Sub-Category', 'iconStyle' => 'far', 'url' => ['sub-category/index']]
                            ]
                        ],
                        [
                            'label' => 'Reports',
                            'items' => [
                                ['label' => 'User Reports', 'iconStyle' => 'far', 'url' => ['user-report/index']],
                                ['label' => 'Advertisement Reports', 'iconStyle' => 'far', 'url' => ['advertisement-report/index']]
                            ]
                        ],
                        /*                     ['label' => 'LABELS', 'header' => true],
                    ['label' => 'Important', 'iconStyle' => 'far', 'iconClassAdded' => 'text-danger'],
                    ['label' => 'Warning', 'iconClass' => 'nav-icon far fa-circle text-warning'],
                    ['label' => 'Informational', 'iconStyle' => 'far', 'iconClassAdded' => 'text-info'], */
                    ],
                ]);
            }
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>