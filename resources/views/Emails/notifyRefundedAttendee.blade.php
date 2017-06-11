@extends('Emails.Layouts.Master')

@section('message_content')

    <p>Hej, {{ $attendee->first_name }}</p>
    <p>
        Du har modtaget en tilbagebetaling grundet den annullerede billet til <b>{{{$attendee->event->title}}}</b>.
        <b>{{{ $refund_amount }}} er blevet refunderet det originale kort, og du burde kunne se pengene om et par dage.</b>
    </p>

    <p>
        Du kan kontakte <b>{{{ $attendee->event->organiser->name }}}</b> direkte på <a href='mailto:{{{$attendee->event->organiser->email}}}'>{{{$attendee->event->organiser->email}}}</a> eller ved at besvare denne mail, hvis du har nogle spørgsmål.
    </p>
@stop

@section('footer')

@stop
