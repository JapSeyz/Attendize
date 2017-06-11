@extends('Emails.Layouts.Master')

@section('message_content')
Hej, {{$attendee->first_name}},<br><br>

Du er blevet inviteret til <b>{{$attendee->order->event->title}}</b>.<br/>
Din billet er vedhæftet denne mail.

<br><br>
De bedste hilsner.
@stop
