@extends('layouts.imprimir')

@section('conteudo')
    @include('relatorios.informacao_area.listagem', ['imprimir' => true])
@endsection