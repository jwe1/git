<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Bootstrap 101 Template</title>

    <!-- Bootstrap -->
    <link href="/Public/Wechat/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/Wechat/css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .main{margin-bottom: 60px;}
        .indexLabel{padding: 10px 0; margin: 10px 0 0; color: #fff;}
    </style>
</head>
<body>
<div class="main">
    <!--导航部分-->
    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container-fluid text-center">
            <div class="col-xs-3">
                <p class="navbar-text"><a href="<?php echo U('index');?>" class="navbar-link">首页</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="<?php echo U('service');?>" class="navbar-link">服务</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="<?php echo U('faxian');?>" class="navbar-link">发现</a></p>
            </div>
            <div class="col-xs-3">
                <p class="navbar-text"><a href="<?php echo U('my');?>" class="navbar-link">我的</a></p>
            </div>
        </div>
    </nav>
    <!--导航结束-->

    <div class="container-fluid content_list">
        <?php foreach($lists as $art):?>
            <div class="row noticeList">
                <div class="col-xs-2">
                    <a href="<?php echo U('xq_activity_detail',['id'=>$art['id']]);?>">
                    <img class="noticeImg" src="<?=$art['path']?>" style="width:180px"/></a>
                </div>
                <div class="col-xs-10">

                    <p class="title"><a href="<?php echo U('xq_activity_detail',['id'=>$art['id']]);?>" > <?=$art['title']?></a></p>
                    <p class="intro"><?=$art['description']?></p>
                    <p class="info">浏览: <?=$art['view']?> <span class="pull-right"><?=date('Y-m-d',$art['create_time'])?></span> </p>
                </div>
            </div>
        <?php endforeach;?>
    </div>
    <div class="text-center">
        <button type="button" class="btn btn-info ajax-page">获取跟多~~~</button>
    </div>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/Public/Wechat/jquery-1.11.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/Public/Wechat/bootstrap/js/bootstrap.min.js"></script>

<script>
    var p =1;
    $('.ajax-page').click(function(){
        p++;
        var html ='';
        $.getJSON("/wechat.php/Wechat/Index/xq_activity/p/"+p,function(data){
            if(data.length != 0){
               /* 获取到的数据追加*/
               $(data).each(function(){
                   html += '<div class="row noticeList">\
                    <div class="col-xs-2">\
                    <a href="/wechat.php/Wechat/Index/xq_activity_detail/id/'+p+'.html">\
                    <img class="noticeImg" src="'+this.path+'" style="width:180px"></a>\
                    </div>\
                    <div class="col-xs-10">\
                    <p class="title"><a href="/wechat.php/Wechat/Index/xq_activity_detail/id/'+p+'.html"> '+this.title+'</a></p>\
                    <p class="intro">'+this.description+'</p>\
                    <p class="info">浏览: '+this.view+' <span class="pull-right">2017-07-08</span> </p>\
                    </div>\
                    </div>';
               });
                $('.content_list').append(html);
            }else{
                alert('没有更多数据');
                $('.ajax-page').remove();
            }
        })

    });

</script>
</body>
</html>