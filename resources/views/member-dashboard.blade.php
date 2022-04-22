@extends('layout.app')

@section('content')
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Groepslid toevoegen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    {{ Form::open(array('method'=>'POST', 'route' => ['members.store'])) }}

                    <div class="form-group">
                        {{ Form::label('name', 'Naam') }}
                        {{ Form::text('name', Input::old('name'), array('class' => 'form-control', 'placeholder' => 'Naam groepslid')) }}
                    </div>

                    <p>Standaard item</p>
                    <select class="form-select" name="standard_item" id="standard_item">
                        @foreach($items as $item)
                            <option id="{{$item->id}}" value="{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>

{{--                    {!! Form::select('category_id', $item_names, null, ['class' => 'form-select']) !!}--}}

                    <div class="form-group">
                        <input type="hidden" value="{{$group->id}}" name="group_id">
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">SLUITEN</button>
                    {{ Form::submit('TOEVOEGEN', array('class' => 'form-button'))}}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    <head>
        <link href="/css/member-dashboard.css" rel="stylesheet" >
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

        <div class="title" id="title">
            <h2>
                <button class="back-button">
                    <a href="{{ url('/groups') }}">
                        <span class="material-icons">arrow_back_ios</span>
                    </a>
                </button>
                {{$group->name}}
            </h2>

            <p>Beheer hier je groepsleden, of voeg nieuwe leden toe.</p>

            <div class="filter">

                <form action="{{ url('/members/filter', ['group' => $group->id])}}" method="post">
                    <input type="hidden" name="_method" value="POST" />
                    <input type="text" name="name" placeholder="Zoek een groepslid" />
                    {{ csrf_field() }}

                    <button type="submit">
                        <span class="material-icons">search</span>
                    </button>
                </form>
            </div>
            <div class="filter-badge" style="visibility: {{$visibility}}">
                <a href="{{url ('/group', $group->id)}}">
                    <span class="material-icons">close</span>
                </a>
                <p>Filter</p>
            </div>
        </div>

        <div class="user-container">
            @foreach($members as $member )

            <div class="user" >
                <div class="user-compact" tabindex="0" >
                    <div class="user-info">
                        <h3>{{$member->name}}</h3>
                        <p>{{$items->find($member->standard_item)->name}}</p>
                    </div>
                    <div class="buttons">
                        <div class="points">
                            <h4>€</h4>
                            <h3>{{number_format((float)$member->points_current, 2, '.', '')}}</h3>
                        </div>
                        <form action="/member/decrement" method="post">
                            @csrf
                            <input type="hidden" name="member" value="{{ $member->id }}">
                            <input type="hidden" name="group" value="{{ $group->id }}">
                            <input type="hidden" name="value" value={{$items->find($member->standard_item)->price}}>
                            <button type="submit">
                                <span class="material-icons">remove</span>
                            </button>
                        </form>

                        <form action="/member/increment" method="post">
                            @csrf
                            <input type="hidden" name="member" value="{{ $member->id }}">
                            <input type="hidden" name="group" value="{{ $group->id }}">
                            <input type="hidden" name="value" value={{$items->find($member->standard_item)->price}}>
                            <button type="submit">
                                <span class="material-icons">add</span>
                            </button>
                        </form>


                        <button id="collapse-button" class="collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#t-{{$member->name}}" aria-expanded="false">
                            <span class="material-icons">expand_more</span>
                        </button>
                    </div>
                </div>

                <div id="t-{{$member->name}}" class="user-expanded collapse">
                    <div class="buttons">

                        <button class="button" style="background-color: #366aa7" data-bs-toggle="modal" data-bs-target="#RoundModal-{{$member->id}}">
                            <span class="material-icons">autorenew</span>
                            <span>RONDJE</span>
                        </button>
                        <button class="button" style="background-color: #3c9a5d" data-bs-toggle="modal" data-bs-target="#PayModal-{{$member->id}}">
                            <span class="material-icons">check</span>
                            <span>AFBETALEN</span>
                        </button>
                        <button class="button" data-bs-toggle="modal" data-bs-target="#EditUserModal-{{$member->id}}">
                            <span class="material-icons">edit</span>
                        </button>
                    </div>

                    <div class="info-table">
                        @foreach($items as $item )
                        <div class="info-box">
                            <div class="title">
                                <h4>{{$item->name}}</h4>
                                <p>{{'€ ' . number_format((float)$item->price, 2, '.', '')}}</p>
                            </div>
                            <div class="buttons">
                                <form action="/member/decrement" method="post">
                                    @csrf
                                    <input type="hidden" name="member" value="{{ $member->id }}">
                                    <input type="hidden" name="value" value={{$item->price}}>
                                    <input type="hidden" name="group" value={{$group->id}}>
                                    <button>
                                        <span class="material-icons">remove</span>
                                    </button>
                                </form>

                                <form action="/member/increment" method="post">
                                    @csrf
                                    <input type="hidden" name="member" value="{{ $member->id }}">
                                    <input type="hidden" name="value" value={{$item->price}}>
                                    <input type="hidden" name="group" value={{$group->id}}>
                                    <button>
                                        <span class="material-icons">add</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>

            </div>

            <div class="modal fade" id="EditUserModal-{{$member->id}}" tabindex="-1" aria-labelledby="EditUserModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="EditUserModalLabel">Groepslid bewerken</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            {{ Form::open(array('method'=>'PUT', 'route' => ['members.update', $member->id])) }}

                            <div class="form-group">
                                {{ Form::label('name', 'Naam') }}
                                {{ Form::text('name', $member->name, array('class' => 'form-control', 'placeholder' => $member->name)) }}
                            </div>

                            <p>Standaard item</p>
                            <select class="form-select" name="standard_item" id="standard_item">
                                @foreach($items as $item)
                                    <option id="{{$item->id}}" value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">SLUITEN</button>
                            {{ Form::submit('AANPASSEN', array('class' => 'form-button'))}}
                            {{ Form::close() }}

                            <form action="{{ route('members.destroy', $member->id) }}" method="post">
                                <input type="hidden" name="_method" value="DELETE" />
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <input type="submit" class="delete-button" value="Verwijder groepslid" />
                            </form>

                        </div>
                    </div>
                </div>
            </div>

                <div class="modal fade" id="RoundModal-{{$member->id}}" tabindex="-1" aria-labelledby="RoundModal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{url('/member/' . $member->id . '/round')}}" method="post">
                                @csrf
                                <div class="modal-header">
                                    <h5>Rondje</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="amount-input">
                                        <label for="amount">Aantal personen</label>
                                        <input id="amount" type="number" step="1" name="amount" class="form-control" value="{{$members->count()}}">
                                        <input type="hidden" name="group" value={{$group->id}}>
                                        <label for="standard_item">Item</label>
                                        <select class="form-select" name="item" id="standard_item">
                                            @foreach($items as $item)
                                                <option id="{{$item->id}}" value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">SLUITEN</button>
                                    <button type="submit" class="form-button">OPSLAAN</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            <div class="modal fade" id="PayModal-{{$member->id}}" tabindex="-1" aria-labelledby="PayModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{url('/member/' . $member->id . '/pay')}}" method="post" novalidate>
                        @csrf
                        <div class="modal-header">
                            <h5>Afbetalen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="amount-input">
                                <label for="amount">Hoeveelheid</label>
                                <input id="amount" type="number" step="1" name="amount" class="form-control" value="{{number_format((float)$member->points_current, 2, '.', '')}}">
                                <input type="hidden" name="group" value={{$group->id}}>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">SLUITEN</button>
                            <button type="submit" class="form-button" >AFBETALEN</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            @endforeach
        </div>

        <div class="add-user-button">
            <button data-bs-toggle="modal" data-bs-target="#addUserModal">
                <span class="material-icons">person_add</span>
            </button>
        </div>

    </div>


@endsection
