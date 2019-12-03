@extends('layouts.imprimir')

@section('conteudo')
    @include('insumo.listagem', ['imprimir' => true])
@endsection