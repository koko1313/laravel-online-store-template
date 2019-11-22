@extends('layout.layout')

@section('title')
    Профил | {{Auth::user()->first_name .' '. Auth::user()->last_name}}
@endsection

@section('content')

    <div class="container content">
        <h1>Профил</h1>

        @include('messages')

        <h2>
            {{Auth::user()->first_name .' '. Auth::user()->last_name}}
            <button type="button" class="btn btn-link" data-toggle="modal" data-target="#nameModal">[Редактирай]</button>
        </h2>

        <table id="user-info-table">
            <tr>
                <td><strong>E-mail</strong></td>
                <td>{{Auth::user()->email}}</td>
                <td><button type="button" class="btn btn-link" data-toggle="modal" data-target="#emailModal">[Редактирай]</button></td>
            </tr>
            <tr>
                <td><strong>Телефон</strong></td>
                <td>{{Auth::user()->phone}}</td>
                <td><button type="button" class="btn btn-link" data-toggle="modal" data-target="#phoneModal">[Редактирай]</button></td>
            </tr>
            <tr>
                <td><strong>Парола</strong></td>
                <td><button type="button" class="btn btn-link" data-toggle="modal" data-target="#passwordModal">[Редактирай]</button></td>
                <td></td>
            </tr>
        </table>

    </div>


    <form method="POST">

        {{csrf_field()}}
        {{method_field('PUT')}}

        <input type="hidden" name="id" value="{{Auth::user()->id}}">

        <div class="modal fade" id="nameModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Смяна на име</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-gorup">
                            <label for="first_name">Име</label>
                            <input class="form-control" type="text" name="first_name" id="first_name" value="{{Auth::user()->first_name}}">
                        </div>
                        <div class="form-gorup">
                            <label for="last_name">Фамилия</label>
                            <input class="form-control" type="text" name="last_name" id="last_name" value="{{Auth::user()->last_name}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                        <button type="submit" name="edit_name" class="btn btn-warning">Редактирай</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Смяна на E-mail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-gorup">
                            <label for="email">E-mail</label>
                            <input class="form-control" type="email" name="email" id="email" value="{{Auth::user()->email}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                        <button type="submit" name="edit_email" class="btn btn-warning">Редактирай</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="phoneModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Смяна на телефон</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-gorup">
                            <label for="phone">Телефон</label>
                            <input class="form-control" type="number" name="phone" id="phone" value="{{Auth::user()->phone}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                        <button type="submit" name="edit_phone" class="btn btn-warning">Редактирай</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Смяна на парола</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-gorup">
                            <label for="old_password">Стара парола</label>
                            <input class="form-control" type="password" name="old_password" id="old_password">
                        </div>
                        <div class="form-gorup">
                            <label for="password">Нова парола</label>
                            <input class="form-control" type="password" name="password" id="password">
                        </div>
                        <div class="form-gorup">
                            <label for="password_confirm">Повторете новата парола</label>
                            <input class="form-control" type="password" name="password_confirm" id="password_confirm">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                        <button type="submit" name="edit_password" class="btn btn-warning">Редактирай</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <style>
        #user-info-table td {
            padding-left: 5px;
            padding-right: 5px;
        }
    </style>

@endsection