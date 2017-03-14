@extends('Emails.Layouts.Master')

@section('message_content')

<p>Hej,</p>
<p>Du har modtaget en besked fra <b>{{ (isset($sender_name) ? $sender_name : $event->organiser->name) }}</b> i forbindelse med begivenheden <b>{{ $event->title }}</b>.</p>
<p style="padding: 10px; margin:10px; border: 1px solid #f3f3f3;">
    {!! nl2br($message_content) !!}
</p>

<p>
    Du kan kontakte <b>{{ (isset($sender_name) ? $sender_name : $event->organiser->name) }}</b> direkte på <a href='mailto:{{ (isset($sender_email) ? $sender_email : $event->organiser->email) }}'>{{ (isset($sender_email) ? $sender_email : $event->organiser->email) }}</a>, eller ved at besvare denne mail.
</p>
@stop

@section('footer')


@stop
