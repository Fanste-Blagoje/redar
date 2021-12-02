@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>

    @if(!empty(session('system_message')))
    <div class="text-success">{{session('system_message')}}</div>
    @endif

    @if($errors->has('id'))
    @foreach($errors->get('id') as $errorMessage)
    <div class="text-danger">{{$errorMessage}}</div>
    @endforeach
    @endif

    <table class="table">
        <thead>
        <th>Date</th>
        <th>House</th>
        <th>Actions</th>
        </thead>
        <tbody>
            @foreach($mySchedule as $schedule)
            <tr>
                <td>{{$schedule->date}}</td>
                <td>{{optional($schedule->house)->name}}</td>
                <td>
                    <form action="{{route('home.replacement')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{$schedule->id}}">

                        <button type="submit" class="btn btn-secondary">
                            Ask Replacement
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
