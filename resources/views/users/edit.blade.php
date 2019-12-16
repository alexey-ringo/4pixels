@extends('layouts.app')

@section('content')
    @php
        /** @var \App\Models\User $user */
    @endphp    
    <div class="container">
        <div class="row justify-content-center">    
            <user-edit-component v-bind:user-id="{{$user->id}}"></user-edit-component>
        </div>
    </div>    
@endsection