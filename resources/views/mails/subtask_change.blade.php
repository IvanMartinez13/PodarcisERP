@extends('layouts.mail')

@section('content')
    <table  cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <img class="img-fluid" src="{{url('/')}}/img/mails/header.jpg"/>
            </td>
        </tr>

        <tr>
            @if ($open == true)
                
                <td class="content-block">
                    <h3>Se ha abierto una tarea.</h3>
                </td>
            @else

                <td class="content-block">
                    <h3>Se ha finalizado una tarea.</h3>
                </td>
            @endif

        </tr>
        <tr>
            @if ($open == true)
                
                <td class="content-block">
                    {{$user}} ha abierto la tarea "{{$data->name}}"
                </td>
            @else

                <td class="content-block">
                    {{$user}} ha finalizado la tarea "{{$data->name}}"
                </td>
            @endif

        </tr>

        <tr>
            <td class="content-block aligncenter">
                <a href="{{route('tasks.project.task_details', ["project"  => $project->token ,"task"  => $task->token])}}" class="btn-primary">Ver tarea</a>
            </td>
        </tr>
    </table>
@endsection