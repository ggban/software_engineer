<?php  ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/plain; charset=UTF-8"/>
        
        <title>後台系統</title>
        <?php $this->load->view('script_lib')?>

        <script>
        $(document).ready(function() {
            $(".sub-li a").each(function( ){
               // console.log($(this).attr('href'));
                //console.log(window.location.href);
                if($(this).attr('href')==window.location.href)
                {
                    $(this).parents('.collapse').collapse('toggle');
                     $(this).parents('.main-li').find("i").toggleClass("glyphicon-chevron-right glyphicon-chevron-down");
                }

            });



        });

       
        </script>
        <style>
        .sub-li{
           left: 10px
        }
        input:read-only {
            background-color: #BDBDBD;
        }
        .nopadding {
         
           margin: 0 !important;
           padding-right: 0 !important;
            padding-left: 0 !important;
        }

        </style>
    </head>
    <body>

    <!-- header -->
    <div id="top-nav" class="navbar navbar-inverse navbar-static-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url('formController')?>">後台管理系統</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle" role="button" data-toggle="dropdown" href="#"><i class="glyphicon glyphicon-user"></i> <?php echo $this->session->userdata('display_name')?> <span class="caret"></span></a>
                        <ul id="g-account-menu" class="dropdown-menu" role="menu">
                            <li><a href="<?php echo base_url('accountController/change_passwd')?>">修改密碼</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo base_url('login/logout')?>"><i class="glyphicon glyphicon-lock"></i> 登出</a></li>
                </ul>
            </div>
        </div>
        <!-- /container -->
    </div>
    <!-- /Header -->

    <!-- Main -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <!-- Left column -->
                <a href="#"><strong><i class="glyphicon glyphicon-wrench"></i> 功能</strong></a>

                <hr>
                
                <ul class="nav nav-stacked">
                    
                  <!--  <li class="nav-header main-li"> <a  data-toggle="collapse" data-target="#menu3"> 最新消息 <i class="glyphicon glyphicon-chevron-right"></i></a>

                        <ul class="nav nav-stacked collapse" id="menu3">
                            <li class='sub-li'><a href="<?php echo base_url('admin/news_table')?>">消息列表</a>
                            </li>
                         

                        </ul>
                    </li>-->

                    <li class="nav-header main-li"> <a  data-toggle="collapse" data-target="#menu1"> 前台功能 <i class="glyphicon glyphicon-chevron-right"></i></a>

                        <ul class="nav nav-stacked collapse" id="menu1">
                            

                                <li class="sub-li"> 
                                    <a  href="<?php echo base_url('formController/form_menu')?>"> 表單特區 </a>
                                </li>
                            
                        </ul>
                    </li>

                <?php if($this->session->userdata('group_index')==1){?>
                    <li class="nav-header main-li"> <a  data-toggle="collapse" data-target="#menu2"> 進階功能 <i class="glyphicon glyphicon-chevron-right"></i></a>
                        <ul class="nav nav-stacked collapse" id="menu2">


                            
                                <li class='sub-li'>
                                    <a  href="<?php echo base_url('accountController/group_table')?>"> 群組列表 </a>
                                   <!-- <a  href="#"> 異動記錄 </a>-->
                                </li>
                                <li class='sub-li'>
                                    <a  href="<?php echo base_url('accountController/users_table')?>"> 使用者列表 </a>
                                   <!-- <a  href="#"> 異動記錄 </a>-->
                                </li> 
                                    
                                
                            

                        </ul>
                    </li>
                <?php } ?>
                </ul>

                <hr>

               

              
            </div>
            <!-- /col-3 -->
            <div class="col-sm-10" id='contnet'>
                
                <a href="#"><strong> <?php echo $title?></strong></a>
                <path>
                <hr>
                <?php 
                if(isset($content))
                echo $content;
                ?>
            </div>
            <!--/col-span-9-->
        </div>
    </div>
    <!-- /Main -->

    <footer class="text-center"></footer>


<!-- /.modal -->
        <script>
    $(".alert").addClass("in").fadeOut(4500);

/* swap open/close side menu icons */
    $('[data-toggle=collapse]').click(function(){
        // toggle icon
        $(this).find("i").toggleClass("glyphicon-chevron-right glyphicon-chevron-down");
    });
        </script>
</body>
</html>