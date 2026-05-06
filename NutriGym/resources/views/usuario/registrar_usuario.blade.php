@extends('layouts.app')

@section('content')
<div x-data="{ 
        openModal: false, 
        openErrorModal: {{ session('error') ? 'true' : 'false' }},
        openSuccessModal: {{ session('success') ? 'true' : 'false' }}
    }" class="min-h-screen flex items-center justify-center bg-[var(--color-surface)] py-8">

    <div class="w-full max-w-md p-8 neumorphic">
        <h1 class="text-2xl font-bold text-center mb-6 text-[var(--color-primary)]">Registrar Usuario</h1>

        <!-- Formulario -->
        <form x-ref="registroForm" method="POST" action="{{ route('registrar_usuario.store') }}">
            @csrf

            <!-- Nombre -->
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Nombre Completo *</label>
                <input type="text" name="nombre" class="input-neu w-full @error('nombre') border-red-500 @enderror" value="{{ old('nombre') }}" placeholder="Ej. Juan Pérez" required>
                @error('nombre') <p class="text-red-500 text-xs mt-1">⚠️ {{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Correo Electrónico *</label>
                <input type="email" name="email" class="input-neu w-full @error('email') border-red-500 @enderror" value="{{ old('email') }}" placeholder="ejemplo@correo.com" required>
                @error('email') <p class="text-red-500 text-xs mt-1">⚠️ {{ $message }}</p> @enderror
            </div>

            <!-- Fecha de Nacimiento -->
            <div class="mb-4">
                 <label class="block text-sm font-medium mb-1">Fecha de nacimiento *</label>
                 <input 
                        type="date" 
                        name="fecha_nacimiento" 
                        class="input-neu w-full @error('fecha_nacimiento') border-red-500 @enderror" 
                        value="{{ old('fecha_nacimiento') }}" 
                        max="{{ date('Y-m-d', strtotime('-18 years')) }}"
                        required
                 >
                @error('fecha_nacimiento') 
                <p class="text-red-500 text-xs mt-1">⚠️ {{ $message }}</p> 
                @enderror
            </div>

            <!-- Contraseña -->
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Contraseña *</label>
                <input type="password" name="contrasena" class="input-neu w-full @error('contrasena') border-red-500 @enderror" placeholder="Mínimo 8 caracteres" required>
                @error('contrasena') <p class="text-red-500 text-xs mt-1">⚠️ {{ $message }}</p> @enderror
            </div>

            <!-- Confirmar Contraseña -->
            <div class="mb-6">
                <label class="block text-sm font-medium mb-1">Confirmar Contraseña *</label>
                <input type="password" name="contrasena_confirmation" class="input-neu w-full" placeholder="Repite tu contraseña" required>
            </div>

            <!-- Botón que abre el modal de confirmación -->
            <button type="button" @click="if($refs.registroForm.reportValidity()) openModal = true" class="btn-neu w-full text-center">
                Registrarse
            </button>
        </form>
    </div>

    <!-- Modal de confirmación -->
    <div x-show="openModal" x-cloak x-transition class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="w-full max-w-md p-8 neumorphic mx-4 text-center">
            <h2 class="text-2xl font-bold mb-4 text-[var(--color-primary)]">Confirmar registro</h2>
            <p class="text-gray-600 mb-6">¿Deseas continuar con el registro de este usuario? Asegúrate de que los datos sean correctos.</p>

            <div class="flex space-x-3">
                <button type="button" 
                        @click="$refs.registroForm.submit(); openModal = false" 
                        class="btn-neu flex-1">
                    Confirmar
                </button>

                <button type="button" 
                        @click="openModal = false" 
                        class="btn-neu flex-1 bg-gray-300 text-gray-700 hover:bg-gray-400">
                    Cancelar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal de error -->
    <div x-show="openErrorModal" x-cloak x-transition class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="w-full max-w-md p-8 neumorphic mx-4 text-center">
            <h2 class="text-2xl font-bold mb-4 text-red-600">Error</h2>
            <p class="text-gray-700 mb-6 font-medium">{{ session('error') }}</p>

            <div class="flex justify-center">
                <button type="button" @click="openErrorModal = false"
                    class="btn-neu bg-red-500 hover:bg-red-600 text-white">
                    Cerrar
                </button>
            </div>
        </div>
    </div>

    <!-- Modal de éxito -->
    <div x-show="openSuccessModal" x-cloak x-transition class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="w-full max-w-md p-8 neumorphic mx-4 text-center">
            <h2 class="text-2xl font-bold mb-4 text-[var(--color-primary)]">¡Éxito!</h2>
            <p class="text-gray-700 mb-6">{{ session('success') }}</p>

            <div class="flex justify-center">
                <button type="button" @click="openSuccessModal = false ; window.location.href='{{ route('usuario') }}'"
                    class="btn-neu" >
                    Comenzar ahora
                </button>
            </div>
        </div>
    </div>

</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection