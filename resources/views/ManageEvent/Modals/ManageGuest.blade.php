<div role="dialog" class="modal fade" style="display: none;">
    {!! Form::open(array('url' => route('postEditGuest', ['event_id' => $guest->event_id, 'guest_id' => $guest->id]), 'class' => 'ajax')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">
                    <i class="ico-ticket"></i>
                    Edit {{ $guest->name }}</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('name', 'Name', array('class'=>'control-label required')) !!}
                            {!!  Form::text('name', $guest->name,
                                        array(
                                        'class'=>'form-control',
                                        'placeholder'=>'JayTee & Ejoy'
                                        ))  !!}
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('band', 'Band', array('class'=>'control-label ')) !!}
                                    {!!  Form::text('band', $guest->band,
                                         array(
                                         'class'=>'form-control',
                                         'placeholder'=> 'Det Musikalske Broderskab'
                                         ))  !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- /end modal body-->
            <div class="modal-footer">
                {!! Form::button('Cancel', ['class'=>"btn modal-close btn-danger",'data-dismiss'=>'modal']) !!}
                {!! Form::submit('Save Guest', ['class'=>"btn btn-success"]) !!}
            </div>
        </div><!-- /end modal content-->
        {!! Form::close() !!}
    </div>
</div>
