@extends('discussions::layouts.main')

@section('content')
    @livewire('discussion', ['discussion' => $discussion])
@endsection
