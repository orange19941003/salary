@extends('comm')
@section('main')
<meta name="csrf-token" content="{{ csrf_token() }}">
<form class="layui-form" action="">
    @csrf
    <div class="layui-form-item">
        <label class="layui-form-label">用户</label>
        <div class="layui-input-block">
            <select name="user_id" id="user_id" lay-filter="user_id">
                <option value="0">请选择</option>
                @foreach($users as $user)
                <option value="{{$user->id . '|' . $user->addrres}}"  @if($salary->user_id == $user->id)selected="selected"@endif>{{$user->name}}</option>
                @endforeach
                </select>  
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">本次发薪工作周期：</label>
        <div class="layui-input-block" style="width:50%;">
            <input type="text" value="{{$salary->salary_date}}" class="layui-input" id="salary_date" value="" placeholder="">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">工资(￥)：</label>
        <div class="layui-input-block" style="width:50%;">
            <input type="text" value="{{$salary->amount}}" name="amount" id="amount" autocomplete="off" placeholder="请输入" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">汇率</label>
        <div class="layui-input-block" style="width:50%;">
            <input type="text" value="{{$salary->cny_to_usd_rate}}" name="cny_to_usd_rate" id="cny_to_usd_rate"  autocomplete="off" placeholder="请输入" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">工资($)：</label>
        <div class="layui-input-block" style="width:50%;">
            <input type="text" value="{{$salary->usd_salary}}" name="usd_salary" id="usd_salary" autocomplete="off" placeholder="请输入" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">发币地址</label>
        <div class="layui-input-block" id="address" style="width:50%;">
            <img src="http://chart.apis.google.com/chart?chs=100x100&cht=qr&chld=L|0&chl={{$salary->addrres}}" alt="QR code" style="width: 100px;height:100px;margin-top:10px"/>
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
        layui.use('form', function () {
            var form = layui.form;
            form.on('select(user_id)', function(data){
                var val = data.value
                var data = val.split('|')
                var user_id = data[0]
                var address = data[1]
                if (user_id != 0)
                {
                    var html = '<img src="http://chart.apis.google.com/chart?chs=100x100&cht=qr&chld=L|0&chl=' + address + '" alt="QR code" style="width: 100px;height:100px;margin-top:10px"/>'
                    $("#address").html(html)
                }
                else
                {
                    $("#address").html('')
                }
            })
        })
        $("#demo1").on('click', function(){
            var user_id = $("#user_id").val();
            var data = user_id.split('|')
            user_id = data[0]
            var _token = $("input[name='_token']").val();
            var amount = $("#amount").val();
            var cny_to_usd_rate = $("#cny_to_usd_rate").val();
            var usd_salary = $("#usd_salary").val();
            var salary_date = $("#salary_date").val();
            $.ajax({
                type:"post",
                url:"",
                dataType:'json', 
                data: {user_id:user_id,_token:_token,amount:amount,cny_to_usd_rate:cny_to_usd_rate,usd_salary:usd_salary,salary_date:salary_date},
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
      
        $('#amount, #cny_to_usd_rate').blur(function(){
            var total = 0.00;
            var amount = $("#amount").val()
            var cny_to_usd_rate = $("#cny_to_usd_rate").val()
            amount = parseFloat(amount)
            total = amount / cny_to_usd_rate
            total = total.toFixed(2);
            $("#usd_salary").val(total)
        });
        layui.use('laydate', function(){
            var laydate = layui.laydate;

            //日期范围
            var dd= laydate.render({
                elem: '#salary_date'
                ,type: 'date'
                ,range: true
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
    </script>
@endsection