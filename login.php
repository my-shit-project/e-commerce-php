<?php
   require_once 'config.php';
   require_once 'controller/database.php';
   require_once 'controller/member.php';
   $member = new Member($database);
   define("PAGE_TYPE", "login");
   include 'include/header.php';
   if(!empty($_POST['email']) && !empty($_POST['password'])){
       $user = $member->checkLogin($_POST['email'], $_POST['password']);
       if($user['EXIT_USER'] != 1)  echo "<script>alert('Lỗi: Email không tồn tại')</script>";
       else if($user['CORRECT_PASS'] != 1) echo "<script>alert('Lỗi: Sai mật khẩu')</script>";
       else {
           setcookie("user", json_encode($member->getInfo($user['id'])), time() + 60*60*24*30);
           echo "<script>setTimeout(() => window.location.href='{$__config['urlBase']}', 1000)</script>";
       }
   }
?>


<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <h3>Đăng nhập</h3>
            <form class="m-t" role="form" action="login.php" method="POST">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="Email" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Đăng nhập</button>

                <a href="#"><small>Quên mật khẩu?</small></a>
                <p class="text-muted text-center"><small>Chưa có tài khoản?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="register.php">Tạo tài khoản</a>
            </form>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="template/js/jquery-3.1.1.min.js"></script>
    <script src="template/js/bootstrap.min.js"></script>

</body>

</html>
