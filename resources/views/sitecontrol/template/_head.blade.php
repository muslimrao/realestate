<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $_pagetitle }} {!! Session::get("site_settings.SELLERCENTER_META_TITLE") !!}</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset("/public/assets/admincms/img/favicon.png?v=2") }}">

    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    @include("sitecontrol.template._includes")
    <!--include("sitecontrol.template._extra_includes")-->

</head>
