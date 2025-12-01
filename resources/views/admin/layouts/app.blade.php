<!DOCTYPE html>
 <html class="loading" lang="en" >
   <!-- BEGIN: Head-->
   <head>

     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <!-- CSRF Token -->
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <meta http-equiv="X-UA-Compatible" content="IE=edge" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
     <meta name="description" content="" />
     <meta name="keywords" content="" />
     <meta name="author" content="NIT" />
     @yield('title')
     <link rel="apple-touch-icon" href="{{asset(general()->favicon())}}" />
     <link rel="shortcut icon" type="image/x-icon" href="{{asset(general()->favicon())}}" />

     <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet" />

     <!-- BEGIN: Vendor CSS-->
     <link rel="stylesheet" type="text/css" href="{{asset(assetLinkAdmin().'/app-assets/vendors/css/vendors.min.css')}}" />
     <link rel="stylesheet" type="text/css" href="{{asset(assetLinkAdmin().'/app-assets/vendors/css/forms/selects/select2.min.css')}}" />
     <!-- END: Vendor CSS-->

     <!-- BEGIN: Theme CSS-->
     <link rel="stylesheet" type="text/css" href="{{asset(assetLinkAdmin().'/app-assets/css/bootstrap.min.css')}}" />
     <link rel="stylesheet" type="text/css" href="{{asset(assetLinkAdmin().'/app-assets/css/bootstrap-extended.min.css')}}" />
     <link rel="stylesheet" type="text/css" href="{{asset(assetLinkAdmin().'/app-assets/css/colors.min.css')}}" />
     <link rel="stylesheet" type="text/css" href="{{asset(assetLinkAdmin().'/app-assets/css/components.min.css')}}" />
     <!-- END: Theme CSS-->

     <!-- BEGIN: Page CSS-->
     <link rel="stylesheet" type="text/css" href="{{asset(assetLinkAdmin().'/app-assets/css/core/menu/menu-types/vertical-menu-modern.css')}}" />
     <link rel="stylesheet" type="text/css" href="{{asset(assetLinkAdmin().'/app-assets/css/core/colors/palette-gradient.min.css')}}" />
     <link rel="stylesheet" type="text/css" href="{{asset(assetLinkAdmin().'/app-assets/fonts/simple-line-icons/style.min.css')}}" />
     <link rel="stylesheet" type="text/css" href="{{asset(assetLinkAdmin().'/app-assets/css/pages/vertical-timeline.min.css')}}" />
     <!-- END: Page CSS-->

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"/>
     <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet" />
     <link rel="stylesheet" type="text/css" href="{{asset(assetLinkAdmin().'/app-assets/css/tag-editor.css')}}" />
     <!-- BEGIN: Custom CSS-->
     <link rel="stylesheet" type="text/css" href="{{asset(assetLinkAdmin().'/app-assets/css/style.css')}}" />
     <!-- END: Custom CSS-->

     <!-- BEGIN: Theme JS-->
     <script src="{{asset(assetLinkAdmin().'/app-assets/js/JsBarcode.all.js')}}"></script>

    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>

    <style type="text/css">
        body {
            font-size: 16px;
        }
        .navigation {
            font-size: 16px;
        }
        ul.statuslist li::before {
          content: '';
          width: 1px;
          height: 16px;
          background: #dddee1;
          position: absolute;
          left: 0px;
          right: auto;
          top: 5px;
        }
      ul.statuslist li:first-child::before {
        width: 0;
      }
      ul.statuslist li {
          display: inline-block;
          position: relative;
          padding: 0 5px;
      }
      ul.statuslist {
          margin: 0;
          padding: 0;
          list-style: none;
          text-align: right;
      }
      .table td, .table th {
        padding: 0.5rem 1rem;
      }

      .ibox-tools {
          display: block;
          float: none;
          margin-top: 0;
          position: absolute;
          top: 7px;
          right: 15px;
          padding: 0;
          text-align: right;
      }

      .btn.btn-md {
        padding: 5px 15px;
        margin: 5px;
    }
    .tools-right {
        float: right;
        top: 0;
        position: absolute;
        right: 0;
        padding: 10px;
    }
    .card-header {
        background: #4859b9;
        color: white;
    }
    .mce-content-body h1 {
        font-size: 32px;
        margin: 0;
        margin-bottom: 20px;
    }
    
    .mce-content-body p {
        margin: 0;
        margin-bottom: 16px;
    }
    
    .mce-content-body h3 {
        font-size: 18px;
        margin: 0;
        margin-bottom: 20px;
    }
    
    .mce-content-body h2 {
        font-size: 20px;
        margin: 0;
        margin-bottom: 20px;
    }
    
    .mce-content-body h4 {
        font-size: 16px;
        margin: 0;
        margin-bottom: 20px;
    }
    
    .mce-content-body h5 {
        font-size: 14px;
        margin: 0;
        margin-bottom: 20px;
    }
    
    .mce-content-body ul, ol {
        margin: 0;
        margin-bottom: 16px;
    }
    </style>

     @stack('css')
   </head>
   <!-- END: Head-->

   <!-- BEGIN: Body-->
   <body class="vertical-layout vertical-menu-modern 2-columns fixed-navbar hell
   

   menu-collapsed
   " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

    @include('admin.layouts.header')
    @include('admin.layouts.sidebar')

    

     <!-- BEGIN: Content-->
     <div class="app-content content">
       <div class="content-overlay"></div>
       <div class="content-wrapper">
         @yield('contents')
       </div>
     </div>
     <!-- END: Content-->


     @include('admin.layouts.footer')


     <!-- BEGIN: Vendor JS-->
     <script src="{{asset(assetLinkAdmin().'/app-assets/vendors/js/vendors.min.js')}}"></script>
     <!-- BEGIN Vendor JS-->

     <!-- BEGIN: Page Vendor JS-->
     <script src="{{asset(assetLinkAdmin().'/app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
     <!-- END: Page Vendor JS-->

     <!-- BEGIN: Theme JS-->
     <script src="{{asset(assetLinkAdmin().'/app-assets/js/core/app-menu.min.js')}}"></script>
     <script src="{{asset(assetLinkAdmin().'/app-assets/js/core/app.min.js')}}"></script>
     <script src="{{asset(assetLinkAdmin().'/app-assets/js/scripts/customizer.min.js')}}"></script>
     <!-- END: Theme JS-->
     
     <!-- Drag dropable data  -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="{{asset(assetLinkAdmin().'/app-assets/js/printThis.js')}}"></script>
    <!-- JavaScript Bundle with Popper -->
     <!-- BEGIN: Page JS-->
     <script src="{{asset(assetLinkAdmin().'/app-assets/js/tag-editor.js')}}"></script>
     <script src="{{asset(assetLinkAdmin().'/app-assets/js/scripts/forms/select/form-select2.min.js')}}"></script>
     <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
     <script src="{{asset('tinymce/tinymce.min.js')}}"></script>
     <!-- END: Page JS-->
     @stack('js')
     <script type="text/javascript">
         
      $( function() {
              $( "#sortable" ).sortable();
              $( "#sortable" ).disableSelection();
              $( ".sortable" ).sortable();
              $( ".sortable" ).disableSelection();
          } );
    </script>
     <script>
      $(document).ready(function(){
          
         

          
          tinymce.init({
            selector: 'textarea.tinyEditor',
            height: 300,
            menubar: false,
            statusbar: false,
            plugins: 'lists advlist image link fullscreen advcode code',
            toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright alignjustify |' + 
            'bullist numlist outdent advlist | link image | preview media fullscreen  | code |' +
            'forecolor backcolor emoticons',
            image_title: true,
            automatic_uploads: true,
            file_picker_types: 'image',
            file_picker_callback: function (cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.onchange = function () {
                  var file = this.files[0];
                  var reader = new FileReader();
                  reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                  };
                  reader.readAsDataURL(file);
                };
                input.click();
              },
            content_style: 'body{font-family:Helvetica,Arial,sans-serif; font-size:16px}'
        });
        
        
        
        

        $('#PrintAction').on("click", function () {
            $('.PrintAreaContact').printThis();
          });

        $('#PrintAction2').on("click", function () {
            $('.PrintAreaContact2').printThis();
          });
          
          // When a file is selected, update the image preview
        $(document).on('change','.profile-upload', function (e) {
            var input = e.target;
            var profiImage ='.'+$(this).data('imageshow');
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $(profiImage).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        });

         $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });

            $(document).on('click','.reloadPage',function(){

                location.reload();
                return true;

            });
          
          $(document).on('click','.showPassword',function(){
                $(this).toggleClass('active-show');
                if ($(this).hasClass('active-show')) {
                    $('input.password').prop('type','text');
                    $(this).empty().append('<i class="fa fa-eye"></i>');
                } else {
                    $('input.password').prop('type','password');
                    $(this).empty().append('<i class="fa fa-eye-slash"></i>');
                }
            });
           
           $(document).on('change','.paymentMethod',function(){
                  var id = $(this).val();
                  if(id==''){
                   $('.paymentOption').empty().append();
                  }
                  var url ='{{url('payments/filter')}}' + '/'+id;
                  $.get(url,function(data){
                    $('.paymentOption').empty().append(data.paymentData);
                  });   
            });


          $("#division").on("change", function(){
                var id = $(this).val();
                  if(id==''){
                   $('#district').empty().append('<option value="">No District</option>');
                   $('#city').empty().append('<option value="">No City</option>');
                  }
                  var url ='{{url('geo/filter')}}' + '/'+id;
                  $.get(url,function(data){
                    $('#district').empty().append(data.geoData);
                    $('#city').empty().append('<option value="">No City</option>');
                  });   
            });

            $("#district").on("change", function(){
                var id = $(this).val();
                  if(id==''){
                   $('#city').empty().append('<option value="">No City</option>');
                  }
                  var url ='{{url('geo/filter')}}' + '/'+id;
                  $.get(url,function(data){
                    $('#city').empty().append(data.geoData);  
                  });   
            });


            $('.mediaDelete').click(function(e){
                e.preventDefault();

              var url =$(this).attr('href');

              if(confirm("Are you sure you want to delete this?")){
                
                $.ajax({
                  url : url,
                  type:'GET',
                  cache: false,
                  contentType: false,
                  dataType: 'json',
                  beforeSend: function()
                  {
                    
                  },
                  complete: function()
                  {
                      
                  },
                  }).done(function (data) {
                     
                     location.reload(true);
                    
                  }).fail(function () {
                      alert('fail');
                  });
                  
              }else{
                  return false;
              }

            });
          
      });
    </script>

    <script type="text/javascript">
      ///Check Box Select With Count show

          $(function() {
            $('.checkCounter').text('0');
            var generallen = $("input[name='checkid[]']:checked").length;
            if (generallen > 0) {
              $(".checkCounter").text('(' + generallen + ')');
            } else {
              $(".checkCounter").text(' ');
            }
            
          })
          
          function updateCounter() {
            var len = $("input[name='checkid[]']:checked").length;
            if (len > 0) {
                $('.deleteBtnStatus').show();
              $(".checkCounter").text('(' + len + ')');
            } else {
                $('.deleteBtnStatus').hide();
              $(".checkCounter").text(' ');
            }
          }
          
            $(document).on("change","input[name='checkid[]']", function() {
              updateCounter();
            });

            $(document).on('click','#checkall',function() {
              var checked = $(this).prop('checked');
              $("input[name='checkid[]']").prop('checked', checked);
              $("input[name='deleteItems[]']").prop('checked', checked);
              updateCounter();
            });
        
        ///Check Box Select With Count show
      </script>

    
   </body>
   <!-- END: Body-->
 </html>