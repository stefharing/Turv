@extends('layout.app')

@section('content')
    <head>
        <link href="/css/welcome.css" rel="stylesheet" >
    </head>

    <div class="page">
        <div class="nav">
            <div class="logo">
                <h3 onClick="document.getElementById('welcome').scrollIntoView();">Turv.</h3>
            </div>
            <div class="links">
                <ul>
                    @if( auth()->check() )
                        <li >
                            <a class="nav-link font-weight-bold" href="#">Account</a>
                        </li>
                        <li >
                            <a class="nav-link" href="/logout">Uitloggen</a>
                        </li>
                    @else
                        <li >
                            <a class="nav-link" href="/login">Log In</a>
                        </li>
                        <li >
                            <a class="nav-link" href="/register">Registreer</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="welcome" id="welcome">
            <div id="title" class="title">
                <h2>Welkom bij Turv.</h2>
            </div>
            <div class="buttons">
                <p onClick="document.getElementById('info').scrollIntoView();">ONTDEK TURV.</p>
                    <a href="{{ url('/register') }}">
                        <button>REGISTREER</button>
                    </a>
            </div>
        </div>
        <div class="info" id="info">
            <h2>Dit is Turv.</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus accusantium amet aperiam cumque delectus eos eveniet expedita itaque,
                laborum magni neque optio quas, qui quidem reiciendis rerum suscipit tempora vitae! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus accusantium amet aperiam cumque delectus eos eveniet expedita itaque,
                laborum magni neque optio quas, qui quidem reiciendis rerum suscipit tempora vitae! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus accusantium amet aperiam cumque delectus eos eveniet expedita itaque,
                laborum magni neque optio quas, qui quidem reiciendis rerum suscipit tempora vitae!</p>
            <h3>/////</h3>
        </div>
    </div>
@endsection
