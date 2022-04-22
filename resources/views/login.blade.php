@extends('layout.app')

@section('content')
    <head>
        <link href="/css/login.css" rel="stylesheet" >
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
                            <a class="nav-link font-weight-bold" href="/account">Account</a>
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

        <div class="login-box">
            <div class="title">
                <h2>Inloggen</h2>
            </div>
            <form method="POST" action="/login">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email">
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" id="password" placeholder="Wachtwoord" name="password">
                </div>

                <div class="form-group">
                    <button style="cursor:pointer" type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>

    </div>



@endsection
