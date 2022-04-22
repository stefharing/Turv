@extends('layout.app')

@section('content')
    <head>
        <link href="/css/account.css" rel="stylesheet" >
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
                            <a class="nav-link font-weight-bold" href="/groups">Groepen</a>
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

        <div class="content">
            <div class="title">
                <h2>Hallo, {{$user->name}}</h2>
                <p>Beheer hier je account gegevens</p>
            </div>
            <div class="form-box">
                <h4>Profiel</h4>
                <form action="">
                    <label for="name">Naam</label>
                    <input id="name" type="text" class="form-control" value="{{$user->name}}">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" value="{{$user->email}}">

                    <div class="buttons">
                        <button class="btn form-button">OPSLAAN</button>
                    </div>
                </form>

            </div>
            <div class="form-box">
                <h4>Verander wachtwoord</h4>
                <form action="">
                    <label for="password">Oud wachtwoord</label>
                    <input id="name" type="text" class="form-control">
                    <label for="password">Nieuw wachtwoord</label>
                    <input id="email" type="email" class="form-control">

                    <div class="buttons">
                        <button class="btn form-button">AANPASSEN</button>
                    </div>
                </form>

            </div>
        </div>



    </div>



@endsection
