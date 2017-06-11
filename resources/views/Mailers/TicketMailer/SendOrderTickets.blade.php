@extends('Emails.Layouts.Master')

@section('message_content')
Hej, {{ $order->first_name }}<br><br>

Din ordre til <b>{{$order->event->title}}</b> er gået igennem.<br><br>

Dine billetter er vedhæftet denne mail, og de kan hentes ned igen ved at klikke her: {{route('showOrderDetails', ['order_reference' => $order->order_reference])}}

@if(!$order->is_payment_received)
<br><br>
<b>Vær opmærksom på at ordren stadig ikke er betalt. For at se hvordan dette gøres, kan du gå herind: {{route('showOrderDetails', ['order_reference' => $order->order_reference])}}</b>
<br><br>
@endif
<h3>Ordre</h3>
Ordre-reference: <b>{{$order->order_reference}}</b><br>
Ordre-navn: <b>{{$order->full_name}}</b><br>
Ordre-dato: <b>{{$order->created_at->toDayDateTimeString()}}</b><br>
Ordre-email: <b>{{$order->email}}</b><br>
<a href="{!! route('downloadCalendarIcs', ['event_id' => $order->event->id]) !!}">Tilføj til kalender</a>

<h3>Billetter</h3>
<div style="padding:10px; background: #F9F9F9; border: 1px solid #f1f1f1;">
    <table style="width:100%; margin:10px;">
        <tr>
            <td>
                <b>Billet</b>
            </td>
            <td>
                <b>Antal</b>
            </td>
            <td>
                <b>Pris</b>
            </td>
            <td>
                <b>I alt</b>
            </td>
        </tr>
        @foreach($order->orderItems as $order_item)
                                <tr>
                                    <td>
                                        {{$order_item->title}}
                                    </td>
                                    <td>
                                        {{$order_item->quantity}}
                                    </td>
                                    <td>
                                        @if((int)ceil($order_item->unit_price) == 0)
                                        GRATIS
                                        @else
                                       {{money($order_item->unit_price, $order->event->currency)}}
                                        @endif

                                    </td>
                                    <td>
                                        @if((int)ceil($order_item->unit_price) == 0)
                                        GRATIS
                                        @else
                                        {{money(($order_item->unit_price) * ($order_item->quantity), $order->event->currency)}}
                                        @endif

                                    </td>
                                </tr>
                                @endforeach
        <tr>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
                <b>Total</b>
            </td>
            <td colspan="2">
               {{money($order->amount, $order->event->currency)}}
            </td>
        </tr>
    </table>

    <br><br>
</div>
<br><br>
Mange tak
@stop
