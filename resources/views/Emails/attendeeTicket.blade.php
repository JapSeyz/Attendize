Hej, {{$attendee->first_name}},<br><br>

Vi har vedhæftet dine billetter til denne email.<br><br>

Du kan se informationer om din ordre, samt downloade dine billetter fra {{route('showOrderDetails', ['order_reference' => $attendee->order->order_reference])}} vores hjemmeside.<br><br>

Din ordre-reference er: <b>{{$attendee->order->order_reference}}</b>.<br>

Tak<br>

