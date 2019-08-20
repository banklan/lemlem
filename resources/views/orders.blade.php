@extends('layouts.app')

@section('content')
    @include('layouts.navbar')
    <router-view></router-view>
    <!-- <orders-test></orders-test> -->
@endsection