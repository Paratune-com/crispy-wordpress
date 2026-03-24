<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="container-fluid response">
    <!-- Tabs with icons on Card -->
    <div class="topar">
        <div class="row align-items-center">
            <div class="class col-md-2 topar1 d-flex align-items-center justify-content-between">
                <p>Heyyo</p>
                <img class='topar-image' src="<?=plugin_dir_url(__FILE__)?>/img/logo.jpeg">
            </div>
            <div class="class col-md-7 topar2">We are so excited that you are using the Vagonic Sortable. I hope you like it. In the Lite version, each product can be listed in only 1 category. Do you want to review the Pro version for
                multi-category ranking and all other features?
            </div>
            <div class="class col-md-3 topar3  ">
                <div class="d-flex align-items-center">
                    <h2 class="cupon">Our Special 4 Dollar Coupon Code</h2>
                    <h3 class="code">HEY3</h3>
                </div>

            </div>
        </div>
    </div>
    <style>
        .topar {
            width: 100%;
            background: #626a6d;
            padding: 10px;
        }

        .topar-image{
            width: 70px;
        }

        .topar1, .topar2, .topar3 {
            color: #fff;
            font-size: 18px;
        }

        .topar1 p{
            font-size: 44px;
        }

        .topar2 {
            font-size: 14px;
        }

        .cupon {
            font-size: 16px;
            width: 50%;

            color: #fff;
            height: 100%;
        }

        .code {

            font-size: 37px;
            padding: 2px 10px;
            background: #fbff9d;
            border: dashed 3px #616a6d;
            width: 50%;
            text-align: center;
            font-family: Arial black;
            color: #616a6d;

        }


    </style>
    <div class="card card-nav-tabs card-plain">
        <div class="card-header card-header-purple">
            <!-- colors: "header-primary", "header-info", "header-success", "header-warning", "header-danger" -->
            <?php
            include('inc/page_header.php');
            ?>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="home">
                    <?php
                    include('inc/page_home.php');
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <?php
    include('inc/page_footer.php');
    ?>

</div>