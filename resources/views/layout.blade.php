<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>Home</title>
    <link rel="stylesheet" href="/bootstrap-5.3/css/bootstrap.min.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="starability-master/starability-css/starability-all.css">
    <link rel="stylesheet" href="/fontawesome-free-6.5.2-web/css/all.min.css">
    
    <script src="/jquery/dist/jquery.min.js"></script>
    <script src="/jquery/dist/jquery.js"></script>
    <link rel="stylesheet" href="/css/style.css">

</head>
<body>

     <nav class="navbar d-flex navbar-expand px-2  border-bottom justify-content-between">
        <!-- Button for sidebar toggle -->
            <button class="sidebar-toggle-btn" id="sidebarToggle">
            <i class="fas fa-bars"></i>
            </button>

        <div class="utility px-3 ">
            <span class="mx-3 "><a href="/" class="btn text-white" >Home</a></span>

            <span class="mx-3 "><a href="/register" class="btn text-white" >Register</a></span>
           
                            
        </div>
    
        
     </nav>

    @yield('content')

    




<script src="/bootstrap-5.3/js/bootstrap.bundle.min.js"></script>
  
<script src="/js/src.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script> -->

<x-toast></x-toast>

</body>