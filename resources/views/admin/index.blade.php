@extends('base')
@section('main')
<div style="padding: 15px;">
    <span class="layui-breadcrumb" lay-separator=">"><a>系统管理</a><a href="">管理员列表</a></span>
    <div style="margin-top: 20px">
    <button class="layui-btn" id="add">增加</button>
    <button class="layui-btn" id="del">批量删除</button>
    <div class="layui-input-inline" style="width: 300px;margin-left: 40%">
    	<label class="layui-form-label">管理员名</label>
        <div class="layui-input-inline">
            <input type="text" name="name" id="name" lay-verify="name" autocomplete="off" class="layui-input">
        </div>
    </div>
    <button class="layui-btn" id="query">查询</button>
    <table id="demo" lay-filter="test"></table>
</div>
@endsection
  
@section('script')
<script type="text/html" id="barDemo">
  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
</script>
<script>
layui.use('table', function(){
  var table = layui.table;
  var name = '';
  render(name);
  function render(name)
  {
  	//第一个实例
	table.render({
	  	id:'idTest',
	    elem: '#demo'
	    ,height: 500
	    ,url: '/admin/list' //数据接口
	    ,page: true //开启分页
	    ,where:{name:name}
	    ,limit:10
	    ,cols: [[ //表头
	    	{type: 'checkbox', fixed: 'left'}
	      	,{field: 'id', title: 'ID', width:80, sort: true, fixed: 'left', width:200}
	      	,{field: 'name', title: '用户名', width:200}
	      	,{field: 'locktime', title: '锁定时间', width:200}
	      	,{field: 'add_time', title: '创建时间', width:300}
	      	,{field: 'edit_time', title: '修改时间', width:300}
	      	,{fixed: 'right', title:'操作', toolbar: '#barDemo'}
	    ]]
	});
  }

  	$("#query").on('click', function(){
  		var name=$("#name").val();
  		render(name);
        
  	})


   //监听行工具事件
  table.on('tool(test)', function(obj){
    var data = obj.data;
    //console.log(obj)
    if(obj.event === 'del'){
      	layer.confirm('真的删除行么', function(index){
        	var id = obj.data.id;
        	$.ajax({
                type:"get",
                url:"del/"+id,
                dataType:'json', 
                data: {},
                success:function(res) {
                    if (res.code != 200)
                    {
                        layer.msg(res.msg)
                    } else {
                        layer.msg(res.msg);
                        location.reload()
                    }
                }
            })
      	});
    } else if(obj.event === 'edit'){
      	var id = obj.data.id;
      	var index = layer.open({
	  		title:'新增',
	  		area:["1200px", "600px"],
	  		type: 2,
		  	content: 'edit/' + id,
		});
    }
  });

  $("#add").on('click', function(){
  	var index = layer.open({
  		title:'新增',
  		area:["1200px", "600px"],
  		type: 2,
	  	content: 'add',
	});
  })


	$("#del").on('click', function(){
		var checkStatus = table.checkStatus('idTest').data; //idTest 即为基础参数 id 对应的值
		var ids = '';
		checkStatus.forEach((value) =>
		{
			ids = ids + '|' + value.id;
		})
		layer.confirm('真的删除行么', function(index){
        	$.ajax({
                type:"get",
                url:"del/"+ids,
                dataType:'json', 
                data: {},
                success:function(res) {
                    if (res.code != 200)
                    {
                        layer.msg(res.msg)
                    } else {
                        layer.msg(res.msg);
                        location.reload()
                    }
                }
            })
      	});
	});

});
</script>
@endsection