<?php
require_once 'config.php';
require_once 'controller/database.php';
require_once 'controller/product.php';
$product = new Product($database);
$categories = $product->showCategory(100);
$producers = $product->showProducer(100);
$user = isset($_COOKIE['user']) ? json_decode($_COOKIE['user']) : false;
if(!$user || $user->permission == 0) header("Location: ".$__config['urlBase']);
if($_POST) {   
    $dataInsert = $_POST;
    $dataInsert['memberID'] = $user->id;    
    if($product->insertProduct($dataInsert)){
        echo "<script>alert('Nhập sản phẩm thành công');window.location.href='{$__config['urlBase']}';</script>";
    }
    else echo "<script>alert('Nhập sản phẩm thất bại');</script>";
}
define('PAGE_TYPE', 'insert');
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
                        <h2>Nhập sản phẩm</h2>
                        <ol class="breadcrumb">
                            <li>
                                <a href="">Trang chủ</a>
                            </li>
                            <li class="active">
                                <strong>Thêm sản phẩm</strong>
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="wrapper wrapper-content animated fadeInRight ecommerce">
                    <div class="row">
                        <div class="col-lg-12">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="tabs-container">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tab-1"> Thông tin sản phẩm</a></li>
                                    <li class=""><a data-toggle="tab" href="#tab-2"> Dữ liệu chi tiết</a></li>
                                    <li class=""><a data-toggle="tab" href="#tab-3"> Hình ảnh</a></li>
                                </ul>
                                <form action="insert.php" method="POST">
                                    <div class="tab-content">
                                        <div id="tab-1" class="tab-pane active">
                                            <div class="panel-body">
                                                <fieldset class="form-horizontal">
                                                    <div class="form-group"><label class="col-sm-2 control-label">Tên
                                                            sản phẩm:</label>
                                                        <div class="col-sm-10"><input type="text" name="name"
                                                                class="form-control" placeholder="Tên sản phẩm"
                                                                required=""></div>
                                                    </div>
                                                    <div class="form-group"><label
                                                            class="col-sm-2 control-label">Giá:</label>
                                                        <div class="col-sm-10"><input type="number" name="price"
                                                                class="form-control" min="0" placeholder="1000000"
                                                                required=""></div>
                                                    </div>
                                                    <div class="form-group"><label class="col-sm-2 control-label">Mô tả
                                                            sản phẩm:</label>
                                                        <div class="col-sm-10">
                                                            <textarea id="summernote" name="description"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-4 col-sm-offset-4">
                                                            <button class="btn btn-white" type="reset">Nhập lại</button>
                                                            <button class="btn btn-primary" type="submit"><i
                                                                    class="fa fa-database"></i> Nhập sản phẩm</button>
                                                        </div>
                                                    </div>

                                                </fieldset>

                                            </div>
                                        </div>
                                        <div id="tab-2" class="tab-pane">
                                            <div class="panel-body">
                                                <fieldset class="form-horizontal">
                                                    <div class="form-group"><label
                                                            class="col-sm-2 control-label">ID:</label>
                                                        <div class="col-sm-10"><input type="text" class="form-control"
                                                                disabled placeholder=""></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Loại sản phẩm:</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control" name="categoryID">
                                                                <?php foreach ($categories as $category) {?>
                                                                <option value="<?=$category['id']?>">
                                                                    <?=$category['name']?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Nhà sản xuất:</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control" name="producerID">
                                                                <?php foreach ($producers as $producer) {?>
                                                                <option value="<?=$producer['id']?>">
                                                                    <?=$producer['name']?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group"><label
                                                            class="col-sm-2 control-label">Status:</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control" name="status" disabled>
                                                                <option value="stocking">Còn hàng</option>
                                                                <option value="oversell">Hết hàng</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </fieldset>


                                            </div>
                                        </div>
                                        <div id="tab-3" class="tab-pane">

                                            <div class="panel-body">
                                                <div class="row">
                                                    <a data-toggle="modal" class="btn btn-primary pull-right"
                                                        href="#upload-image-modal">
                                                        <i class="fa fa-database"></i> Thêm ảnh
                                                    </a>
                                                    <div class="modal inmodal fade" id="upload-image-modal"
                                                        tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content modal-lg">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Tải lên hình ảnh</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="image-crop">
                                                                                <img/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="img-preview">
                                                                            </div>
                                                                            <p>
                                                                                Tải lên hình ảnh có kích thước tối thiểu 380x410
                                                                            </p>
                                                                            <div class="btn-group">
                                                                                <label title="Upload image file"
                                                                                    for="inputImage"
                                                                                    class="btn btn-primary">
                                                                                    <input type="file" accept="image/*"
                                                                                        name="file" id="inputImage"
                                                                                        class="hide">
                                                                                    Upload hình mới
                                                                                </label>
                                                                                <label title="Donload image"
                                                                                    id="download"
                                                                                    class="btn btn-primary">Download</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-white"
                                                                        data-dismiss="modal">Close</button>
                                                                    <button type="button" class="btn btn-primary" id="upload-image-button" data-dismiss="modal">Đăng ảnh</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br />
                                                <div class="row">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-stripped">
                                                            <thead>
                                                                <tr>
                                                                    <th>
                                                                        Xem trước ảnh
                                                                    </th>
                                                                    <th>
                                                                        Đường dẫn hình ảnh
                                                                    </th>
                                                                    <th>
                                                                        Thứ tự
                                                                    </th>
                                                                    <th>
                                                                        Actions
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="listImage">                                                                
                                                                <!-- <tr>
                                                                    <td>
                                                                        <img class="img-lg" src="template/img/gallery/1s.jpg">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control"
                                                                            value="http://mydomain.com/images/image2.png"
                                                                            name="images[]">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control"
                                                                            value="2" name="sort[]">
                                                                    </td>
                                                                    <td>
                                                                        <button class="btn btn-white"><i
                                                                                class="fa fa-trash"></i> </button>
                                                                    </td>
                                                                </tr>                                                                 -->
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </form>
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