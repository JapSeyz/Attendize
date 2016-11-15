<div role="dialog" class="modal fade" style="display: none;">
    {!! Form::open(array('url' => route('postEditSponsor', ['event_id' => $sponsor->event_id, 'sponsor_id' => $sponsor->id]), 'class' => 'ajax')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">
                    <i class="ico-ticket"></i>
                    Edit {{ $sponsor->name }}</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('name', 'Name', array('class'=>'control-label required')) !!}
                            {!!  Form::text('name', $sponsor->name,
                                        array(
                                        'class'=>'form-control',
                                        'placeholder'=>'JapSeyz inc.'
                                        ))  !!}
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('sponsor_logo', 'Sponsor Logo', array('class'=>'control-label ')) !!}
                                    {!! Form::styledFile('sponsor_logo') !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="well well-sm well-small">
                                        {!! Form::label('on_ticket', 'On Ticket?', array('class'=>'control-label ')) !!}
                                        {!! Form::checkbox('on_ticket', 1, $sponsor->on_ticket) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- /end modal body-->
            <div class="modal-footer">
                {!! Form::button('Cancel', ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
                {!! Form::submit('Save Sponsor', ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
        {!! Form::close() !!}
    </div>
</div>