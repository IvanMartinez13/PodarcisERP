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
                <h3>{{$user}} ha comentado:</h3>
            </td>
        </tr>

        <tr>
            <td class="content-block">
                {!! $data->comment !!}
            </td>
        </tr>

        <tr>
            <td class="content-block aligncenter">
                <a href="{{route('tasks.project.task_details', ["project"  =>$project->token ,"task"  => $task->token])}}" class="btn-primary">Ver comentario</a>
            </td>
        </tr>
    </table>
@endsection