<?php
require_once 'config.php';
require_once 'controller/database.php';
require_once 'controller/product.php';
$product = new Product($database);
$categories = $product->showCategory(100);
$producers = $product->showProducer(100);
$resultSearch = false;
$sorting = isset($_GET['sorting']) ? $_GET['sorting']: 0;
if($_GET) $resultSearch = $product->searchProduct($_GET, 10000);
define('PAGE_TYPE', 'search');
include 'include/header.php';
?>
<body class="fixed-sidebar fixed-nav-basic">
    <div id="wrapper">
        <?php include 'include/left.php' ?>
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom ">
                <?php include 'include/navbar.php' ?>
                <div class="wrapper wrapper-content">
                    <div class="ibox-content m-b-sm border-bottom">
                        <form action="search.php" method="GET">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label" for="categories[]">Loại sản phẩm</label>
                                        <select class="form-control" name="categories[]" id="select2_categories"
                                            multiple="multiple">
                                            <?php foreach ($categories as $category) { ?>
                                            <option value="<?=$category['id']?>"><?=$category['name']?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="control-label" for="producers[]">Nhà sản xuất</label>
                                        <select class="form-control" name="producers[]" id="select2_producers"
                                            multiple="multiple">
                                            <?php foreach ($producers as $producer) { ?>
                                            <option value="<?=$producer['id']?>"><?=$producer['name']?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label class="control-label" for="price">Giá</label>
                                    <div name="price">
                                        <div class="col-sm-6">
                                            <div class="form-group has-success">
                                                <input type="number" id="price" name="price[]"
                                                    value="<?=isset($_GET['price']) && is_array($_GET['price']) ? (int) $_GET['price'][0]: ''?>"
                                                    placeholder="" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group has-success">
                                                <input type="text" id="price" name="price[]"
                                                    value="<?=isset($_GET['price']) && is_array($_GET['price']) && $_GET['price'][1] > 0? (int) $_GET['price'][1]: ''?>"
                                                    placeholder="" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group has-success">
                                        <label class="control-label" for="keyword">Tên sản phẩm</label>

                                        <div class="input-group"><input type="text" name="keyword"
                                                value="<?=isset($_GET['keyword']) ? $_GET['keyword']: ''?>"
                                                placeholder="Từ khóa tìm kiếm" class="form-control"> <span
                                                class="input-group-btn"> <input type="submit" value="Go!"
                                                    class="btn btn-primary" /> </span></div>
                                        <div class="checkbox m-r-xs">
                                            <input type="checkbox" name="exactSearch"
                                                <?=isset($_GET['exactSearch']) ? 'checked' : ''?>>
                                            <label for="exactSearch">
                                                Tìm kiếm chính xác
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group has-success">
                                        <label class="control-label" for="sorting">Sắp xếp theo</label>                                        
                                        <select class="form-control m-b" name="sorting">
                                                <option value="0" <?=$sorting == 0 ? 'selected' : ''?>>Ngày đăng (mới nhất)</option>
                                                <option value="1" <?=$sorting == 1 ? 'selected' : ''?>>Ngày đăng (cũ nhất)</option>
                                                <option value="2" <?=$sorting == 2 ? 'selected' : ''?>>Giá (thấp nhất)</option>
                                                <option value="3" <?=$sorting == 3 ? 'selected' : ''?>>Giá (cao nhất)</option>
                                                <option value="4" <?=$sorting == 4 ? 'selected' : ''?>>Tên sản phẩm (A-Z)</option>
                                                <option value="5" <?=$sorting == 5 ? 'selected' : ''?>>Tên sản phẩm (Z-A)</option>
                                        </select>                                        
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php if($resultSearch !== false){?>
                <div class="wrapper wrapper-content ">
                    <?php if(count($resultSearch) == 0 ){?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="ibox white-bg">
                                <h3 style="padding: 15px 10px;">Không tìm thấy sản phẩm</h3>
                            </div>
                        </div>
                    </div>
                    <?php } else {?>
                    <div class="category">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="ibox white-bg">
                                    <h3 style="padding: 15px 10px;">Tìm thấy <?=count($resultSearch)?> sản phẩm</h3>
                                </div>
                            </div>
                        </div>
                        <?php while(count($resultSearch) != 0){?>
                        <div class="row">
                            <?php for($i = 0; $i < 4 && $i < count($resultSearch); $i++){
                                            $production = $resultSearch[$i];
                                            $images = explode("\n", $production['images']);
                                            $category = $product->showCategoryById($production['categoryID'])
                                ?>
                            <div class="col-md-3">
                                <div class="ibox">
                                    <div class="ibox-content product-box">

                                        <div class="product-imitation"
                                            style="background: url(template/upload/images/<?=$images[0]?>);background-size: cover;">

                                        </div>
                                        <div class="product-desc">
                                            <span class="product-price">
                                                <?= $production['price'] == 0 ? 'LIÊN HỆ':number_format($production['price'],0)?>
                                            </span>
                                            <small class="text-muted"><?=$category['name']?></small>
                                            <a href="production/<?=$production['slug']?>/<?=$production['id']?>.html"
                                                class="product-name"> <?=$production['name']?></a>
                                            <div class="small m-t-xs">
                                                <?=$production['description']?>.
                                            </div>
                                            <div class="m-t text-right">

                                                <a href="production/<?=$production['slug']?>/<?=$production['id']?>.html"
                                                    class="btn btn-xs btn-outline btn-primary">Info <i
                                                        class="fa fa-long-arrow-right"></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <?php  $resultSearch = array_slice($resultSearch, 4);  } ?>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>
                <br />
                <br />
                <?php include 'include/footer.php'?>
            </div>
        </div>
    </div>
    <?php include 'include/end.php'?>
</body>

</html>