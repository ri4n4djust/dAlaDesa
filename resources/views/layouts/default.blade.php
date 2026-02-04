
<!DOCTYPE html>
<html>
<head>
  @include('includes.head')
</head>
<body class="hold-transition fixed skin-blue sidebar-mini sidebar-collapse">
<div class="wrapper">
  
<header class="main-header">
  @include('includes.headmenu')
</header>
<aside class="main-sidebar">
  @include('includes.sidemenu')
</aside>
<div class="content-wrapper">
  @yield('content')
</div>
<footer class="main-footer">
  @include('includes.footer')
</footer>

<div class="control-sidebar-bg"></div>
</div>
@include('includes.footerjs')
</body>
</html>
