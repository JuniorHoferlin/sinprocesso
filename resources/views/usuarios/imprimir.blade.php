@extends('layouts.imprimir')

@section('conteudo')
    @include('usuarios.listagem', ['imprimir' => true])
@endsection