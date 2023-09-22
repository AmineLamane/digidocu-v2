@extends('errors.illustrated-layout')

@section('title', __('Service non trouvée'))
@section('code', '503')
@section('message', __($exception->getMessage() ?: 'Service non trouvée'))
