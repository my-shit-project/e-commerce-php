<?php
  $user = false;
  if(isset($_COOKIE['user']))  $user = json_decode($_COOKIE['user']);
?>
<nav class="navbar-default navbar-static-side " role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> 
                        <span>
                            <img alt="image" class="img-circle" src="template/img/profile_small.jpg" />
                        </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">Company name</strong>
                                </span> <span class="text-muted text-xs block">Công ty công nghệ</span>
                            </span>
                        </a>

                    </div>
                    <div class="logo-element">
                        IN+
                    </div>
                </li>

                <li>
                    <a href="index.php"><i class="fa fa-home"></i> <span class="nav-label">Trang chủ</span></a>
                </li>
                <li>
                    <a href="search.php"><i class="fa fa-search"></i> <span class="nav-label">Tìm kiếm sản phẩm</span>
                    </a>
                </li>
                <?php if($user && $user->permission > 0){?>
                    
                <li>
                    <a href="insert.php"><i class="fa fa-edit"></i> <span class="nav-label">Nhập sản phẩm</span>
                    </a>
                </li>
                <?php } ?>                
                <li>
                    <a href="#"><i class="fa fa-yelp"></i> <span class="nav-label">Sản phẩm mới</span>
                    </a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-flask"></i> <span class="nav-label">Sản phẩm bán
                            chạy</span></a>
                </li>
            </ul>

        </div>
    </nav>
    