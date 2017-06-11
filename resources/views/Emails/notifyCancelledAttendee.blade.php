@extends('Emails.Layouts.Master')

@section('message_content')

<p>Hej, {{ $attendee->first_name }}</p>
<p>
    Din billet til <b>{{{$attendee->event->title}}}</b> er blevet annulleret.
</p>

<p>
    You can contact <b>{{{$attendee->event->organiser->name}}}</b> directly at <a href='mailto:{{{$attendee->event->organiser->email}}}'>{{{$attendee->event->organiser->email}}}</a> or by replying to this email should you require any more information.
</p>
@stop

@section('footer')

@stop
