@extends('Emails.Layouts.Master')

@section('message_content')

<p>Hej</p>
<p>
    Du er blevet oprettet en {{ config('attendize.app_name') }} konto til dig af {{$inviter->first_name.' '.$inviter->last_name}}.
</p>

<p>
    Du kan logge ind med: <br><br>

    Brugernavn: <b>{{$user->email}}</b> <br>
    Password: <b>{{$temp_password}}</b>
</p>

<p>
    Du kan ændre dit midlertidige password når du er logget ind.
</p>

<div style="padding: 5px; border: 1px solid #ccc;" >
   {{route('login')}}
</div>
<br><br>

@stop

@section('footer')

@stop
