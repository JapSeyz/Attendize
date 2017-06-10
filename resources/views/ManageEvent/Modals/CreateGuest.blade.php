<div role="dialog" class="modal fade" style="display: none;">
    {!! Form::open(array('url' => route('postCreateGuest', array('event_id' => $event_id)), 'class' => 'ajax')) !!}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3 class="modal-title">
                    <i class="ico-ticket"></i>
                    Create Guest</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group">
                            {!! Form::label('name', 'Name', array('class'=>'control-label required')) !!}
                            {!!  Form::text('name', Input::old('name'),
                                array(
                                'class'=>'form-control',
                                'placeholder'=>'Johnny D.'
                                ))  !!}
                        </div>


                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('band', 'Band', array('class'=>'control-label required')) !!}
                                    {!!  Form::text('band', Input::old('band'),
                                         array(
                                         'class'=>'form-control',
                                         'placeholder'=>'Johnny Deluxe'
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
