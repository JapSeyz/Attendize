<section id="tickets" class="container">
    <div class="row">
        <h1 class='section_head'>
            Billetter
        </h1>
    </div>

    @if($event->end_date->isPast())
        <div class="alert alert-boring">
            Denne begivenhed er desværre slut.
        </div>
    @else
        @if($tickets->count() > 0)
            {!! Form::open(['url' => route('postValidateTickets', ['event_id' => $event->id]), 'class' => 'ajax']) !!}
            <div class="row">
                <div class="col-md-12">
                    <div class="content">
                        <div class="tickets_table_wrap">
                            <table class="table">
                                <?php
                                $is_free_event = true;
                                ?>
                                @foreach($tickets as $ticket)

                                    @if($ticket->sale_status !== config('attendize.ticket_status_on_sale'))
                                        @continue
                                    @endif

                                    <tr class="ticket" property="offers" typeof="Offer">
                                        <td>
                                <span class="ticket-title semibold" property="name">
                                    {{$ticket->title}}
                                </span>
                                            <p class="ticket-descripton mb0 text-muted" property="description">
                                                {!! nl2br($ticket->description) !!}
                                            </p>
                                        </td>
                                        <td style="width:180px; text-align: right;">
                                            <div class="ticket-pricing" style="margin-right: 20px;">
                                                @if($ticket->is_free)
                                                    GRATIS
                                                    <meta property="price" content="0">
                                                @else
                                                    <?php
                                                    $is_free_event = false;
                                                    ?>
                                                    <span title='{{money($ticket->price, $event->currency)}} Billet pris'>{{money($ticket->total_price, $event->currency)}} </span>
                                                    <meta property="priceCurrency"
                                                          content="{{ $event->currency->code }}">
                                                    <meta property="price"
                                                          content="{{ number_format($ticket->price, 2, '.', '') }}">
                                                @endif
                                            </div>
                                        </td>
                                        <td style="width:85px;">
                                            {!! Form::hidden('tickets[]', $ticket->id) !!}
                                            <meta property="availability" content="http://schema.org/InStock">
                                            <select name="ticket_{{$ticket->id}}" class="form-control"
                                                    style="text-align: center">
                                                @if ($tickets->count() > 1)
                                                    <option value="0">0</option>
                                                @endif
                                                @for($i=$ticket->min_per_person; $i<=$ticket->max_per_person; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                             </select>
                                        </td>
                                    </tr>
                                @endforeach

                                <tr class="checkout">
                                    <td colspan="3">
                                        {!!Form::submit('Videre', ['class' => 'btn btn-lg btn-primary pull-right'])!!}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::hidden('is_embedded', $is_embedded) !!}
            {!! Form::close() !!}
        @else
            <div class="alert alert-boring">
                Der er ingen billetter tilgængelige i øjeblikket.
            </div>
        @endif
    @endif
</section>
