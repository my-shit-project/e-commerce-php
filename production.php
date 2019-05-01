<?php
require_once 'config.php';
require_once 'controller/database.php';
require_once 'controller/product.php';
$product = new Product($database);
if(!isset($_GET['id'])) header('Location: '.$__config['urlBase']);
$production = $product->showProductById($_GET['id']);
if(!$production) header('Location: '.$__config['urlBase']);
$category = $product->showCategoryById($production['categoryID']);
$images = explode("\n", $production['images']);
// $a = array(1,2,3,4,5);
// $a = array_slice($a ,3);
// print_r();
// print_r($categories);
// echo number_format(12000000,0);
define('PAGE_TYPE', 'production');
include 'include/header.php';
?>
<body class="fixed-sidebar fixed-nav-basic">
    <div id="wrapper">
        <?php include 'include/left.php' ?>
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom ">
                <?php include 'include/navbar.php' ?>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>Thông tin sản phẩm</h2>
                        <ol class="breadcrumb">
                            <li>
                                <a href="">Trang chủ</a>
                            </li>
                            <li>
                                <a href="category/<?=$category['slug']?>/<?=$category['id']?>.html"><?=$category['name']?></a>
                            </li>
                            <li class="active">
                                <strong><?=$production['name']?></strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>

                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="ibox product-detail">
                                <div class="ibox-content">

                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="product-images">
                                                <?php if(count($images) == 0) {?>
                                                    <div class="image-imitation">
                                                        <p>[NO-IMG]</p>
                                                    </div>
                                                <?php } else foreach ($images as $image) { ?>
                                                    <div class="image-imitation" style="background: url(template/upload/images/<?=$image?>);background-size:cover;">
                                                        <p></p>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-md-7">

                                            <h2 class="font-bold m-b-xs">
                                               <?=$production['name']?>
                                            </h2>
                                            <small><?=$category['name']?></small>
                                            <hr>
                                            <div> 
                                                <?php if($production['price'] > 0) {?>                                              
                                                <button class="btn btn-primary pull-right" >Thêm vào giỏ hàng</button>
                                                <?php } ?>
                                                <h2 class="product-main-price"><p class="text-success"><?=$production['price'] > 0 ? number_format($production['price'],0): 'LIÊN HỆ'?></p></h2>
                                            </div>

                                            <hr>
                                            <h4>Mô tả về sản phẩm</h4>

                                            <div class="small text-muted">
                                                <?=strlen($production['description']) > 0 ? $production['description'] : 'Chưa có mô tả về sản phẩm' ?>
                                            </div>
                                            <dl class="dl-horizontal m-t-md small">
                                            </dl>
                                            <div class="text-right ">
                                                <div class="btn-group">
                                                    <button class="btn btn-white btn-sm"><i class="fa fa-star"></i> Thêm vào mục ưa thích </button>
                                                    <button class="btn btn-white btn-sm"><i class="fa fa-envelope"></i>
                                                        Liên hệ </button>
                                                </div>
                                            </div>


                                        </div>
                                    </div>

                                </div>
                                <div class="ibox-footer">
                                    <span class="pull-right">
                                       <?=$production['status'] == "stocking" ? 'Còn hàng' : 'Hết hàng'?> - <i class="fa fa-clock-o"></i> <?=$production['createAt']?>
                                    </span>
                                    Liên hệ admin để biết thêm chi tiết
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <?php include 'include/footer.php'?>
            </div>
        </div>
    </div>
    <?php include 'include/end.php'?>
</body>

</html>