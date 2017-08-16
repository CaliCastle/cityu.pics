@extends('emails.base')

@section('title', trans('messages.email.confirm.title', ['code' => $code = $user->getConfirmationCode()]))

@section('content')
    <p>@lang('messages.email.confirm.message', ['url' => $user->getConfirmationLink(), 'code' => $code])</p>
    <p>@lang('messages.email.confirm.ignore')</p>
    <footer>
        <b>Thanks, CityU Pics</b>
    </footer>
@stop