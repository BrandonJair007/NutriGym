@extends('layouts.app')

@section('content')

<!-- Notificaciones -->
@if(session('success'))
<div class="fixed top-4 right-4 z-50 animate-bounce-in" id="alert-success">
    <div class="bg-white border-l-4 border-green-500 shadow-xl rounded-lg p-4 flex items-center gap-3">
        <div class="bg-green-100 p-2 rounded-full">
            <i class="fas fa-check text-green-600"></i>
        </div>
        <div>
            <p class="font-bold text-gray-800 text-sm">¡Éxito!</p>
            <p class="text-gray-600 text-xs">{{ session('success') }}</p>
        </div>
        <button onclick="document.getElementById('alert-success').style.display='none'" class="text-gray-400 hover:text-gray-600 ml-4">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
@endif

<!-- CONTENEDOR PRINCIPAL LIMITADO (Estilo Dashboard Moderno) -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Tarjeta de Backup -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex flex-col md:flex-row md:items-center justify-between p-6 gap-4">
            <div class="flex items-center gap-4">
                <div class="bg-blue-50 p-4 rounded-xl text-blue-600">
                    <i class="fas fa-database text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Copia de Seguridad</h2>
                    <p class="text-sm text-gray-500">Haz clic en el botón para crear un backup completo del sistema.</p>
                </div>
            </div>
            
            <button id="backupBtn" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl transition-all shadow-md flex items-center justify-center gap-2">
                <i class="fas fa-cloud-download-alt"></i> Generar Backup Ahora
            </button>
        </div>

        <div id="backupResult" class="px-6 pb-6" style="display: none;"></div>
        <div id="backupLoading" class="px-6 pb-6" style="display: none;">
            <div class="flex items-center gap-3 text-blue-600 bg-blue-50 p-4 rounded-lg">
                <div class="animate-spin rounded-full h-5 w-5 border-2 border-blue-600 border-t-transparent"></div>
                <span class="text-sm font-medium">Generando backup, por favor espere...</span>
            </div>
        </div>
    </div>

    <!-- Título Principal -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Gestión de Clientes</h1>
    </div>

    <!-- Layout de Dos Columnas -->
    <div class="flex flex-col lg:flex-row gap-6">

        <!-- PANEL IZQUIERDO: Buscador y Lista -->
        <div class="w-full lg:w-1/3 flex flex-col gap-4">
            
            <!-- Tarjeta de Controles -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <div class="mb-4">
                    <label class="block text-xs uppercase tracking-wider text-gray-500 font-bold mb-2">Buscar cliente</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <i class="fas fa-search"></i>
                        </span>
                        <input 
                            id="buscadorUsuarios"
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all outline-none text-sm" 
                            type="text" 
                            placeholder="Escribe un nombre o ID..." 
                        />
                    </div>
                </div>
                
                <div class="flex gap-2">
                    <button id="btnBuscar" type="button" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 rounded-xl transition-all text-sm">
                        Buscar
                    </button>
                    <button onclick="openModal('crearUsuarioModal')" class="flex-1 bg-green-500 hover:bg-green-600 text-white font-semibold py-2.5 rounded-xl transition-all shadow-sm text-sm flex justify-center items-center gap-2">
                        <i class="fas fa-plus"></i> Nuevo
                    </button>
                </div>
            </div>

            <!-- Tarjeta de Lista (Con Scroll) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-0 overflow-hidden flex flex-col h-[600px]">
                <div class="p-4 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Directorio de Usuarios</h3>
                </div>
                
                <!-- Contenedor con Scroll -->
                <div class="flex-1 overflow-y-auto custom-scrollbar p-2">
                    <table class="w-full">
                        <tbody id="tablaUsuarios">
                            @foreach($usuarios as $usuario)
                            <tr class="group hover:bg-blue-50/50 transition-all cursor-pointer rounded-xl block p-3 mb-1 border border-transparent hover:border-blue-100"
                                onclick="mostrarUsuario(event)"
                                data-usuario='@json($usuario)'>
                                <td class="flex items-center justify-between w-full">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center font-bold text-sm group-hover:bg-blue-100 group-hover:text-blue-600 transition-colors">
                                            {{ substr($usuario->nombre, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800">{{ $usuario->nombre }}</p>
                                            <p class="text-[10px] text-gray-400 font-mono">ID: #{{ $usuario->id }}</p>
                                        </div>
                                    </div>
                                    <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider
                                        @if($usuario->id_rol == 2) bg-green-100 text-green-700
                                        @elseif($usuario->id_rol == 3) bg-blue-100 text-blue-700
                                        @else bg-gray-100 text-gray-600 @endif">
                                        {{ $usuario->nombre_rol ?? 'Rol ' . $usuario->id_rol }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- PANEL DERECHO: Detalles del Usuario -->
        <div class="w-full lg:w-2/3">
            <div id="detallesUsuario" class="h-full">
                <!-- Estado Vacío Mejorado -->
                <div id="mensajeVacio" class="bg-white rounded-2xl shadow-sm border border-dashed border-gray-300 h-full min-h-[600px] flex flex-col items-center justify-center p-12 text-center">
                    <div class="bg-gray-50 p-6 rounded-full mb-4 text-gray-300">
                        <i class="fas fa-id-card text-6xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-600">Selecciona un Usuario</h3>
                    <p class="text-sm text-gray-400 mt-2 max-w-sm">Haz clic en un cliente de la lista izquierda para ver y gestionar toda su información, progreso y dietas.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- MODALES DEL SISTEMA -->
<!-- ========================================== -->
<!-- (MANTUVE TODOS TUS MODALES EXACTAMENTE IGUAL, SÓLO LES AÑADÍ backdrop-blur-sm PARA VERSE PREMIUM) -->

<!-- Modal Crear Usuario -->
<div id="crearUsuarioModal" class="fixed inset-0 z-50 hidden">
    <div class="modal-backdrop fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('crearUsuarioModal')"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 relative z-10">
            <h3 class="text-xl font-bold mb-4 text-gray-800">Crear Nuevo Usuario</h3>
            <form action="{{ route('admin.usuarios.store') }}" method="POST">
                @csrf
                <div class="space-y-4 max-h-[65vh] overflow-y-auto pr-2 custom-scrollbar">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                        <input type="text" name="nombre" required class="mt-1 block w-full border border-gray-300 rounded-xl shadow-sm p-2.5 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                        <input type="email" name="email" required class="mt-1 block w-full border border-gray-300 rounded-xl shadow-sm p-2.5 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha de nacimiento</label>
                        <input type="date" name="fecha_nacimiento" max="{{ date('Y-m-d', strtotime('-18 years')) }}" required class="mt-1 block w-full border border-gray-300 rounded-xl shadow-sm p-2.5 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <input type="password" name="password" required class="mt-1 block w-full border border-gray-300 rounded-xl shadow-sm p-2.5 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" required class="mt-1 block w-full border border-gray-300 rounded-xl shadow-sm p-2.5 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Rol</label>
                        <select name="id_rol" required class="mt-1 block w-full border border-gray-300 rounded-xl shadow-sm p-2.5 focus:ring-blue-500 focus:border-blue-500">
                            @foreach($roles_disponibles as $rol)
                                <option value="{{ $rol->id }}">{{ $rol->nombre_rol }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3 border-t border-gray-100 pt-4">
                    <button type="button" onclick="closeModal('crearUsuarioModal')" class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-xl hover:bg-gray-200 font-medium transition-all">Cancelar</button>
                    <button type="submit" class="bg-green-500 text-white px-5 py-2.5 rounded-xl hover:bg-green-600 font-medium transition-all shadow-sm">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Usuario -->
<div id="editarUsuarioModal" class="fixed inset-0 z-50 hidden">
    <div class="modal-backdrop fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('editarUsuarioModal')"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 relative z-10">
            <h3 class="text-xl font-bold mb-4 text-gray-800">Editar Usuario</h3>
            <form id="formEditarUsuario" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                        <input type="text" name="nombre" id="edit_nombre" required class="mt-1 block w-full border border-gray-300 rounded-xl shadow-sm p-2.5 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                        <input type="email" name="email" id="edit_email" required class="mt-1 block w-full border border-gray-300 rounded-xl shadow-sm p-2.5 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nueva Contraseña <span class="text-xs text-gray-400">(Opcional)</span></label>
                        <input type="password" name="password" class="mt-1 block w-full border border-gray-300 rounded-xl shadow-sm p-2.5 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Rol</label>
                        <select name="id_rol" id="edit_rol" required class="mt-1 block w-full border border-gray-300 rounded-xl shadow-sm p-2.5 focus:ring-blue-500 focus:border-blue-500">
                            @foreach($roles_disponibles as $rol)
                                <option value="{{ $rol->id }}">{{ $rol->nombre_rol }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3 border-t border-gray-100 pt-4">
                    <button type="button" onclick="closeModal('editarUsuarioModal')" class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-xl hover:bg-gray-200 font-medium transition-all">Cancelar</button>
                    <button type="submit" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl hover:bg-blue-700 font-medium transition-all shadow-sm">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Progreso -->
<div id="progresoModal" class="fixed inset-0 z-50 hidden">
    <div class="modal-backdrop fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('progresoModal')"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-2xl shadow-2xl relative z-10">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-chart-line text-purple-500 mr-3"></i> Mi Progreso
                    </h3>
                    <button onclick="closeModal('progresoModal')" class="text-gray-400 hover:text-red-500 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div id="progresoContent" class="space-y-6">
                    <div id="progresoLoading" class="text-center py-8">
                        <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-purple-500 mx-auto"></div>
                        <p class="text-gray-500 mt-3 text-sm">Cargando tu progreso...</p>
                    </div>
                    <div id="progresoData" class="hidden space-y-6">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-gray-50 p-4 text-center rounded-xl border border-gray-100">
                                <div id="pesoPerdido" class="text-2xl font-bold text-green-600">-0kg</div>
                                <div class="text-xs text-gray-500 uppercase tracking-wide mt-1">Peso perdido</div>
                            </div>
                            <div class="bg-gray-50 p-4 text-center rounded-xl border border-gray-100">
                                <div id="sesionesMes" class="text-2xl font-bold text-blue-600">0</div>
                                <div class="text-xs text-gray-500 uppercase tracking-wide mt-1">Sesiones/mes</div>
                            </div>
                            <div class="bg-gray-50 p-4 text-center rounded-xl border border-gray-100">
                                <div id="asistencia" class="text-2xl font-bold text-orange-600">0%</div>
                                <div class="text-xs text-gray-500 uppercase tracking-wide mt-1">Asistencia</div>
                            </div>
                            <div class="bg-gray-50 p-4 text-center rounded-xl border border-gray-100">
                                <div id="incrementoFuerza" class="text-2xl font-bold text-purple-600">+0%</div>
                                <div class="text-xs text-gray-500 uppercase tracking-wide mt-1">Fuerza</div>
                            </div>
                        </div>
                        <div class="bg-white border border-gray-100 p-4 rounded-xl shadow-sm">
                            <h4 class="font-bold text-gray-700 mb-3 text-sm">Evolución de peso</h4>
                            <div id="pesoChart" class="h-40 flex items-end justify-between space-x-1"></div>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-700 mb-3 text-sm">Mis Metas</h4>
                            <div id="metasList" class="space-y-2"></div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-blue-50/50 p-4 rounded-xl border border-blue-100">
                                <h4 class="font-bold text-blue-800 mb-2 text-sm">Estado Inicial</h4>
                                <div id="estadoInicial" class="text-sm text-gray-600"></div>
                            </div>
                            <div class="bg-green-50/50 p-4 rounded-xl border border-green-100">
                                <h4 class="font-bold text-green-800 mb-2 text-sm">Estado Actual</h4>
                                <div id="estadoActual" class="text-sm text-gray-600"></div>
                            </div>
                        </div>
                    </div>
                    <div id="progresoError" class="hidden text-center py-8">
                        <div class="text-red-500 text-lg mb-2"><i class="fas fa-exclamation-triangle"></i> Error al cargar</div>
                        <p id="errorMessage" class="text-gray-600 text-sm"></p>
                        <button onclick="cargarProgreso()" class="mt-4 bg-gray-100 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200">Reintentar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Objetivos -->
<div id="objetivoModal" class="fixed inset-0 z-50 hidden">
    <div class="modal-backdrop fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('objetivoModal')"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-2xl shadow-2xl relative z-10">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-bullseye text-blue-500 mr-3"></i> Objetivos del Usuario
                    </h3>
                    <button onclick="closeModal('objetivoModal')" class="text-gray-400 hover:text-red-500 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div id="objetivosContent">
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-spinner fa-spin fa-2x mb-4 text-blue-400"></i>
                        <p class="text-sm">Cargando objetivos...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Preferencias -->
<div id="preferenciaModal" class="fixed inset-0 z-50 hidden">
    <div class="modal-backdrop fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('preferenciaModal')"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-2xl max-h-[90vh] overflow-y-auto rounded-2xl shadow-2xl relative z-10">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-heart text-red-500 mr-3"></i> Preferencias del Usuario
                    </h3>
                    <button onclick="closeModal('preferenciaModal')" class="text-gray-400 hover:text-red-500 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div id="preferenciasContent">
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-spinner fa-spin fa-2x mb-4 text-red-400"></i>
                        <p class="text-sm">Cargando preferencias...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Dietas -->
<div id="dietasModal" class="fixed inset-0 z-50 hidden">
    <div class="modal-backdrop fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('dietasModal')"></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col rounded-2xl shadow-2xl relative z-10">
            <div class="flex flex-wrap justify-between items-center p-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-utensils text-green-500 mr-3"></i> Mis Dietas
                </h3>
                <button onclick="closeModal('dietasModal')" class="text-gray-400 hover:text-red-500 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="dietasContent" class="p-6 overflow-y-auto custom-scrollbar flex-1 bg-gray-50/30">
                <div class="text-center py-12 text-gray-500">
                    <i class="fas fa-spinner fa-spin fa-2x mb-4 text-green-500"></i>
                    <p class="text-sm">Cargando planes de alimentación...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- SCRIPTS Y ESTILOS EXTRA -->
<!-- ========================================== -->
<style>
    /* Estilos para el scroll elegante */
    .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    
    /* Animación de entrada para notificaciones */
    @keyframes bounce-in {
        0% { transform: scale(0.9) translateY(-20px); opacity: 0; }
        100% { transform: scale(1) translateY(0); opacity: 1; }
    }
    .animate-bounce-in { animation: bounce-in 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }
</style>

<script>
    // Variables globales
    const rolesDisponibles = @json($roles_disponibles ?? []);
    let usuarioSeleccionado = null;

    // Lógica del Backup
    document.getElementById('backupBtn').addEventListener('click', function() {
        const btn = this;
        const resultDiv = document.getElementById('backupResult');
        const loadingDiv = document.getElementById('backupLoading');
        
        btn.disabled = true;
        loadingDiv.style.display = 'block';
        resultDiv.style.display = 'none';
        
        fetch('{{ route("backup.create") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            loadingDiv.style.display = 'none';
            resultDiv.style.display = 'block';
            
            if (data.success) {
                resultDiv.innerHTML = `
                    <div class="bg-green-50 border border-green-200 text-green-800 rounded-xl p-4">
                        <h6 class="font-bold flex items-center mb-1"><i class="fas fa-check-circle mr-2"></i> Backup Completado</h6>
                        <p class="text-sm text-green-700">${data.message}</p>
                        <div class="mt-2 text-xs text-green-600 bg-green-100/50 p-2 rounded">
                            <strong>Carpeta:</strong> ${data.backup_folder}<br>
                            <strong>Tamaño:</strong> ${data.backup_size}
                        </div>
                    </div>
                `;
            } else {
                resultDiv.innerHTML = `
                    <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4">
                        <h6 class="font-bold flex items-center mb-1"><i class="fas fa-exclamation-circle mr-2"></i> Error en el Backup</h6>
                        <p class="text-sm">${data.message}</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            loadingDiv.style.display = 'none';
            resultDiv.style.display = 'block';
            resultDiv.innerHTML = `
                <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4">
                    <h6 class="font-bold flex items-center mb-1"><i class="fas fa-wifi mr-2"></i> Error de Conexión</h6>
                    <p class="text-sm">${error.message}</p>
                </div>
            `;
        })
        .finally(() => {
            btn.disabled = false;
        });
    });

    // Función para construir la tarjeta de detalles del lado derecho (Mismo funcionamiento, mejor HTML)
    function mostrarUsuario(event) {
        const fila = event.currentTarget;
        const usuario = JSON.parse(fila.getAttribute('data-usuario'));
        usuarioSeleccionado = usuario;
        
        document.getElementById('detallesUsuario').innerHTML = `
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col h-full animate-bounce-in">
                
                <!-- Encabezado de la Tarjeta -->
                <div class="bg-gray-50/80 border-b border-gray-100 p-6 flex justify-between items-start">
                    <div class="flex gap-5 items-center">
                        <div class="w-16 h-16 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-2xl shadow-lg shadow-blue-200">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">${usuario.nombre}</h3>
                            <p class="text-gray-500 text-sm flex items-center gap-2 mt-1">
                                <i class="fas fa-envelope"></i> ${usuario.email}
                            </p>
                        </div>
                    </div>
                    <button onclick="limpiarSeleccion()" class="text-gray-400 hover:text-red-500 transition-colors bg-white p-2 rounded-full shadow-sm">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <!-- Cuadrícula de Información -->
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                            <i class="fas fa-hashtag"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">ID del Sistema</p>
                            <p class="text-gray-800 font-semibold">${usuario.id}</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center">
                            <i class="fas fa-birthday-cake"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Nacimiento</p>
                            <p class="text-gray-800 font-semibold">${new Date(usuario.fecha_nacimiento).toLocaleDateString()}</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Fecha de Registro</p>
                            <p class="text-gray-800 font-semibold">${new Date(usuario.fecha_registro).toLocaleDateString()}</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center">
                            <i class="fas fa-user-tag"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Asignación de Rol</p>
                            <!-- FORMULARIO EXACTAMENTE IGUAL AL ORIGINAL -->
                            <form action="/admin/usuarios/${usuario.id}/rol" method="POST" class="m-0">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="PUT">
                                <select name="id_rol" onchange="this.form.submit()" class="w-full bg-transparent border-none p-0 font-semibold text-gray-800 focus:ring-0 cursor-pointer text-sm">
                                    ${rolesDisponibles.map(rol => 
                                        `<option value="${rol.id}" ${usuario.id_rol == rol.id ? 'selected' : ''}>
                                            ${rol.nombre_rol}
                                        </option>`
                                    ).join('')}
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="flex-1"></div> <!-- Espaciador flexible -->

                <!-- Zona de Botones Inferior -->
                <div class="p-6 bg-gray-50/50 border-t border-gray-100">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Módulos Nutricionales</p>
                    
                    <div class="flex flex-wrap gap-2 mb-6">
                        ${
                            usuario.id_rol == 4 
                            ? `
                                <button onclick="openObjetivoModal()" class="flex-1 min-w-[120px] bg-white border border-gray-200 hover:border-blue-400 hover:text-blue-600 text-gray-600 font-semibold py-3 px-4 rounded-xl shadow-sm transition-all flex flex-col items-center gap-2 text-xs">
                                    <i class="fas fa-bullseye text-lg"></i> Objetivos
                                </button>
                                <button onclick="openPreferenciaModal()" class="flex-1 min-w-[120px] bg-white border border-gray-200 hover:border-red-400 hover:text-red-600 text-gray-600 font-semibold py-3 px-4 rounded-xl shadow-sm transition-all flex flex-col items-center gap-2 text-xs">
                                    <i class="fas fa-heart text-lg"></i> Preferencias
                                </button>
                                <button onclick="openProgresoModal(${usuario.id})" class="flex-1 min-w-[120px] bg-white border border-gray-200 hover:border-purple-400 hover:text-purple-600 text-gray-600 font-semibold py-3 px-4 rounded-xl shadow-sm transition-all flex flex-col items-center gap-2 text-xs">
                                    <i class="fas fa-chart-line text-lg"></i> Progreso
                                </button>
                                <button onclick="openDietasModal(${usuario.id})" class="flex-1 min-w-[120px] bg-white border border-gray-200 hover:border-green-400 hover:text-green-600 text-gray-600 font-semibold py-3 px-4 rounded-xl shadow-sm transition-all flex flex-col items-center gap-2 text-xs">
                                    <i class="fas fa-utensils text-lg"></i> Dietas
                                </button>
                            `
                            : `
                                <div class="w-full bg-gray-100 text-gray-400 text-xs font-semibold py-3 rounded-xl text-center italic">
                                    Los módulos clínicos solo están habilitados para el rol de Paciente (Rol 4).
                                </div>
                            `
                        }
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-gray-200">
                        <button onclick="abrirEditarUsuario()" class="flex-1 bg-gray-800 hover:bg-gray-900 text-white font-semibold py-3 rounded-xl transition-all shadow-sm text-sm flex items-center justify-center gap-2">
                            <i class="fas fa-edit"></i> Editar Datos Personales
                        </button>
                        
                        <!-- FORMULARIO DE ELIMINAR IGUAL AL ORIGINAL -->
                        <form action="/admin/usuarios/${usuario.id}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar a este usuario de forma permanente?');" class="flex-1 m-0">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="w-full bg-red-50 hover:bg-red-500 text-red-600 hover:text-white font-semibold py-3 rounded-xl transition-all shadow-sm text-sm flex items-center justify-center gap-2 border border-red-100 hover:border-red-500">
                                <i class="fas fa-trash-alt"></i> Eliminar Sistema
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        `;
        
        // Efecto visual de selección en la tabla izquierda
        document.querySelectorAll('#tablaUsuarios tr').forEach(tr => {
            tr.classList.remove('bg-blue-50/50', 'border-blue-400');
            tr.classList.add('border-transparent');
        });
        fila.classList.remove('border-transparent');
        fila.classList.add('bg-blue-50/50', 'border-blue-400');
    }

    function limpiarSeleccion() {
        document.getElementById('detallesUsuario').innerHTML = `
            <div id="mensajeVacio" class="bg-white rounded-2xl shadow-sm border border-dashed border-gray-300 h-full min-h-[600px] flex flex-col items-center justify-center p-12 text-center">
                <div class="bg-gray-50 p-6 rounded-full mb-4 text-gray-300">
                    <i class="fas fa-id-card text-6xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-600">Selecciona un Usuario</h3>
                <p class="text-sm text-gray-400 mt-2 max-w-sm">Haz clic en un cliente de la lista izquierda para ver y gestionar toda su información, progreso y dietas.</p>
            </div>
        `;
        document.querySelectorAll('#tablaUsuarios tr').forEach(tr => {
            tr.classList.remove('bg-blue-50/50', 'border-blue-400');
            tr.classList.add('border-transparent');
        });
    }

    // Funciones Base Modales
    function openModal(modalId) { document.getElementById(modalId).classList.remove('hidden'); }
    function closeModal(modalId) { document.getElementById(modalId).classList.add('hidden'); }

    // Funciones Editar Usuario
    function abrirEditarUsuario() {
        if (!usuarioSeleccionado) return;
        document.getElementById('edit_nombre').value = usuarioSeleccionado.nombre;
        document.getElementById('edit_email').value = usuarioSeleccionado.email;
        document.getElementById('edit_rol').value = usuarioSeleccionado.id_rol;
        document.getElementById('formEditarUsuario').action = `/admin/usuarios/${usuarioSeleccionado.id}`;
        openModal('editarUsuarioModal');
    }

    // Funciones Objetivos
    function openObjetivoModal() {
        if (!usuarioSeleccionado) { alert('Por favor selecciona un usuario primero'); return; }
        openModal('objetivoModal');
        cargarObjetivosUsuario(usuarioSeleccionado.id);
    }

    function cargarObjetivosUsuario(usuarioId) {
        const objetivosContent = document.getElementById('objetivosContent');
        objetivosContent.innerHTML = `<div class="text-center py-12 text-gray-500"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto mb-4"></div><p class="text-sm">Cargando objetivos...</p></div>`;
        fetch(`/usuarios/${usuarioId}/objetivos`)
            .then(response => response.json())
            .then(data => {
                if (data.success) mostrarObjetivosEnModal(data.objetivos, usuarioSeleccionado.nombre);
                else objetivosContent.innerHTML = `<div class="text-center py-8 text-red-500"><i class="fas fa-exclamation-triangle fa-2x mb-4"></i><p>${data.message}</p></div>`;
            })
            .catch(error => {
                objetivosContent.innerHTML = `<div class="text-center py-8 text-red-500"><i class="fas fa-exclamation-triangle fa-2x mb-4"></i><p>${error.message}</p></div>`;
            });
    }

    function mostrarObjetivosEnModal(objetivos, nombreUsuario) {
        const objetivosContent = document.getElementById('objetivosContent');
        if (objetivos.length === 0) {
            objetivosContent.innerHTML = `<div class="text-center py-12 text-gray-400"><i class="fas fa-bullseye fa-3x mb-4 opacity-50"></i><p class="text-sm">El usuario <strong>${nombreUsuario}</strong> no tiene objetivos asignados</p></div>`;
            return;
        }

        let html = `
            <div class="mb-4">
                <h4 class="font-semibold text-gray-700 text-sm">Objetivos de <span class="text-blue-600">${nombreUsuario}</span></h4>
                <p class="text-xs text-gray-500">Total: ${objetivos.length}</p>
            </div>
            <div class="space-y-4 max-h-96 overflow-y-auto pr-2 custom-scrollbar">
        `;

        objetivos.forEach(objetivo => {
            const estadoColor = { 'activo': 'bg-green-100 text-green-700 border-green-200', 'completado': 'bg-blue-100 text-blue-700 border-blue-200', 'pendiente': 'bg-yellow-100 text-yellow-700 border-yellow-200' }[objetivo.estado] || 'bg-gray-100 text-gray-700 border-gray-200';
            html += `
                <div class="bg-gray-50 border border-gray-100 p-4 rounded-xl">
                    <div class="flex justify-between items-start mb-2 gap-2">
                        <h5 class="font-bold text-gray-800 text-sm">${objetivo.nombre}</h5>
                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold border ${estadoColor} uppercase tracking-wider">${objetivo.estado}</span>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">${objetivo.descripcion}</p>
                    <div class="flex justify-between text-[11px] font-medium text-gray-400">
                        <span><i class="fas fa-calendar-alt mr-1"></i> ${new Date(objetivo.fecha_asignacion).toLocaleDateString()}</span>
                        ${objetivo.calificacion ? `<span>Calificación: <strong class="text-gray-600">${objetivo.calificacion}</strong></span>` : ''}
                    </div>
                </div>
            `;
        });
        objetivosContent.innerHTML = html + `</div>`;
    }

    // Funciones Progreso
    function cargarProgreso(pacienteId = null) {
        const loading = document.getElementById('progresoLoading');
        const data = document.getElementById('progresoData');
        const error = document.getElementById('progresoError');
        
        if (!loading || !data || !error) return;
        
        loading.classList.remove('hidden');
        data.classList.add('hidden');
        error.classList.add('hidden');

        let url = '/progreso/datos';
        if (pacienteId) { url += `/${pacienteId}`; }

        fetch(url)
            .then(response => {
                if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);
                return response.json();
            })
            .then(result => {
                if (result.success) {
                    renderProgreso(result.data);
                    loading.classList.add('hidden');
                    data.classList.remove('hidden');
                } else {
                    throw new Error(result.message || 'Error desconocido');
                }
            })
            .catch(err => {
                loading.classList.add('hidden');
                if (document.getElementById('errorMessage')) {
                    document.getElementById('errorMessage').textContent = err.message;
                    error.classList.remove('hidden');
                }
            });
    }

    function openProgresoModal(pacienteId = null) {
        const modal = document.getElementById('progresoModal');
        if (modal) {
            modal.classList.remove('hidden');
            cargarProgreso(pacienteId);
        }
    }

    function renderPesoChart(historialPeso) {
        const chartContainer = document.getElementById('pesoChart');
        if (!chartContainer) return;
        
        chartContainer.innerHTML = '';
        if (!historialPeso || historialPeso.length === 0) {
            chartContainer.innerHTML = '<p class="text-gray-400 text-center text-sm w-full py-8">No hay datos de peso</p>';
            return;
        }

        historialPeso.sort((a, b) => new Date(a.fecha_registro) - new Date(b.fecha_registro));
        const pesos = historialPeso.map(item => item.peso).filter(peso => peso != null);
        if (pesos.length === 0) {
            chartContainer.innerHTML = '<p class="text-gray-400 text-center text-sm w-full py-8">No hay datos válidos de peso</p>';
            return;
        }

        const maxPeso = Math.max(...pesos);
        const minPeso = Math.min(...pesos);
        const rangoTotal = maxPeso - minPeso;
        const rangoVisual = rangoTotal > 5 ? rangoTotal : 10;
        const pesoBase = minPeso - 2;

        const chartWrapper = document.createElement('div');
        chartWrapper.className = 'w-full h-40 flex items-end justify-between space-x-2';

        historialPeso.forEach((item, index) => {
            if (item.peso == null) return;
            const alturaPorcentaje = ((item.peso - pesoBase) / rangoVisual) * 90;
            const barContainer = document.createElement('div');
            barContainer.className = 'flex flex-col items-center justify-end flex-1 h-full relative';

            const bar = document.createElement('div');
            const esUltimo = index === historialPeso.length - 1;
            const esPrimero = index === 0;
            
            bar.className = `w-4 sm:w-6 rounded-t-md transition-all duration-700 shadow-sm ${
                esUltimo ? 'bg-purple-500' :
                esPrimero ? 'bg-blue-400' :
                'bg-blue-300'
            } hover:opacity-80`;
            bar.style.height = '0%';
            
            const valueLabel = document.createElement('div');
            valueLabel.className = 'text-[10px] font-bold text-gray-600 mb-1';
            valueLabel.textContent = `${item.peso}kg`;
            
            const dateLabel = document.createElement('div');
            dateLabel.className = 'text-[9px] text-gray-400 mt-1 text-center';
            dateLabel.textContent = new Date(item.fecha_registro).toLocaleDateString('es-ES', { month: 'short', day: 'numeric' });
            
            barContainer.appendChild(valueLabel);
            barContainer.appendChild(bar);
            barContainer.appendChild(dateLabel);
            chartWrapper.appendChild(barContainer);

            setTimeout(() => { bar.style.height = `${alturaPorcentaje}%`; }, index * 100);
        });
        
        chartContainer.appendChild(chartWrapper);
    }

    function renderMetas(metas) {
        const metasContainer = document.getElementById('metasList');
        if (!metasContainer) return;
        metasContainer.innerHTML = '';
        if (!metas || metas.length === 0) {
            metasContainer.innerHTML = '<p class="text-gray-400 text-sm italic">No hay metas definidas</p>';
            return;
        }

        const metasOrdenadas = metas.sort((a, b) => {
            if (a.completada && !b.completada) return -1;
            if (!a.completada && b.completada) return 1;
            return 0;
        });

        metasOrdenadas.forEach(meta => {
            const isCompleted = meta.completada;
            const metaElement = document.createElement('div');
            metaElement.className = `p-3 rounded-lg border transition-all duration-300 ${isCompleted ? 'bg-green-50 border-green-200' : 'bg-white border-gray-200'}`;
            metaElement.innerHTML = `
                <div class="flex items-center">
                    <div class="flex-shrink-0 mr-3"><div class="w-4 h-4 rounded-full flex items-center justify-center ${isCompleted ? 'bg-green-500 text-white' : 'bg-gray-200 text-transparent'}"><i class="fas fa-check text-[10px]"></i></div></div>
                    <div class="flex-1">
                        <div class="font-semibold text-sm ${isCompleted ? 'text-green-800' : 'text-gray-700'}">
                            ${meta.descripcion}
                        </div>
                        ${meta.objetivo_origen ? `<div class="text-[10px] text-gray-400 mt-0.5">${meta.objetivo_origen}</div>` : ''}
                    </div>
                </div>
            `;
            metasContainer.appendChild(metaElement);
        });
    }

    function renderEstados(estadoInicial, estadoActual) {
        const estInic = document.getElementById('estadoInicial');
        const estAct = document.getElementById('estadoActual');

        if (estInic) {
            estInic.innerHTML = estadoInicial ? `
                <div class="space-y-1 mt-2">
                    <div class="flex justify-between items-center"><span class="text-sm text-gray-500">Peso base:</span><span class="text-sm font-bold text-gray-800">${estadoInicial.peso}kg</span></div>
                    <div class="flex justify-between items-center"><span class="text-xs text-gray-400">Fecha:</span><span class="text-xs font-medium text-gray-500">${new Date(estadoInicial.fecha_registro).toLocaleDateString()}</span></div>
                </div>
            ` : '<p class="text-gray-400 text-sm italic mt-2">Sin datos iniciales</p>';
        }

        if (estAct) {
            estAct.innerHTML = estadoActual ? `
                <div class="space-y-1 mt-2">
                    <div class="flex justify-between items-center"><span class="text-sm text-gray-500">Peso actual:</span><span class="text-sm font-bold ${estadoInicial && estadoActual.peso < estadoInicial.peso ? 'text-green-600' : estadoInicial && estadoActual.peso > estadoInicial.peso ? 'text-red-600' : 'text-gray-800'}">${estadoActual.peso}kg</span></div>
                    <div class="flex justify-between items-center"><span class="text-xs text-gray-400">Fecha:</span><span class="text-xs font-medium text-gray-500">${new Date(estadoActual.fecha_registro).toLocaleDateString()}</span></div>
                </div>
            ` : '<p class="text-gray-400 text-sm italic mt-2">Sin datos actuales</p>';
        }
    }

    function renderProgreso(data) {
        safeSetText('pesoPerdido', `${data.metricas.pesoPerdido > 0 ? '-' : ''}${Math.abs(data.metricas.pesoPerdido).toFixed(1)}kg`);    
        safeSetText('sesionesMes', data.metricas.sesionesMes || 0);
        safeSetText('asistencia', `${data.metricas.asistencia || 0}%`);
        safeSetText('incrementoFuerza', `${data.metricas.gananciaMuscular > 0 ? '+' : ''}${data.metricas.gananciaMuscular.toFixed(1)}kg`);

        if (data.historialPeso) renderPesoChart(data.historialPeso);
        if (data.metas) renderMetas(data.metas);
        renderEstados(data.estadoInicial, data.estadoActual);
    }

    function safeSetText(elementId, text) {
        const element = document.getElementById(elementId);
        if (element) element.textContent = text;
    }

    function exportarReporte() {
        alert('Función de exportación en desarrollo...');
    }

    // Funciones Preferencias
    function openPreferenciaModal() {
        if (!usuarioSeleccionado) return;
        openModal('preferenciaModal');
        cargarPreferenciasUsuario(usuarioSeleccionado.id);
    }

    function cargarPreferenciasUsuario(usuarioId) {
        const preferenciasContent = document.getElementById('preferenciasContent');
        preferenciasContent.innerHTML = `<div class="text-center py-12 text-gray-500"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-red-500 mx-auto mb-4"></div><p class="text-sm">Cargando preferencias...</p></div>`;

        fetch(`/usuarios/${usuarioId}/preferencias`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarPreferenciasEnModal(data.preferencias, usuarioSeleccionado.nombre);
                } else {
                    preferenciasContent.innerHTML = `<div class="text-center py-8 text-red-500"><i class="fas fa-exclamation-triangle fa-2x mb-4"></i><p>${data.message}</p></div>`;
                }
            })
            .catch(error => {
                preferenciasContent.innerHTML = `<div class="text-center py-8 text-red-500"><p>${error.message}</p></div>`;
            });
    }

    function mostrarPreferenciasEnModal(preferencias, nombreUsuario) {
        const preferenciasContent = document.getElementById('preferenciasContent');
        if (preferencias.length === 0) {
            preferenciasContent.innerHTML = `<div class="text-center py-12 text-gray-400"><i class="fas fa-heart fa-3x mb-4 opacity-50"></i><p class="text-sm">El usuario <strong>${nombreUsuario}</strong> no tiene gustos registrados</p></div>`;
            return;
        }

        let html = `
            <div class="mb-4">
                <h4 class="font-semibold text-gray-700 text-sm">Gustos y Restricciones de <span class="text-red-600">${nombreUsuario}</span></h4>
            </div>
            <div class="space-y-4 max-h-96 overflow-y-auto pr-2 custom-scrollbar">
        `;

        const preferenciasPorTipo = {};
        preferencias.forEach(pref => {
            if (!preferenciasPorTipo[pref.tipo]) preferenciasPorTipo[pref.tipo] = [];
            preferenciasPorTipo[pref.tipo].push(pref);
        });

        Object.keys(preferenciasPorTipo).forEach(tipo => {
            const colorTipo = { 'dieta': 'bg-green-50 text-green-700 border-green-200', 'alergia': 'bg-red-50 text-red-700 border-red-200', 'preferencia': 'bg-blue-50 text-blue-700 border-blue-200' }[tipo] || 'bg-gray-50 text-gray-700 border-gray-200';
            html += `
                <div class="mb-2">
                    <span class="inline-block mb-2 px-3 py-1 rounded-md text-[10px] font-bold border ${colorTipo} uppercase tracking-wider">${tipo}</span>
                    <div class="grid grid-cols-1 gap-2 pl-2">
            `;
            preferenciasPorTipo[tipo].forEach(preferencia => {
                html += `
                    <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-100 shadow-sm">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-check text-green-500 text-sm"></i>
                            <span class="text-sm font-medium text-gray-700">${preferencia.descripcion}</span>
                        </div>
                    </div>
                `;
            });
            html += `</div></div>`;
        });
        html += `</div>`;
        preferenciasContent.innerHTML = html;
    }

    // Funciones Dietas
    function openDietasModal(usuarioId) {
        document.getElementById('dietasModal').classList.remove('hidden');
        const dietasContainer = document.getElementById('dietasContent');
        dietasContainer.innerHTML = `<div class="text-center py-16"><div class="animate-spin rounded-full h-10 w-10 border-b-2 border-green-500 mx-auto mb-4"></div><p class="text-gray-500 text-sm">Cargando dietas asignadas...</p></div>`;
        
        fetch(`/usuario/${usuarioId}/dietas`)
            .then(response => {
                if (!response.ok) throw new Error('Error en la petición');
                return response.json();
            })
            .then(data => {
                if (data.success) renderDietas(data.data);
                else mostrarErrorDietas(data.message || 'Error al cargar las dietas');
            })
            .catch(error => {
                mostrarErrorDietas('Error de conexión');
            });
    }

    function mostrarErrorDietas(mensaje) {
        document.getElementById('dietasContent').innerHTML = `
            <div class="text-center py-12 text-red-500">
                <i class="fas fa-exclamation-triangle text-3xl mb-3"></i>
                <p class="text-sm font-medium">${mensaje}</p>
            </div>
        `;
    }

    function renderDietas(menus) {
        const dietasContainer = document.getElementById('dietasContent');
        if (!menus || menus.length === 0) {
            dietasContainer.innerHTML = `<div class="text-center py-16 text-gray-400"><i class="fas fa-utensils text-5xl mb-4 opacity-40"></i><p class="text-sm">El usuario no tiene dietas asignadas aún</p></div>`;
            return;
        }

        const menusPorTipo = { 'desayuno': [], 'almuerzo': [], 'cena': [], 'general': [] };
        menus.forEach(menu => {
            const tipo = menu.tipo || 'general';
            if (menusPorTipo[tipo]) menusPorTipo[tipo].push(menu);
        });

        dietasContainer.innerHTML = `
            <div class="space-y-6">
                ${Object.entries(menusPorTipo).map(([tipo, menusDelTipo]) => {
                    if (menusDelTipo.length === 0) return '';
                    return `
                    <div class="border border-gray-200 rounded-2xl p-5 bg-white shadow-sm">
                        <div class="flex items-center gap-3 mb-4 border-b border-gray-100 pb-3">
                            <div class="w-10 h-10 rounded-full bg-${getColorTipo(tipo)}-50 text-${getColorTipo(tipo)}-500 flex items-center justify-center text-lg">
                                <i class="fas ${getIconoTipo(tipo)}"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 text-lg capitalize">${tipo}</h4>
                                <p class="text-gray-400 text-xs">${menusDelTipo.length} menú(s)</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            ${menusDelTipo.map(menu => {
                                const alimentosMenu = menu.alimentos || [];
                                const caloriasTotales = menu.calorias || alimentosMenu.reduce((sum, al) => sum + (al.calorias || 0), 0);
                                return `
                                <div class="border border-gray-100 rounded-xl p-4 bg-gray-50/50 hover:bg-gray-50 hover:border-gray-200 transition-all">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h5 class="font-bold text-gray-800 text-sm mb-1">${menu.nombre || `Menú ${tipo}`}</h5>
                                            <div class="text-[10px] text-gray-400"><i class="fas fa-calendar mr-1"></i>${new Date(menu.fecha_asignacion).toLocaleDateString('es-ES')}</div>
                                        </div>
                                        <span class="bg-${getColorTipo(tipo)}-100 text-${getColorTipo(tipo)}-700 text-xs font-bold px-2.5 py-1 rounded-md">${caloriasTotales} kcal</span>
                                    </div>
                                    ${menu.descripcion ? `<p class="text-xs text-gray-500 mb-3 line-clamp-2">${menu.descripcion}</p>` : ''}
                                    
                                    <div class="mb-3">
                                        <h6 class="font-semibold text-gray-600 text-[11px] uppercase tracking-wider mb-2">Ingredientes</h6>
                                        <div class="space-y-1.5">
                                            ${alimentosMenu.map(alimento => `
                                                <div class="flex justify-between items-center text-xs bg-white px-3 py-2 rounded-lg border border-gray-100">
                                                    <span class="font-medium text-gray-700">${alimento.alimento?.nombre || 'Alimento'}</span>
                                                    <span class="text-[10px] text-gray-400 font-mono">${alimento.cantidad || ''} ${alimento.unidad || ''}</span>
                                                </div>
                                            `).join('')}
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center justify-between pt-3 border-t border-gray-200 mt-auto">
                                        <div class="flex items-center gap-2">
                                            <button onclick="validarMenu(${menu.id})" class="w-7 h-7 flex items-center justify-center rounded-full transition-all duration-200 ${menu.validado ? 'bg-green-100 text-green-600 hover:bg-green-200' : 'bg-gray-200 text-gray-400 hover:bg-gray-300'}" title="${menu.validado ? 'Invalidar' : 'Validar'}"><i class="fas ${menu.validado ? 'fa-check' : 'fa-clock'} text-[10px]"></i></button>
                                        </div>
                                        <span class="text-[10px] text-gray-400 font-mono">Asignación #${menu.id_usuario}</span>
                                    </div>
                                </div>
                                `;
                            }).join('')}
                        </div>
                    </div>
                    `;
                }).join('')}
            </div>
        `;
    }

    function validarMenu(menuId) {
        fetch(`/menu/${menuId}/toggle-validacion`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const usuarioId = data.menu.id_usuario;
                openDietasModal(usuarioId);
            } else {
                alert('Error al validar el menú');
            }
        })
        .catch(error => {
            alert('Error de conexión');
        });
    }

    function getIconoTipo(tipo) { return { 'desayuno': 'fa-mug-hot', 'almuerzo': 'fa-hamburger', 'cena': 'fa-moon', 'general': 'fa-apple-alt' }[tipo] || 'fa-apple-alt'; }
    function getColorTipo(tipo) { return { 'desayuno': 'orange', 'almuerzo': 'blue', 'cena': 'purple', 'general': 'gray' }[tipo] || 'gray'; }
    function cerrarDietas() { document.getElementById('dietasModal').classList.add('hidden'); }

    // ==========================================
    // LÓGICA DEL BUSCADOR EN TIEMPO REAL
    // ==========================================
    const inputBuscador = document.getElementById('buscadorUsuarios');
    const btnBuscar = document.getElementById('btnBuscar');

    function filtrarTabla() {
        const textoBusqueda = inputBuscador.value.toLowerCase();
        const filasUsuarios = document.querySelectorAll('#tablaUsuarios tr');

        filasUsuarios.forEach(fila => {
            const idUsuario = fila.querySelector('td div div p:last-child').textContent.toLowerCase();
            const nombreUsuario = fila.querySelector('td div div p:first-child').textContent.toLowerCase();

            if (nombreUsuario.includes(textoBusqueda) || idUsuario.includes(textoBusqueda)) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
    }

    if (inputBuscador) { inputBuscador.addEventListener('keyup', filtrarTabla); }
    if (btnBuscar) { btnBuscar.addEventListener('click', filtrarTabla); }
</script>

@endsection