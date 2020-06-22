@extends('layouts.app')

@section('styles')
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">

@stop

@section('scripts')
    <!-- Scripts -->
    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>

@stop


@section('content')
<div class="home">
    <nav class="navbar transparent navbar-expand-lg ">
        <a class="navbar-brand" href="#"><img src="images/logo.png" style="left: 200px;
width: 114px;
height: 100px;"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav" >
                <li class="nav-item active">
                    <a class="nav-link" href="#">Accounts</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Reviews</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        More
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
            </div>
        </div>
    </nav>
    <div >
        <p>All you need for <br>League of Legends</p>
    </div>
    <div>
        Lorem ipsum
    </div>
    <div >
        asdasd
    </div>

</div>
@stop
