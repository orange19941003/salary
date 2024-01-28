@extends('comm')
@section('main')
<meta name="csrf-token" content="{{ csrf_token() }}">
<form class="layui-form" action="">
    @csrf
    <div class="layui-form-item">
        <label class="layui-form-label">用户名</label>
        <div class="layui-input-block" style="width:50%;">
            <input type="text" value="{{$user->name}}" name="name" id="name"  autocomplete="off" placeholder="请输入" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">邮箱</label>
        <div class="layui-input-block" style="width:50%;">
            <input type="text" value="{{$user->email}}" name="email" id="email"  autocomplete="off" placeholder="请输入" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">发币地址</label>
        <div class="layui-input-block" style="width:50%;">
            <input type="text" value="{{$user->addrres}}" name="addrres" id="addrres"  autocomplete="off" placeholder="请输入" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">计薪方式</label>
        <div class="layui-input-inline" style="width:50%;">
            <input type="radio" name="salary_type" value="1" title="周薪" @if($user->salary_type == 1)checked="checked"@endif>
            <input type="radio" name="salary_type" value="2" title="时薪"  @if($user->salary_type == 2)checked="checked"@endif>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">工资(￥)：</label>
        <div class="layui-input-block" style="width:50%;">
            <input type="text"  value="{{$user->salary}}" name="salary" id="salary" autocomplete="off" placeholder="请输入" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button type="button" class="layui-btn" lay-submit="" lay-filter="demo1" id="demo1">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>
@endsection
@section('script')
    <script type="text/javascript">
        var form = layui.form,
            $ = layui.jquery;
        $("#demo1").on('click', function(){
            var name = $("#name").val();
            var _token = $("input[name='_token']").val();
            var email = $("#email").val();
            var addrres = $("#addrres").val();
            var salary_type = $("input[name='salary_type']:checked").val();
            var salary = $("#salary").val();
            $.ajax({
                type:"post",
                url:"",
                dataType:'json', 
                data: {name:name,_token:_token,email:email,addrres:addrres,salary_type:salary_type,salary:salary},
                success:function(res) {
                    if (res.code != 200)
                    {
                        layer.msg(res.msg)
                    } else {
                        layer.msg(res.msg);
                        parent.location.reload()
                    }
                }
            })
        })
    </script>
@endsection