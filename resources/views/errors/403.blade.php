@extends('errors.illustrated-layout')

@section('title', __('Accés interdit'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Accés interdit'))
