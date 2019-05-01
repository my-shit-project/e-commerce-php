<!-- Mainly scripts -->
    <script src="template/js/jquery-3.1.1.min.js"></script>
    <script src="template/js/bootstrap.min.js"></script>
    <script src="template/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="template/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="template/js/inspinia.js"></script>
    <script src="template/js/plugins/pace/pace.min.js"></script>
<?php switch (PAGE_TYPE) {
    case 'search':
        ?>
    <!-- Select2 -->    
    <script src="template/js/plugins/select2/select2.full.min.js"></script>
        <?php
        break;
    case 'production':
        ?> 
    <!-- slick carousel-->
    <script src="template/js/plugins/slick/slick.min.js"></script>
        <?php
        break;
    case 'insert':
        ?>
    <!-- SUMMERNOTE -->
    <script src="template/js/plugins/summernote/summernote.min.js"></script>
    <!-- Image cropper -->
    <script src="template/js/plugins/cropper/cropper.min.js"></script>
    <!-- Sweet alert -->
    <script src="template/js/plugins/sweetalert/sweetalert.min.js"></script>
        <?php
        break;
    default:
        # code...
        break;
} ?>

    <script>
        window.lastScrollTop = $(document).scrollTop();
        $(document).ready(function(){
            $(document).scroll(function(){
                let scrollTop = $(this).scrollTop();
                if(scrollTop > window.lastScrollTop){
                    //scrolldown
                    $('body').removeClass('fixed-nav');
                    $('#top-navbar').addClass('navbar-static-top');                    
                    $('#top-navbar').removeClass('navbar-fixed-top');
                }else{
                    $('body').addClass('fixed-nav');                    
                    $('#top-navbar').removeClass('navbar-static-top');                    
                    $('#top-navbar').addClass('navbar-fixed-top');
                }
                window.lastScrollTop = scrollTop;
            });

 <?php switch (PAGE_TYPE)
  {
     case 'search':
      ?>
       $("#select2_categories").select2({
           placeholder: "Chọn các loại sản phẩm",
           allowClear: true,
       }).select2('val', [<?=isset($_GET['categories']) ? implode(',',$_GET['categories']): ''?>]);

       $("#select2_producers").select2({
           placeholder: "Chọn các nhà sản xuất",
           allowClear: true
       }).select2('val', [<?=isset($_GET['producers']) ? implode(',',$_GET['producers']): ''?>]);
      <?php
       break;
     case 'production':
      ?> 
       $('.product-images').slick({
            dots: true
       });                
     <?php
       break;

     case 'insert':
      ?>
       $('#summernote').summernote();
        function createElementImage(filename, index = 1){
           let trTag = $('<tr></tr>');
           $('<td></td>').append($('<img/>',{
               src: `template/upload/images/${filename}`,
               class: 'img-lg'
           })).appendTo(trTag);
           $('<td></td>').append($('<input/>',{
               type: 'text',
               class: 'form-control',
               name: 'images[]',
               value: filename
           })).appendTo(trTag);
           $('<td></td>').append($('<input/>',{
               type: 'text',
               class: 'form-control',
               name: 'sort[]',
               value: index
           })).appendTo(trTag);
           let btnDelete = $(`<button class="btn btn-white btn-delete-image" type="button"><i class="fa fa-trash"></i></button>`);
           btnDelete.click(function(e){
               $(this).parents('tr').remove();
           });
           $('<td></td>').append(btnDelete).appendTo(trTag);
           return trTag;
         }  
       //Image cropper
       var $image = $(".image-crop > img")
       $($image).cropper({
           aspectRatio: 380 / 410,
           preview: ".img-preview",
           zoomable: false,
           done: function(data) {}
       });
       var $inputImage = $("#inputImage");
       if (window.FileReader) {
           $inputImage.change(function() {
               var fileReader = new FileReader(), files = this.files, file;
               if (!files.length) {
                   return;
               }
               file = files[0];
               if (/^image\/\w+$/.test(file.type)) {
                   fileReader.readAsDataURL(file);
                   fileReader.onload = function() {
                       $inputImage.val("");
                       $image.cropper("reset", true).cropper("replace", this.result);
                   }
                   ;
               } else {
                   showMessage("Please choose an image file.");
               }
           });
       } else {
           $inputImage.addClass("hide");
       }
       $("#download").click(function() {
           window.open($image.cropper("getDataURL"));
       });

       //Upload image
       $("#upload-image-button").click(function() {
           $.ajax({
               url: "upload.php",
               dataType: "json",
               method: "POST",
               data: {
                   base64_image: $image.cropper("getDataURL")
               },
               success: function({error, message, filename}) {
                   if (error === true) {
                       swal({
                           title: "Có lỗi xảy ra",
                           text: message,
                           type: "error",
                           closeOnConfirm: true
                       }, function() {
                       });
                   }
                   else{
                       swal({
                           title: "Success",
                           text: message,
                           type: "success",
                           closeOnConfirm: true
                       }, function() {
                           let index = $('#listImage > tr').length + 1;
                           createElementImage(filename, index).appendTo($('#listImage'));
                       });
                   }
               }
           })
       });

       


      <?php
       break;
   default:
 # code...
      break;
 } ?>

          })
    </script>
    