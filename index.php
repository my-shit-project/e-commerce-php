<?php
require_once 'config.php';
require_once 'controller/database.php';
require_once 'controller/product.php';
$product = new Product($database);
$categories = $product->showCategory(3);
define('PAGE_TYPE', 'home');
include 'include/header.php';
?>
<body class="fixed-sidebar fixed-nav-basic">
    <div id="wrapper">
        <?php include 'include/left.php' ?>
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom ">
                <?php include 'include/navbar.php' ?>
                <div class="wrapper page-heading">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="carousel slide" id="carousel2">
                                <ol class="carousel-indicators">
                                    <li data-slide-to="0" data-target="#carousel2" class="active"></li>
                                    <li data-slide-to="1" data-target="#carousel2"></li>
                                    <li data-slide-to="2" data-target="#carousel2"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <div class="item active">
                                        <img alt="image" class="img-responsive" width="100%"
                                            src="template/img/p_big1.jpg">
                                        <div class="carousel-caption">
                                            <!-- <p>Sản </p> -->
                                        </div>
                                    </div>
                                    <div class="item ">
                                        <img alt="image" class="img-responsive" width="100%"
                                            src="template/img/p_big3.jpg">
                                        <div class="carousel-caption">
                                            <!-- <p>This is simple caption 2</p> -->
                                        </div>
                                    </div>
                                    <div class="item">
                                        <img alt="image" class="img-responsive" width="100%"
                                            src="template/img/p_big2.jpg">
                                        <div class="carousel-caption">
                                            <!-- <p>This is simple caption 3</p> -->
                                        </div>
                                    </div>
                                </div>
                                <a data-slide="prev" href="#carousel2" class="left carousel-control">
                                    <span class="icon-prev"></span>
                                </a>
                                <a data-slide="next" href="#carousel2" class="right carousel-control">
                                    <span class="icon-next"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="wrapper wrapper-content ">
                    <?php foreach ($categories as $category) { 
                      $productions = $product->showProductByCategoryId($category['id'], 8);
                      if(count($productions) == 0) continue;                      
                    ?>
                    
                    <div class="category">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="ibox white-bg">
                                    <h2 style="padding: 15px 10px;"><a href="category/<?=$category['slug']?>/<?=$category['id']?>.html"
                                            style="color: #676a6c;"><?=$category['name']?></a></h2>
                                </div>
                            </div>
                        </div>
                        <?php while(count($productions) != 0){?>
                        <div class="row">
                            <?php for($i = 0; $i < 4 && $i < count($productions); $i++){
                              $production = $productions[$i];
                              $images = explode("\n", $production['images']);
                            ?>
                            <div class="col-md-3">
                                <div class="ibox">
                                    <div class="ibox-content product-box">

                                        <div class="product-imitation" style="background: url(template/upload/images/<?=$images[0]?>);background-size: cover;">
                                            
                                        </div>
                                        <div class="product-desc">
                                            <span class="product-price">
                                                <?= $production['price'] == 0 ? 'LIÊN HỆ':number_format($production['price'],0)?>
                                            </span>
                                            <small class="text-muted"><?=$category['name']?></small>
                                            <a href="production/<?=$production['slug']?>/<?=$production['id']?>.html" class="product-name"> <?=$production['name']?></a>
                                            <div class="small m-t-xs">
                                               <?=$production['description']?>.
                                            </div>
                                            <div class="m-t text-right">

                                                <a href="production/<?=$production['slug']?>/<?=$production['id']?>.html" class="btn btn-xs btn-outline btn-primary">Info <i
                                                        class="fa fa-long-arrow-right"></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <?php
                            $productions = array_slice($productions, 4);
                        } ?>
                    </div>
                    <?php } ?>
                </div>
                <?php include 'include/footer.php'?>
            </div>
        </div>
    </div>
    <?php include 'include/end.php'?>
</body>

</html>