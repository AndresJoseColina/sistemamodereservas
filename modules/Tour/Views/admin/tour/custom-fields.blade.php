<div class="panel">
    <div class="panel-title"><strong>{{__("Recover custom data")}}</strong></div>
    <div class="panel-body">
        <div class="form-group">
            <label><input type="checkbox" name="enable_custom_fields" @if(!empty($row->meta->enable_custom_fields)) checked @endif value="1"> {{__('Enable Custom Fields')}} </label>
        </div>
        <div class="form-group-item" data-condition="enable_custom_fields:is(1)">
            <label class="control-label">{{__('Custom Fields')}}</label>
            <div class="g-items-header">
                <div class="row">
                    <div class="col-md-12">{{__("Field Name")}}</div>
                    
                    
                </div>
            </div>
            <div class="g-items">
                    <?php  $languages = \Modules\Language\Models\Language::getActive(); ?>
                    @if(!$row->meta == null)
                        @if(!empty($custom_fields = $row->meta->custom_fields ))
                            @foreach($custom_fields as $key=>$item)
                                <div class="item" data-number="{{$key}}">
                                    <div class="row">
                                        <div class="col-md-11">
                                            @if(!empty($languages) && setting_item('site_enable_multi_lang') && setting_item('site_locale'))
                                                @foreach($languages as $language)
                                                    <?php $key_lang = setting_item('site_locale') != $language->locale ? "_".$language->locale : ""   ?>
                                                    <div class="g-lang">
                                                        <div class="title-lang">{{$language->name}}</div>
                                                        <input type="text" name="custom_fields[{{$key}}][name{{$key_lang}}]" class="form-control" value="{{$item['name'.$key_lang] ?? ''}}" placeholder="{{__('Field name')}}">
                                                        
                                                    </div>

                                                @endforeach
                                            @else
                                                <input type="text" name="custom_fields[{{$key}}][name]" class="form-control" value="{{$item['name'] ?? ''}}" placeholder="{{__('Field name')}}">
                                                
                                            @endif
                                        </div>
                                        <div class="col-md-1">
                                            <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endif

                </div>
                <div class="text-right">
                    <span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
                </div>
                <div class="g-more hide">
                    <div class="item" data-number="__number__">
                        <div class="row">
                            <div class="col-md-11">
                                @if(!empty($languages) && setting_item('site_enable_multi_lang') && setting_item('site_locale'))
                                    @foreach($languages as $language)
                                        <?php $key = setting_item('site_locale') != $language->locale ? "_".$language->locale : ""   ?>
                                        <div class="g-lang">
                                            <div class="title-lang">{{$language->name}}</div>
                                            <input type="text" __name__="custom_fields[__number__][name{{$key}}]" class="form-control" value="" placeholder="{{__('Field name')}}">
                                            
                                        </div>

                                    @endforeach
                                @else
                                    <input type="text" __name__="custom_fields[__number__][name]" class="form-control" value="" placeholder="{{__('Field name')}}">
                                    
                                @endif
                            </div>
                            
                            <div class="col-md-1">
                                <span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>