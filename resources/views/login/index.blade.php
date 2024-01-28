<!DOCTYPE html>
<html lang="en">
<head>
    <title>工资后台</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="baidu-site-verification" content="">
    <meta name="google-site-verification" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/home/base.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home/index.css') }}" rel="stylesheet">
    <link href="{{ asset('css/home/m.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/home/auth.css') }}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="{{ asset('js/home/modernizr.js') }}"></script>
    <![endif]-->
    <link rel="stylesheet" href="{{ asset('static/css/layui.css') }}">
    <script src="{{asset('static/laydate/laydate.js')}}"></script>
    <script src="{{asset('static/layui.js')}}"></script>
    <script type="text/javascript" src="{{asset('static/layui.all.js')}}"></script>
    <style>
        header {
            color: #FFF;
            position: fixed;
            top: 0;
            z-index: 100;
        }
        .pics a img:hover {
            transition: all 1s;
            transform: scale(1.2)
        }
        .captcha{
            margin-bottom: 20px;
        }
    </style>
</head>

<body id="body_app">
<header>
    <div class="tophead">
        <h1>
        <div class="logo">
            <a href="/" title="工资后台">
                <img src="/images/config/avatar.jpg"
                     style="width: 40px;height: 40px; border-radius: 20px;margin-right: 10px;" alt="恭喜发财"
                     title="工资后台">
            </a>
           <a href="/" title="工资后台">工资后台</a>
        </div>
        </h1>
        <div id="mnav">
            <h2><span class="navicon"></span></h2>
            <ul>
                <li><a href="/" title="工资后台">首页</a></li>
            </ul>
        </div>
        <nav class="topnav" id="topnav">
            <ul>
                <li><a href="/" title="工资后台" class="pc_home" @if(request()->path() === '/') id="topnav_current" @endif >首页</a></li>
            </ul>
        </nav>
    </div>
</header>
<body class="layui-layout-body">
    <style>
        .blogsbox {
            width: 100%;
        }

        .blogsbox {
            text-align: center;
        }

        .btn-login {
            cursor: pointer;
        }
    </style>
    <article>
        <div style="width: 100%;height: 76px;"></div>
        <div class="blogsbox">
            <div id="content">
                <form class="layui-form layui-form-pane" method="post" action="">
                    <div class="login-header">
                        欢迎登录
                    </div>
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <div class="layui-form-item">
                        <label class="layui-form-label">账号</label>
                        <div class="layui-input-block">
                            <input type="text" name="name" id="name" value="" required lay-verify="account" placeholder="请输入账号"
                                   autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">密码</label>
                        <div class="layui-input-block">
                            <input type="password" name="password" id="pwd" required lay-verify="required" placeholder="请输入密码"
                                   autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="login-button-box">
                        <button type="button" class="btn-login" id="submit">开始登录</button>
                    </div>
                </form>
            </div>
        </div>
    </article>
</body>
</html>
    <script>
        layui.use('element', function(){
          var element = layui.element;
          
        });
        layui.use('layer', function(){
        var layer = layui.layer;
        });
        var $ = layui.$;
        layui.use('form', function(){
            var form = layui.form; 
            form.render();
        }); 

        $("#submit").on('click', function(){
            var name = $("#name").val();
            var pwd = $("#pwd").val();
            var captcha = $("#captcha").val();
            var _token = $("input[name='_token']").val();
            $.ajax({
                type:"post",
                url:"",
                dataType:'json', 
                data: {name:name,pwd:pwd,_token:_token},
                success:function(res) {
                    if (!res.code)
                    {
                        layer.msg(res.message)
                    }
                    if (res.code != 200)
                    {
                        $("#captcha_src_class").click();
                        layer.msg(res.msg)
                    } else {
                        layer.msg(res.msg);
                        window.location.href = "/index";
                    }
                }
            })
        })
    </script>
