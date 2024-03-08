@extends('layouts.app')

@section('content')
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Perfil') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="p-4 sm:p-8">
                    <div class="max-w-xl">
                        <main>
                            <div class="profile-card card p-4 shadow mt-n4">
                                <h2 class="text-center">{{ __('Mi perfil') }}</h2>
                                <form method="post" action="{{ route('update-profile') }}">
                                    @csrf
                                    @method('patch')

                            <div class="mb-3 editable-field">
                                <x-input-label for="email" :value="__('Correo')" />
                                <x-text-input id="email" name="email" type="email" :value="old('email', $user->email)" class="form-control" readonly />
                            </div>

                            <div class="mb-3 editable-field">
                                <x-input-label for="name" :value="__('Nombre')" />
                                <x-text-input id="name" name="name" type="text" :value="old('name', $user->name)" class="form-control" />
                            </div>

                            <div class="mb-3 editable-field">
                                <x-input-label for="telefono" :value="__('Numero de telefono')" />
                                <div class="input-group">
                                    <x-text-input id="telefono" name="telefono" type="text" :value="old('telefono', $user->telefono)" class="form-control" />
                                    <button type="button" class="btn btn-dark edit-button" onclick="habilitarEdicion('telefono')">{{ __('Editar') }}</button>
                                </div>
                            </div>

                            <div class="mb-3 editable-field row">
                                        <div class="col-12">
                                            <div class="d-grid gap-2">
                                                <x-primary-button type="submit" class="btn btn-dark">{{ __('Actualizar perfil') }}</x-primary-button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </main>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg rounded " style="margin-bottom: 90px;">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form', ['containerClass' => 'container'])
                    </div >
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function habilitarEdicion(idCampo) {
        const campo = document.getElementById(idCampo);
        campo.removeAttribute("readonly");
        campo.classList.add("edited"); 

        campo.addEventListener("blur", function() {
            campo.setAttribute("readonly", "readonly");
            campo.classList.remove("edited");
        });
    }
</script>
@endsection