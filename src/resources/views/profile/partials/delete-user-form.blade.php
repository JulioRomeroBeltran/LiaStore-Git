
<div class="{{ $containerClass }}"> 
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Borrar cuenta') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Una vez que se elimine su cuenta, todos sus recursos y datos se eliminarán permanentemente.') }}
            </p>
        </header>

        <div class="col-12">
            <div class="d-grid gap-2">
                <x-danger-button x-data="" class="btn btn-danger" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Borrar cuenta') }}</x-danger-button>
            </div>
        </div>

        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                @csrf
                @method('delete')

                <h2 class=" mt-3 text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ __('¿Seguro que quieres borrar tu cuenta?') }}
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Ingrese su contraseña para confirmar que desea eliminar permanentemente su cuenta.') }}
                </p>

                <div class="mt-6 row justify-content-center align-items-center"> 
                    <div class="col-md-6"> 
                        <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 form-control" placeholder="{{ __('Contraseña') }}" />
                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                    </div>
                    <div class="col-md-6 mt-2"> 
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-dark" x-on:click="$dispatch('close')" style="width: 100%;">
                                {{ __('Cancelar') }}
                            </button>
                            <button type="submit" class="btn btn-danger" style="width: 100%;">
                                {{ __('Aceptar') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </x-modal>
    </section>
</div>