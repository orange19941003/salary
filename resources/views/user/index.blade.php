@extends('base')
@section('main')
<style>
  .layui-table-cell:has( > img) {
    height: 108px !important;
  }
</style>
<div style="padding: 15px;">
    <span class="layui-breadcrumb" lay-separator=">"><a>OA</a><a href="">员工列表</a></span>
    <div style="margin-top: 20px">
    <button class="layui-btn" id="add">增加</button>
    <button class="layui-btn" id="del">批量删除</button>
    <div class="layui-input-inline" style="width: 300px;margin-left:40%">
    	<label class="layui-form-label">员工名</label>
        <div class="layui-input-inline">
            <input type="text" name="name" id="name" lay-verify="name" autocomplete="off" class="layui-input">
        </div>
    </div>
    <button class="layui-btn" id="query">查询</button>
    <table id="demo" lay-filter="test"></table>

</div>
@endsection
  
@section('script')
<script type="text/html" id="addrres">
        <img src="http://chart.apis.google.com/chart?chs=100x100&cht=qr&chld=L|0&chl=@{{d.addrres}}" alt="QR code" style="width: 100px;height:100px;margin-top:10px"/>
</script>
<script type="text/html" id="barDemo">
  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
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
	    ,url: '/user/list' //数据接口
	    ,page: true //开启分页
	    ,where:{name:name}
	    ,limit:20
	    ,cols: [[ //表头
	    	{type: 'checkbox', fixed: 'left', style:"height:110px"}
	      	,{field: 'id', title: 'ID',sort: true, align: 'left', width:100, style:"height:110px"}
	      	,{field: 'name', title: '员工名', width:100}
	      	,{field: 'email', title: '邮箱', width:100}
	      	,{field: 'addrres', title: '发币地址', align:'center',width:200, templet: "#addrres", style:"height:110px", class:"addrres"}
	      	,{field: 'salary', title: '薪资(￥)', width:100}
	      	,{field: 'cny_to_usd_rate', title: '实时汇率', width:100}
	      	,{field: 'usd_salary', title: '薪资($)', width:100}
	      	,{field: 'salary_type_text', title: '计薪方式', width:100}
	      	,{field: 'created_at', title: '创建时间', width:150}
	      	,{field: 'updated_at', title: '修改时间', width:150}
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
	  		title:'修改',
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
                    if (res.code != 100)
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
    $("body").on('click', 'img', function(){
        var html = '<img src="'+ this.src +'"  style="width: 400px;height: 400px">';
        layer.open({
        type: 1, 
        area: ["400px", "400px"],
        title: false,
        content: html //这里content是一个普通的String
        });
    })
});
</script>
@endsection