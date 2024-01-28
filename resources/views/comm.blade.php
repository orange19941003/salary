<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>工资后台</title>
  <link rel="stylesheet" href="{{ asset('static/css/layui.css') }}">
  <script src="{{asset('static/laydate/laydate.js')}}"></script>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
 
  
  <div class="layui-body">
    <!-- 内容主体区域 -->
  @section('main')
  @show
  </div>

  
</div>
<script src="{{asset('static/layui.js')}}"></script>
<script type="text/javascript" src="{{asset('static/layui.all.js')}}"></script>
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