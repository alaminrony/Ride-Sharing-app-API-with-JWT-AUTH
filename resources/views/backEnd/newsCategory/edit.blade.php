  {!! Form::open(['route' => ['news-category.update',$newsCategory->id],'method' => 'PUT','enctype' => 'multipart/form-data']) !!}
                @csrf
                <div class="">
                    <div class="form-group">
                        <label>Title</label>
                        {!! Form::text('title',$newsCategory->title,['class' => 'form-control','placeholder' =>Lang::get('lang.TITLE'),'required'=>'required']) !!}
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        {!! Form::textarea('description',$newsCategory->description,['class' => 'form-control','placeholder' =>Lang::get('lang.NOTIFY_MESSAGE'),'required'=>'required']) !!}
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info btn-round">{{ __('Update') }}</button>
                    <button type="button" class="btn btn-warning btn-round" data-dismiss="modal">Cancel</button>
                </div>
                {!! Form::close() !!}