<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
<meta name="viewport" content="width=device-width, initial-scale=1"> 
<title>注册</title>
<link rel="stylesheet" type="text/css" href="/static/css/normalize.css" />
<link rel="stylesheet" type="text/css" href="/static/css/demo.css" />
  <link rel="stylesheet" href="static/css/layui.css" media="all"/>
    <link rel="stylesheet" href="/static/css/login.css" media="all"/>
<!--必要样式-->
<link rel="stylesheet" type="text/css" href="/static/css/component.css" />
<!-- // --><link rel="stylesheet" type="text/css" href="/static/image/demo-1-bg.jpg" />
<!--[if IE]>
<script src="js/html5.js"></script>
<![endif]-->
</head>
<body>
  <!-- 表单提示错误信息 手册第321页-322页-->
    <!-- @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif -->
    <style>
      /* 覆盖原框架样式 */
      .layui-elem-quote{background-color: inherit!important;}
      .layui-input, .layui-select, .layui-textarea{background-color: inherit; padding-left: 30px;}
    </style>
<div class="alert alert-danger"></div>
<div class="container demo-1">
  <div class="content">
    <div id="large-header" class="large-header">
      <canvas id="demo-canvas"></canvas>
      <div class="logo_box">
        <h3>销售后台注册</h3>
        <form  action="{{url('edit')}}" method="get">
          <div class="layui-col-sm12 layui-col-md12">
            <div class="layui-form-item">
              <input type="text" name="uname" lay-verify="required|userName" autocomplete="off" placeholder="账号" class="layui-input">
              <i class="layui-icon layui-icon-username zyl_lofo_icon"></i>
              <b><font color=red>{{session('msge')}}</font></b>
              <b><font color=red>{{session('msga')}}</font></b>
            </div>
          </div>
          <div class="layui-col-sm12 layui-col-md12">
            <div class="layui-form-item">
              <input type="password" name="upwd" lay-verify="required|pass" autocomplete="off" placeholder="密码" class="layui-input">
              <i class="layui-icon layui-icon-password zyl_lofo_icon"></i>
               <b><font color=red>{{session('msg')}}</font></b>
            </div>
          </div>
          <div class="layui-col-sm12 layui-col-md12">
            <div class="layui-form-item">
            <select name="upd" id="">
              <option value="">请选择</option>
              <option value="1">业务员</option>
              <option value="2">系统管理员</option>
              <option value="3">总管</option>
            </select>
            <b><font color=red>{{session('msgs')}}</font></b>
            </div>
          </div>
      
          <div class="layui-col-sm12 layui-col-md12">
           <input class="layui-btn layui-btn-fluid" type="submit" value="注册"><br><hr>
            <a href="{{url('/')}}" class="layui-btn layui-btn-fluid" lay-submit="" lay-filter="demo1">已有账号？返回登陆</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div><!-- /container -->
    <script src="/static/js/TweenLite.min.js"></script>
    <script src="/static/js/EasePack.min.js"></script>
    <script src="/static/js/rAF.js"></script>
    <script src="/static/js/demo-1.js"></script>

    <!-- Jquery Js -->
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <!-- Layui Js -->
    <script type="text/javascript" src="/static/js/layui.js"></script>
    <!-- Jqarticle Js -->
    <script type="text/javascript" src="/static/js/jparticle.min.js"></script>
    <!-- ZylVerificationCode Js-->
    <script type="text/javascript" src="/static/js/zylVerificationCode.js"></script>
  </body>
</html>
