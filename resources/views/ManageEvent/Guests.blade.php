@extends('Shared.Layouts.Master')

@section('title')
    @parent
    Guests
@stop

@section('top_nav')
    @include('ManageEvent.Partials.TopNav')
@stop

@section('menu')
    @include('ManageEvent.Partials.Sidebar')
@stop

@section('page_title')
    <div class="btn-toolbar" role="toolbar">
        <div class="btn-group btn-group-responsive">
            <button data-modal-id='CreateGuest'
                    data-href="{{route('showCreateGuest', ['event_id'=>$event->id])}}"
                    class='loadModal btn btn-success' type="button"><i class="ico-bullhorn"></i> Create Guest
            </button>
        </div>
    </div>
@stop

@section('page_header')
    <style>
        .page-header {
            display: none;
        }
    </style>
@stop

@section('head')

@stop


@section('content')
    <div class="row">
        <div class="col-md-12">

            <div class="col-md-12">
                <div class="panel">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Band</th>
                                <th>Has Arrived</th>
                                <th>Arrival Time</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($event->guests()->latest()->get() as $guest)
                                <tr>
                                    <td>
                                        <a href='javascript:void(0);' data-modal-id='view-guest-{{ $guest->id }}' data-href="{{route('showEditGuest', ['event_id' => $event->id, 'guest_id' => $guest->id])}}" class="loadModal">{{ $guest->name }}</a>
                                    </td>
                                     <td>
                                        {{ $guest->band }}
                                    </td>
                                    <td>{{ $guest->has_arrived  ? 'Yes' : 'No' }}</td>
                                    <td>{{ $guest->arrival_time }}</td>
                                    <td>
                                        {!! Form::open(array('url' => route('postDeleteGuest', ['event_id' => $event->id, 'guest_id' => $guest->id]), 'class' => 'ajax text-right')) !!}
                                            {!! Form::submit('Delete Guest', ['class'=>"btn btn-danger"]) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
