@extends('layouts.imprimir')

@section('conteudo')
    @include('processos.listagem', ['imprimir' => true])
@endsection