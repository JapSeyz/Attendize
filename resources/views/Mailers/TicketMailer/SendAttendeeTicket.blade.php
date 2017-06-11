@extends('Emails.Layouts.Master')

@section('message_content')
Hej, {{$attendee->first_name}},<br><br>

Din billet til <b>{{$attendee->order->event->title}}</b> er vedhæftet denne mail.

<br><br>
Mange tak
@stop
