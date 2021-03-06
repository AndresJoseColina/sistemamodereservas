<div class="booking-review">
    <h4 class="booking-review-title">{{__('Your Information')}}</h4>
    <div class="booking-review-content">
        <div class="review-section">
            <div class="info-form">
                <ul>
                    <li class="info-first-name">
                        <div class="label">{{__('First name')}}</div>
                        <div class="val">{{$booking->first_name}}</div>
                    </li>
                    <li class="info-last-name">
                        <div class="label">{{__('Last name')}}</div>
                        <div class="val">{{$booking->last_name}}</div>
                    </li>
                    <li class="info-email">
                        <div class="label">{{__('Email')}}</div>
                        <div class="val">{{$booking->email}}</div>
                    </li>
                    <li class="info-phone">
                        <div class="label">{{__('Phone')}}</div>
                        <div class="val">{{$booking->phone}}</div>
                    </li>
                    <li class="info-address">
                        <div class="label">{{__('Address line 1')}}</div>
                        <div class="val">{{$booking->address}}</div>
                    </li>
                    <li class="info-address2">
                        <div class="label">{{__('Address line 2')}}</div>
                        <div class="val">{{$booking->address2}}</div>
                    </li>
                    <li class="info-city">
                        <div class="label">{{__('City')}}</div>
                        <div class="val">{{$booking->city}}</div>
                    </li>
                    <li class="info-state">
                        <div class="label">{{__('State/Province/Region')}}</div>
                        <div class="val">{{$booking->state}}</div>
                    </li>
                    <li class="info-zip-code">
                        <div class="label">{{__('ZIP code/Postal code')}}</div>
                        <div class="val">{{$booking->zip_code}}</div>
                    </li>
                    <li class="info-country">
                        <div class="label">{{__('Country')}}</div>
                        <div class="val">{{get_country_name($booking->country)}}</div>
                    </li>
                    <li class="info-notes">
                        <div class="label">{{__('Special Requirements')}}</div>
                        <div class="val">{{$booking->customer_notes}}</div>
                    </li>
                    <li class="info-guests">
                        <div class="label">{{__('Guests Names')}}</div>
                        <div class="val">
                            <?php
                                $guests = json_decode($booking->guests_names, true);
                                $inv = '';
                                if($booking->total_guests == 1 ){
                                    if($guests != null){
                                        $inv = $guests['Name'];
                                    }
                                   
                                }
                                else{
                                   
                                    if($guests != null){
                                        foreach($guests as $guest){

                                            $inv .= $guest['Name'].', ';
                                         }
                                         $inv = substr($inv, 0, -2);
                                    }
                                }
                            ?>
                           {{$inv}}
                        </div>
                    </li>
                    <?php
                        $fields = json_decode($booking->custom_fields_data);
                    ?>
                    @if($fields)
                        @foreach( $fields as $key=>$value )
                            <li>
                                <div class="label">{{ $key }}</div>
                                <div class="val">{{ $value->value }}</div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
