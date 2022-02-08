@extends('admin.layouts.app')

@section ('content')
    @php $services  = []; @endphp
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{__("Tours Availability Calendar")}}</h1>
        </div>
        @include('admin.message')
        <div class="panel">
            <div class="panel-body">
                <div class="filter-div d-flex justify-content-between ">
                    <div class="col-left">
                        <form method="get" action="" class="filter-form filter-form-left d-flex flex-column flex-sm-row" role="search">
                            <input type="text" name="s" value="{{ Request()->s }}" placeholder="{{__('Search by name')}}" class="form-control">
                            <button class="btn-info btn btn-icon btn_search " type="submit">{{__('Search')}}</button>
                        </form>
                    </div>
                    <div class="col-right">
                        @if($rows->total() > 0)
                            <span class="count-string">{{ __("Showing :from - :to of :total spaces",["from"=>$rows->firstItem(),"to"=>$rows->lastItem(),"total"=>$rows->total()]) }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @if(count($rows))
        <div class="panel">
            <div class="panel-title"><strong>{{__('Availability')}}</strong></div>
            <div class="panel-body no-padding" style="background: #f4f6f8;padding: 0px 15px;">
                <div class="row">
                    <div class="col-md-3" style="border-right: 1px solid #dee2e6;">
                        <ul class="nav nav-tabs  flex-column vertical-nav" id="items_tab"  role="tablist">
                            @foreach($rows as $k=>$item)
                                <li class="nav-item event-name ">
                                    <a class="nav-link" data-id="{{$item->id}}" data-toggle="tab" href="#calendar-{{$item->id}}" title="{{$item->title}}" >#{{$item->id}} - {{$item->title}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-9" style="background: white;padding: 15px;">
                        <div id="dates-calendar" class="dates-calendar"></div>
                    </div>
                </div>
            </div>
        </div>
        @else
            <div class="alert alert-warning">{{__("No tours found")}}</div>
        @endif
        <div class="d-flex justify-content-center">
            {{$rows->appends($request->query())->links()}}
        </div>
    </div>
    <div id="bravo_modal_calendar" class="modal fade">
        <div class="modal-dialog modal-lg  modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('Date Information')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="row form_modal_calendar form-horizontal" novalidate onsubmit="return false">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label >{{__('Date Ranges')}}</label>
                                <input readonly type="text" class="form-control has-daterangepicker">
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label >{{__('Status')}}</label>
                                <br>
                                <label ><input true-value=1 false-value=0 type="checkbox" v-model="form.active"> {{__('Available for booking?')}}</label>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="form-group">
                                <label >{{__('Max Guest')}}</label>
                                <input type="number"  v-model="form.max_guests" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row" >
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label >{{__('Departure Time')}}</label>
                                        <select name="departure_time[]" id="departure_time" v-bind:multiple="form.departure_time" class="horario form-control" multiple="multiple" style="width: 100%" ></select>
                                        
                                    </div>
                                </div>
                                
                            </div>

                        </div>
                        <div class="" v-if="person_types">
                            <div class="col-md-12" v-for="(type,index) in person_types">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>{{__("Name")}}</label>
                                            <input type="text" readonly class="form-control" v-model="person_types[index].name">
                                        </div>
                                        <div class="col-md-4">
                                            <label>{{__("Min")}}</label>
                                            <input type="text" v-model="person_types[index].min" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label>{{__("Max")}}</label>
                                            <input type="text" v-model="person_types[index].max" class="form-control">
                                        </div>
                                        <div class="col-md-3">
                                            <label>{{__("Price")}}</label>
                                            <input type="text" v-model="person_types[index].price" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                        <div class="col-md-6" v-else>
                            <div class="form-group">
                                <label >{{__('Price')}}</label>
                                <input type="text" v-model="form.price" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>
                                    {{__('Enable Return Time?')}}
                                    <input type="checkbox" id="enable_return_time" name="enable_return_time" v-model="enable_return_time" /> 
                                </label>
                            </div>
                               <!-- ocultada esta condicion:  v-if="enable_return_time == 1" -->
                            <div class="form-group-item"  >
                                    <div class="form-group">
                                        <label >{{__('Return Time')}}</label>
                                        <select name="return_time[]" id="return_time"  v-bind:multiple="form.return_time" class="horario form-control" multiple="multiple" style="width: 100%" ></select>
                                        
                                    </div>
                                    <div class="" v-if="person_types">
                                        <div v-for="(type,index) in person_types">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <label>{{__("Name")}}</label>
                                                        <input type="text" readonly class="form-control" v-model="person_types[index].name">
                                                    </div>
                                                    
                                                    <div class="col-md-4">
                                                        <label>{{__("Return Price")}}</label>
                                                        <input type="text" v-model="person_types[index].returnPrice" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            
                        </div>
                    </form>
                    <div v-if="lastResponse.message">
                        <br>
                        <div  class="alert" :class="!lastResponse.status ? 'alert-danger':'alert-success'">@{{ lastResponse.message }}</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close')}}</button>
                    <button type="button" class="btn btn-primary" @click="saveForm">{{__('Save changes')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script.head')
    <link rel="stylesheet" href="{{asset('libs/fullcalendar-4.2.0/core/main.css')}}">
    <link rel="stylesheet" href="{{asset('libs/fullcalendar-4.2.0/daygrid/main.css')}}">
    <link rel="stylesheet" href="{{asset('libs/daterange/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{asset('libs/select2/css/select2.min.css')}}">

    <style>
        .event-name{
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
        }
        .tooltip.show {

        }
    </style>
@endsection

@section('script.body')
    <script src="{{asset('libs/daterange/moment.min.js')}}"></script>
    <script src="{{asset('libs/daterange/daterangepicker.min.js?_ver='.config('app.version'))}}"></script>
    <script src="{{asset('libs/fullcalendar-4.2.0/core/main.js')}}"></script>
    <script src="{{asset('libs/fullcalendar-4.2.0/interaction/main.js')}}"></script>
    <script src="{{asset('libs/fullcalendar-4.2.0/daygrid/main.js')}}"></script>
    <script src="{{asset('libs/select2/js/select2.min.js')}}"></script>

    <script>

        function getTimeList() {

            var quarterHours = ["00", "15", "30", "45"];
            var times = [];
            for(var i = 0; i < 24; i++){
                for(var j = 0; j < 4; j++){
                    // Using slice() with negative index => You get always (the last) two digit numbers.
                    times.push( ('0' + i).slice(-2) + ":" + quarterHours[j] );
                }
            }
            return times;
        }

    </script>

    <script>
		var calendarEl,calendar,lastId,formModal;
        $('#items_tab').on('show.bs.tab',function (e) {
			calendarEl = document.getElementById('dates-calendar');
			lastId = $(e.target).data('id');
            if(calendar){
				calendar.destroy();
            }
			calendar = new FullCalendar.Calendar(calendarEl, {
				plugins: [ 'dayGrid' ,'interaction'],
				header: {},
				selectable: true,
				selectMirror: false,
				allDay:false,
				editable: false,
				eventLimit: true,
				defaultView: 'dayGridMonth',
                firstDay: daterangepickerLocale.first_day_of_week,
				events:{
                    	url:"{{route('tour.admin.availability.loadDates')}}",
						extraParams:{
							id:lastId,
                        }
                },
				loading:function (isLoading) {
					if(!isLoading){
						$(calendarEl).removeClass('loading');
					}else{
						$(calendarEl).addClass('loading');
					}
				},
				select: function(arg) {
                    formModal.show({
                        start_date:moment(arg.start).format('YYYY-MM-DD'),
                        end_date:moment(arg.end).format('YYYY-MM-DD'),
                    });
				},
                eventClick:function (info) {
					var form = Object.assign({},info.event.extendedProps);
                    form.start_date = moment(info.event.start).format('YYYY-MM-DD');
                    form.end_date = moment(info.event.start).format('YYYY-MM-DD');

                    $('.horario').val(null).trigger("change");
                    $('.horario').empty();

                    if(form.enable_return_time == 1){
                        $('#enable_return_time').prop('checked', true);
                    }
                    else{
                        $('#enable_return_time').prop('checked', false);
                    }
                   
                    var time_list = getTimeList();
                    var departure_time = [];
                    var return_time = [];
                    if(form.departure_time != null){

                        var horas_almacenadas = form.departure_time.split(",").map(function(item) {
                            return item.trim();
                        });
                        for(var i=0; i < time_list.length; i++){
                            var hora = {};
                            var selected = false;
                            var exist = $.inArray(time_list[i].trim(), horas_almacenadas);
                            if(exist != -1){
                                selected = true;
                            }
                            hora = {'id': i, 'text': time_list[i], 'selected': selected };
                            departure_time.push(hora);                            
                        }
                        $('#departure_time').select2({ data : departure_time});
                    }
                    
                    else{
                        $('#departure_time').select2({ data : time_list});
                    }
                    
                    if(form.return_time != null){
                    var horas_almacenadas = form.return_time.split(",").map(function(item) {
                        return item.trim();
                    });

                    for(var i=0; i < time_list.length; i++){
                        var hora = {};
                        var selected = false;
                        var exist = $.inArray(time_list[i].trim(), horas_almacenadas);
                        if(exist != -1){
                            selected = true;
                        }
                        hora = {'id': i, 'text': time_list[i], 'selected': selected };
                        return_time.push(hora);                            
                    }
                        $('#return_time').select2({ data : return_time});
                    }
                    else{
                        $('#return_time').select2({ data : time_list});
                    }
                    
                    formModal.show(form);
                },
                eventRender: function (info) {
                    $(info.el).find('.fc-title').html(info.event.title);
                    $(info.el).find('.fc-content').attr("data-html","true").attr("title",info.event.title).tooltip({ boundary: 'window' })
                }
			});
			calendar.render();
		});

        $('.event-name:first-child a').trigger('click');

        formModal = new Vue({
            el:'#bravo_modal_calendar',
            data:{
                lastResponse:{
                    status:null,
                    message:''
                },
                form:{
                    id:'',
                    price:'',
                    start_date:'',
                    end_date:'',
                    min_guests:0,
                    max_guests:0,
                    departure_time:[],
                    return_time:[],
                    active:0
                },
                formDefault:{
                    id:'',
                    price:'',
                    start_date:'',
                    end_date:'',
                    min_guests:0,
                    max_guests:0,
                    horario_ida:'',
                    horario_volta:'',
                    active:0
                },
                person_types:[

                ],
                person_type_item:{
                    name:'',
                    desc:'',
                    min:'',
                    max:'',
                    price:'',
                    returnPrice:''
                },
                enable_return_time: 0,
                
                onSubmit:false
            },
            methods:{
                show:function (form) {
                    $(this.$el).modal('show');
                    this.lastResponse.message = '';
                    this.onSubmit = false;

                    if(typeof form !='undefined'){
                        this.form = Object.assign({},form);
                        if(typeof this.form.person_types == 'object'){
                            this.person_types = this.form.person_types;
                        }else{
                            this.person_types = false;
                        }
                        if(form.start_date){
                            var drp = $('.has-daterangepicker').data('daterangepicker');
                            drp.setStartDate(moment(form.start_date).format(bookingCore.date_format));
                            drp.setEndDate(moment(form.end_date).format(bookingCore.date_format));
                        }
                    }
                    
                },
                hide:function () {
                    $(this.$el).modal('hide');
                    this.form = Object.assign({},this.formDefault);
                    this.person_types = false;
                },
                saveForm:function () {
                    this.form.target_id = lastId;
                    var me = this;
                    me.lastResponse.message = '';
                    if(this.onSubmit) return;

                    if(!this.validateForm()) return;

                    this.onSubmit = true;
                    this.form.person_types = this.person_types;

                    this.form.departure_time = $("#departure_time option:selected").map(function(){ return this.text }).get().join(", ");
                    this.form.return_time = $("#return_time option:selected").map(function(){ return this.text }).get().join(", ");

                    //if(){
                        this.form.enable_return_time = $("#enable_return_time").is(":checked") ? 1 : 0;
                    //}else{
                        //this.form.enable_return_time = 0;
                    //}
                    

                    //console.log(  );
                    //return;

                    $.ajax({
                        url:'{{route('tour.admin.availability.store')}}',
                        data:this.form,
                        dataType:'json',
                        method:'post',
                        success:function (json) {
                            if(json.status){
                                if(calendar)
                                calendar.refetchEvents();
                                me.hide();
                            }
                            me.lastResponse = json;
                            me.onSubmit = false;
                        },
                        error:function (e) {
                            me.onSubmit = false;
                        }
                    });
                },
                validateForm:function(){
                    if(!this.form.start_date) return false;
                    if(!this.form.end_date) return false;

                    return true;
                },
                /*addItem:function () {
                    console.log(this.person_types);
                    this.person_types.push(Object.assign([],this.person_type_item));
                },
                deleteItem:function (index) {
                    this.person_types.splice(index,1);
                }*/
            },
            created:function () {
                var me = this;
                this.$nextTick(function () {
                    $('.has-daterangepicker').daterangepicker({ "locale": {"format": bookingCore.date_format}})
                     .on('apply.daterangepicker',function (e,picker) {
                         console.log(picker);
                         me.form.start_date = picker.startDate.format('YYYY-MM-DD');
                         me.form.end_date = picker.endDate.format('YYYY-MM-DD');
                     });

                    $(me.$el).on('hide.bs.modal',function () {

                        this.form = Object.assign({},this.formDefault);
                        this.person_types = [];

                    });

                })
            },
            mounted:function () {
                // $(this.$el).modal();
            }
        });

    </script>
@endsection
