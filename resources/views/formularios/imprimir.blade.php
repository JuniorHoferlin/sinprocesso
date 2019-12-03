@extends('layouts.imprimir')

@section('conteudo')
    @include('formularios.listagem', ['imprimir' => true])
@endsection