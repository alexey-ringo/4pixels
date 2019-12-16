@extends('layouts.app')

@section('content')
    @php
        /** @var \App\Models\Section $section */
    @endphp    
    <div class="container">
        <div class="row justify-content-center">   
            <section-edit-component v-bind:section-id="{{$section->id}}"></section-edit-component>
        </div>
    </div>    
@endsection