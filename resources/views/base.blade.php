<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>工资后台</title>
    <link rel="stylesheet" href="{{ asset('static/css/layui.css') . '?version=' . config('app.version')}}">
    <script src="{{asset('static/laydate/laydate.js') . '?version=' . config('app.version')}}"></script>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">工资后台</div>
        <!-- 头部区域（可配合layui已有的水平导航） -->
        <ul class="layui-nav layui-layout-left">
          <li class="layui-nav-item"><a href="/salary/index">工资发放</a></li>
        </ul>
        <ul class="layui-nav layui-layout-right">
          <li class="layui-nav-item">
            <a href="javascript:;">
              <img src="{{ asset('images/config/admin.gif') . '?version=' . config('app.version') }}" class="layui-nav-img">
              {{session('admin_name', 'admin')}}
            </a>
            <dl class="layui-nav-child">
              <dd><a href="">后台用户</a></dd>
              <dd><a href="" >首页</a></dd>
            </dl>
          </li>
          <li class="layui-nav-item"><a href="/out">撤退</a></li>
        </ul>
    </div>
  
  <div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
      <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
      <ul class="layui-nav layui-nav-tree"  lay-filter="test">
            <li class="layui-nav-item layui-nav-itemed">
              <a class="" href="javascript:;">
                  系统管理
              </a>
              <dl class="layui-nav-child" >
                <dd><a href="/admin/index">管理员管理</a></dd>
              </dl>
            </li>
            <li class="layui-nav-item layui-nav-itemed">
              <a class="" href="javascript:;">
                  OA
              </a>
              <dl class="layui-nav-child" >
                <dd><a href="/user/index">员工管理</a></dd>
              </dl>
              <dl class="layui-nav-child" >
                <dd><a href="/salary/index">工资发放记录</a></dd>
              </dl>
            </li>
      </ul>
    </div>
  </div>

  <div class="layui-body">
    <!-- 内容主体区域 -->
  @section('main')
  @show
  </div>

   <div class="layui-footer">
    <!-- 底部固定区域 -->
    © layui.com - 底部固定区域
  	</div>
</div>
<script src="{{asset('static/layui.js')}}"></script>
<script type="text/javascript" src="{{asset('static/layui.all.js') . '?version=' . config('app.version')}}"></script>
<script>
//JavaScript代码区域
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
</script>
@section('script')
@show
</body>
</html>