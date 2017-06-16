@if ( ($_messageBundle['_TEXT_show_messages'] != '') and ($_messageBundle['_ALERT_mode'] == "") )

    <div class="callout callout-{{ $_messageBundle['_CSS_show_messages'] }} ">
        <h4>{{ $_messageBundle['_HEADING_show_messages'] }}</h4>

        {!!  $_messageBundle['_TEXT_show_messages'] !!}
    </div>

@elseif (Session::has('_flash_data_inline') and Session::has('_flash_messages_content') != "")

    <div class="callout callout-{{Session::get('_flash_messages_type')}}">
        <h4>{{Session::get('_flash_messages_title')}}</h4>
        {!! Session::get('_flash_messages_content') !!}
    </div>

@endif