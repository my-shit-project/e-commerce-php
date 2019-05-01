<nav class="navbar navbar-static-top gray-bg" id="top-navbar" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary"><i
                            class="fa fa-bars"></i> </a>
                    <!-- <form role="search" class="navbar-form-custom" action="search_results.html">
                        <div class="form-group">
                            <input type="text" placeholder="Search for something..." class="form-control"
                                name="top-search" id="top-search">
                        </div>
                    </form> -->
                </div>
                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <a class="count-info" href="#a">
                            <i class="fa fa-cart-plus"></i> <span class="label label-warning">1</span>
                        </a>
                    </li>

                    <li>
                        <?php if(isset($_COOKIE['user'])){
                        echo '<a href="logout.php">
                            <i class="fa fa-sign-out"></i> Đăng xuất
                        </a>';
                        }else{
                        echo '<a href="login.php">
                            <i class="fa fa-sign-in"></i> Đăng nhập
                        </a>';    
                        }?>   
                    </li>
                </ul>

            </nav>
            