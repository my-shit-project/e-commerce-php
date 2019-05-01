<?php
   require_once 'config.php';
   require_once 'controller/database.php';
   require_once 'controller/member.php';
   $member = new Member($database);
   define("PAGE_TYPE", "register");
   include 'include/header.php';
   if(!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['name'])){
    //    
       if($member->exitEmail($_POST['email']))  echo "<script>alert('Lỗi: Email đã được đăng ký')</script>";
       else {
           $id = $member->createMember($_POST['email'], $_POST['password'], $_POST['name']);
           if(!$id) echo "<script>alert('Lỗi: Đăng ký thất bại')</script>";
           else{
                setcookie("user", json_encode($member->getInfo($id)), time() + 60*60*24*30);
                echo "<script>setTimeout(() => window.location.href='{$__config['urlBase']}', 1000)</script>";
           }
           
       }
   }
?>


<body class="gray-bg">

    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <h3>Đăng ký</h3>
            <form class="m-t" role="form" action="register.php" method="POST">
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Tên của bạn" required="">
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Đăng ký</button>

                <p class="text-muted text-center"><small>Bạn đã có tài khoản?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="login.php">Đăng nhập</a>
            </form>
            
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
