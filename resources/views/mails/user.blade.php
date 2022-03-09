@extends('layouts.mail')

@section('content')
    <table  cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <img class="img-fluid" src="{{url('/')}}/img/mails/header.jpg"/>
            </td>
        </tr>
        <tr>
            <td class="content-block">
                <h3>Información de Usuario</h3>
            </td>
        </tr>
        <tr>
            <td class="content-block">
                Estas son tus claves de acceso a la plataforma {{env('APP_NAME')}} :
            </td>
        </tr>
        <tr>
            <td class="content-block">
                <b>{{__('forms.username')}}:</b> {{$data->username}}
            </td>
        </tr>

        <tr>
            <td class="content-block">
                <b>{{__('forms.password')}}:</b> {{$password}}
            </td>
        </tr>

        <tr>
            <td class="content-block aligncenter">
                <a href="{{route('login')}}" class="btn-primary">Iniciar Sesión</a>
            </td>
        </tr>
    </table>
@endsection