@extends('errors.plantilla')

@section('codigo', '403')
@section('titulo', 'Acceso denegado')
@section('mensaje', $exception->getMessage() ?: 'No tienes permiso para entrar a esta página.')
