@extends('layout.app')

@section('content')
    <head>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    </head>

    <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Groep toevoegen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                        <form action="{{ url('/groups') }}" method="POST">
                            @csrf

                            <p>Naam</p>
                            <input type="text" name="name" placeholder="groepnaam" class="form-control"/>
                            <input type="hidden" name="user_id" value="{{auth()->user()->id}}"/>

                            <p>Items</p>
                            <table class="table" id="dynamicTable">
                                <tr>
                                    <td><input type="text" name="addmore[0][name]" placeholder="Naam" class="form-control" /></td>
                                    <td><input type="number" step=".01" name="addmore[0][price]" placeholder="Prijs" class="form-control" /></td>
                                    <td><button type="button" name="add" id="add" class="btn btn-success">
                                            <span class="material-icons">add</span>
                                        </button></td>
                                </tr>
                            </table>

                            <div class="modal-footer">
                                <button type="button" class="form-button" style="background-color: grey" data-bs-dismiss="modal">SLUITEN</button>
                                <button type="submit" class="form-button">TOEVOEGEN</button>
                            </div>
                        </form>
                    </div>

                </div>
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">SLUITEN</button>--}}
{{--                    {{ Form::submit('TOEVOEGEN', array('class' => 'form-button'))}}--}}
{{--                    {{ Form::close() }}--}}
{{--                </div>--}}
            </div>
        </div>
    </div>

    <head>
        <link href="/css/group-dashboard.css" rel="stylesheet" >
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
            <h2>Hallo, {{ auth()->user()->name }}</h2>
            <p>Beheer hier je groepen, of maak een nieuwe groep aan.</p>

            <div class="filter">

                <form action="{{ url('/groups/filter')}}" method="post">
                    <input type="hidden" name="_method" value="POST" />
                    <input type="text" name="name" placeholder="Zoek een groep" />
                    {{ csrf_field() }}

                    <button type="submit">
                        <span class="material-icons">search</span>
                    </button>
                </form>
            </div>
            <div class="filter-badge" style="visibility: {{$visibility}}">
                <a href="{{url ('/groups')}}">
                    <span class="material-icons">close</span>
                </a>
                <p>Filter</p>
            </div>

        <div class="group-container">
            @foreach($groups as $group )


                <div class="group">
                    <div class="group-content">
                        <div class="group-icon">
                            <span class="material-icons">group</span>
                            <button class="button" data-bs-toggle="modal" data-bs-target="#EditUserModal-{{$group->id}}">
                                <span class="material-icons">edit</span>
                            </button>
                        </div>
                        <div class="group-info">
                            <h3>{{$group['name']}}</h3>
                            <p>{{$group->members->count()}}</p>
                        </div>
                    </div>
                    <a href="{{ url('/group/' . $group->id) }}"></a>
                </div>


                <div class="modal fade" id="EditUserModal-{{$group->id}}" tabindex="-1" aria-labelledby="EditUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="EditUserModalLabel">Groep bewerken</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                {{ Form::open(array('method'=>'PUT', 'route' => ['groups.update', $group->id])) }}

                                <div class="form-group">
                                    {{ Form::label('name', 'Naam') }}
                                    {{ Form::text('name', $group->name, array('class' => 'form-control', 'placeholder' => $group->name)) }}
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">SLUITEN</button>
                                {{ Form::submit('AANPASSEN', array('class' => 'form-button'))}}
                                {{ Form::close() }}

                                <form action="{{ route('groups.destroy', $group->id) }}" method="post">
                                    <input type="hidden" name="_method" value="DELETE" />
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <input type="submit" class="delete-button" value="Verwijder groep" />
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>

        <div class="add-group-button">
            <button data-bs-toggle="modal" data-bs-target="#exampleModal">
                <span class="material-icons">group_add</span>
            </button>
        </div>

    </div>

    <script type="text/javascript">

        var i = 0;

        $("#add").click(function(){

            ++i;

            $("#dynamicTable").append('<tr><td><input type="text" name="addmore['+i+'][name]" placeholder="Naam" class="form-control" /></td><td><input type="text" name="addmore['+i+'][price]" placeholder="Prijs" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr"><span class="material-icons">remove</span></button></td></tr>');
        });

        $(document).on('click', '.remove-tr', function(){
            $(this).parents('tr').remove();
        });

    </script>
@endsection

{{--<div class="modal-content">--}}
{{--    <div class="modal-header">--}}
{{--        <h5 class="modal-title" id="exampleModalLabel">Groep toevoegen</h5>--}}
{{--        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--    </div>--}}
{{--    <div class="modal-body">--}}

{{--        {{ Form::open(array('url' => 'groups')) }}--}}

{{--        <div class="form-group">--}}
{{--            {{ Form::label('name', 'Groep naam') }}--}}
{{--            {{ Form::text('name', Input::old('name'), array('class' => 'form-control', 'placeholder' => 'Groepnaam')) }}--}}
{{--        </div>--}}

{{--        <div class="form-group">--}}
{{--            <input type="hidden" value="{{auth()->user()->id}}" name="user_id">--}}
{{--        </div>--}}

{{--        <div class="container">--}}

{{--            <form action="{{ url('/addmoreitems') }}" method="POST">--}}
{{--                @csrf--}}

{{--                @if ($errors->any())--}}
{{--                    <div class="alert alert-danger">--}}
{{--                        <ul>--}}
{{--                            @foreach ($errors->all() as $error)--}}
{{--                                <li>{{ $error }}</li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                @endif--}}

{{--                @if (Session::has('success'))--}}
{{--                    <div class="alert alert-success text-center">--}}
{{--                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>--}}
{{--                        <p>{{ Session::get('success') }}</p>--}}
{{--                    </div>--}}
{{--                @endif--}}

{{--                <p>Items</p>--}}
{{--                <table class="table table-bordered" id="dynamicTable">--}}
{{--                    <tr>--}}
{{--                        <td><input type="text" name="addmore[0][name]" placeholder="Naam" class="form-control" /></td>--}}
{{--                        <td><input type="number" name="addmore[0][price]" placeholder="Prijs" class="form-control" /></td>--}}
{{--                        <td><button type="button" name="add" id="add" class="btn btn-success">--}}
{{--                                <span class="material-icons">add</span>--}}
{{--                            </button></td>--}}
{{--                    </tr>--}}
{{--                </table>--}}

{{--                <input type="hidden" value="{{auth()->user()->id}}" name="group_id">--}}

{{--                <button type="submit" class="btn btn-success">Save</button>--}}
{{--            </form>--}}
{{--        </div>--}}

{{--    </div>--}}
{{--    <div class="modal-footer">--}}
{{--        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">SLUITEN</button>--}}
{{--        {{ Form::submit('TOEVOEGEN', array('class' => 'form-button'))}}--}}
{{--        {{ Form::close() }}--}}
{{--    </div>--}}
{{--</div>--}}
