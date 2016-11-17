@extends('Shared.Layouts.BlankSlate')


@section('blankslate-icon-class')
    ico-search
@stop

@section('blankslate-title')
    Ingen resultater
@stop

@section('blankslate-text')
    Der blev ikke fundet noget på søgningen: '{{isset($search['q']) ? $search['q'] : $q}}'
@stop

@section('blankslate-body')
    
@stop