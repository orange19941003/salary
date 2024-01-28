@extends('base')
@section('main')
<style>
  .layui-table-cell:has( > img) {
    height: 108px !important;
  }
</style>
<div style="padding: 15px;">
    <span class="layui-breadcrumb" lay-separator=">"><a>OA</a><a href="">工资发放列表</a></span>
    <div style="margin-top: 20px">
    <button class="layui-btn" id="add">增加</button>
    <button class="layui-btn" id="del">批量删除</button>
    <form class="layui-form" action="" style="width: 400px;margin-left: 30%;">
      <div class="layui-input-inline" style="margin-top:-70px">
        <label class="layui-form-label">员工</label>
        <div class="layui-input-block">
          <select name="user_id" id="user_id" lay-verify="">
            <option value="0">请选择</option>
            @foreach($users as $user)
            <option value="{{$user->id}}" @if($user_id == $user->id)selected="selected"@endif>{{$user->name}}</option>
            @endforeach
          </select>  
        </div>
      </div>
      <button class="layui-btn" id="query" style="margin-top:-70px">查询</button>
    </form>
    <table id="demo" lay-filter="test"></table>

</div>
@endsection
  
@section('script')
<script type="text/html" id="addrres">
        <img src="http://chart.apis.google.com/chart?chs=100x100&cht=qr&chld=L|0&chl=@{{d.addrres}}" alt="QR code" style="width: 100px;height:100px;margin-top:10px"/>
</script>
<script type="text/html" id="barDemo">
  <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
</script>
<script>
layui.use('table', function(){
  var table = layui.table;
  var user_id = '{{$user_id}}';
  render(user_id);
  function render(user_id)
  {
  	//第一个实例
	table.render({
	  	id:'idTest',
	    elem: '#demo'
	    ,height: 500
	    ,url: 'list' //数据接口
	    ,page: true //开启分页
	    ,where:{user_id:user_id}
	    ,limit:20
	    ,cols: [[ //表头
	    	  {type: 'checkbox', style:"height:110px"}
	      	,{title:'操作', toolbar: '#barDemo', with:200}
	      	,{field: 'id', title: 'ID',sort: true, align: 'left', width:100, style:"height:110px"}
	      	,{field: 'name', title: '员工名', width:100}
	      	,{field: 'amount', title: '薪水（￥）', width:100}
	      	,{field: 'cny_to_usd_rate', title: '汇率', width:100}
	      	,{field: 'usd_salary', title: '薪水（$）', width:100}
	      	,{field: 'addrres', title: '发币地址', align:'center',width:200, templet: "#addrres", style:"height:110px", class:"addrres"}
	      	,{field: 'start_date', title: '该周开始时间', width:100}
	      	,{field: 'end_date', title: '该周结束时间', width:100}
	      	,{field: 'created_at', title: '创建时间', width:150}
	      	,{field: 'updated_at', title: '修改时间', width:150}
	    ]]
	});
  }

  	// $("#query").on('click', function(){
  	// 	var user_id=$("#user_id").val();
  	// 	render(user_id);
        
  	// })


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