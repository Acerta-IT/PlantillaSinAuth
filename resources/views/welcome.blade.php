{{-- @extends('layouts.app')

@section('title', 'Panel de Control')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                {{ __("You're logged in!") }}
            </div>
        </div>
    </div>
</div>
@endsection --}}

<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>


    <x-link-button type="danger">CREAR USUARIO</x-link-button>
    <x-icon-button icon="settings">RESTABLECER CONTRASEÑA</x-icon-button>




</x-app-layout>
