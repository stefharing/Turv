@extends('layout.app')

@section('content')

    <head>
        <link href="/css/register.css" rel="stylesheet" >
    </head>

    <div class="page">
        <div class="nav">
            <div class="logo">
                <h3 onClick="document.getElementById('title').scrollIntoView();">Turv.</h3>
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

        <div class="register-box">
            <div class="title">
                <h2>Registreer</h2>
            </div>
            <form method="POST" action="/register">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="text" class="form-control" id="name" placeholder="Gebruikersnaam" name="name">
                </div>

                <div class="form-group">
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email">
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" id="password" placeholder="Wachtwoord" name="password">
                </div>

                <div class="form-group">
                    <input type="number" class="form-control" id="age" placeholder="Leeftijd" name="age">
                </div>

                <div class="form-group">
                    <button style="cursor:pointer" type="submit" class="btn btn-primary">Registreer</button>
                </div>
            </form>
        </div>



    </div>
@endsection


