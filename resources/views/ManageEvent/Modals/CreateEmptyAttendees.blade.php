<div role="dialog"  class="modal fade " style="display: none;">
    {!! Form::open(array('url' => route('postCreateEmptyAttendee', array('event_id' => $event->id)), 'class' => 'ajax')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">
                    <i class="ico-user-plus"></i>
                    Create Empty Tickets</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('ticket_id', 'Ticket', array('class'=>'control-label required')) !!}
                                    {!! Form::select('ticket_id', $tickets, null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <!-- Import -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('attendees_to_create', 'Attendess to create', array('class'=>'control-label required')) !!}
                                    {!! Form::number('attendees_to_create', 5, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('order_first_name', 'Order First Name', array('class'=>'control-label required')) !!}
                                    {!! Form::text('order_first_name', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('order_last_name', 'Order Last Name', array('class'=>'control-label')) !!}
                                    {!! Form::text('order_last_name', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('order_email', 'Order Email', array('class'=>'control-label required')) !!}
                                    {!! Form::text('order_email', null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                               <div class="form-group">
                                   <div class="checkbox custom-checkbox">
                                       <input type="checkbox" name="add_ticket_price" id="add_ticket_price" value="1" checked />
                                       <label for="add_ticket_price">&nbsp;&nbsp;Medregn billetpris i statitik</label>
                                   </div>
                               </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                               <div class="form-group">
                                   <div class="checkbox custom-checkbox">
                                       <input type="checkbox" name="transfer_data" id="transfer_data" value="1" />
                                       <label for="transfer_data">&nbsp;&nbsp;Overfør data til billet</label>
                                   </div>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- /end modal body-->
            <div class="modal-footer">
                {!! Form::button('Cancel', ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
                {!! Form::submit('Create Attendees', ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
        {!! Form::close() !!}
    </div>
</div>
