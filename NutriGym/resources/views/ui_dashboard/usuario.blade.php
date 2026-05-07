@extends('layouts.app')

@section('content')
<!-- Contenedor Principal Limitado -->
<div class="p-4 sm:p-6 max-w-7xl mx-auto w-full space-y-8">
    
    <!-- Título de Bienvenida -->
    <div class="flex items-center justify-between mb-2">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 tracking-tight">Mi Panel Nutricional</h1>
            <p class="text-gray-500 text-sm mt-1">Gestiona tus planes, objetivos y preferencias.</p>
        </div>
    </div>

    <!-- Grid de Tarjetas (Cards) de Módulos -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Card 1: Dietas -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col relative overflow-hidden group hover:shadow-md transition-all">
            <i class="fas fa-apple-alt absolute -right-6 -bottom-6 text-8xl text-green-50 opacity-50 group-hover:scale-110 transition-transform duration-500"></i>
            <div class="flex items-start justify-between mb-6 relative z-10">
                <div class="flex gap-4 items-center">
                    <div class="w-12 h-12 bg-green-50 text-green-500 rounded-xl flex items-center justify-center text-2xl shadow-inner">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div>
                        <h3 class="text-gray-400 text-xs font-bold uppercase tracking-wider">Mis Dietas</h3>
                        <div class="text-3xl font-black text-gray-800" id="contadorDietas">
                            {{ $totalMenusUsuario }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex gap-3 mt-auto relative z-10">
                <button onclick="generarDieta()" class="flex-1 bg-green-50 hover:bg-green-500 text-green-600 hover:text-white py-2.5 rounded-xl text-sm font-bold transition-all flex justify-center items-center gap-2">
                    <i class="fas fa-magic"></i> Generar
                </button>
                <button onclick="verDietas()" class="flex-1 bg-gray-50 hover:bg-gray-800 text-gray-600 hover:text-white py-2.5 rounded-xl text-sm font-bold transition-all flex justify-center items-center gap-2">
                    <i class="fas fa-eye"></i> Ver todas
                </button>
            </div>
        </div>

        <!-- Card 2: Objetivos -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col relative overflow-hidden group hover:shadow-md transition-all">
            <i class="fas fa-bullseye absolute -right-6 -bottom-6 text-8xl text-blue-50 opacity-50 group-hover:scale-110 transition-transform duration-500"></i>
            <div class="flex items-start justify-between mb-6 relative z-10">
                <div class="flex gap-4 items-center">
                    <div class="w-12 h-12 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center text-2xl shadow-inner">
                        <i class="fas fa-flag-checkered"></i>
                    </div>
                    <div>
                        <h3 class="text-gray-400 text-xs font-bold uppercase tracking-wider">Objetivos</h3>
                        <div class="text-3xl font-black text-gray-800" id="contadorObjetivos">
                            {{ $totalObjetivosUsuario ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex gap-3 mt-auto relative z-10">
                <button onclick="abrirModalAsignarObjetivos()" class="flex-1 bg-blue-50 hover:bg-blue-500 text-blue-600 hover:text-white py-2.5 rounded-xl text-sm font-bold transition-all flex justify-center items-center gap-2">
                    <i class="fas fa-plus"></i> Asignar
                </button>
                <button onclick="abrirModalVerObjetivos()" class="flex-1 bg-gray-50 hover:bg-gray-800 text-gray-600 hover:text-white py-2.5 rounded-xl text-sm font-bold transition-all flex justify-center items-center gap-2">
                    <i class="fas fa-list"></i> Revisar
                </button>
            </div>
        </div>

        <!-- Card 3: Preferencias -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col relative overflow-hidden group hover:shadow-md transition-all">
            <i class="fas fa-heart absolute -right-6 -bottom-6 text-8xl text-red-50 opacity-50 group-hover:scale-110 transition-transform duration-500"></i>
            <div class="flex items-start justify-between mb-6 relative z-10">
                <div class="flex gap-4 items-center">
                    <div class="w-12 h-12 bg-red-50 text-red-500 rounded-xl flex items-center justify-center text-2xl shadow-inner">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <div>
                        <h3 class="text-gray-400 text-xs font-bold uppercase tracking-wider">Preferencias</h3>
                        <div class="text-3xl font-black text-gray-800" id="contadorPreferencias">
                            {{ $totalPreferenciasUsuario ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex gap-3 mt-auto relative z-10">
                <button onclick="abrirModalAsignarPreferencias()" class="flex-1 bg-red-50 hover:bg-red-500 text-red-600 hover:text-white py-2.5 rounded-xl text-sm font-bold transition-all flex justify-center items-center gap-2">
                    <i class="fas fa-plus"></i> Asignar
                </button>
                <button onclick="abrirModalVerPreferencias()" class="flex-1 bg-gray-50 hover:bg-gray-800 text-gray-600 hover:text-white py-2.5 rounded-xl text-sm font-bold transition-all flex justify-center items-center gap-2">
                    <i class="fas fa-list"></i> Revisar
                </button>
            </div>
        </div>
    </div>

    <!-- Sección de Progreso (Card Principal) -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden w-full">
        <!-- Header -->
        <div class="p-6 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h3 class="text-xl font-bold text-gray-800 flex items-center">
                <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center mr-3">
                    <i class="fas fa-chart-line"></i>
                </div>
                Mi Evolución
            </h3>
            <button onclick="exportarReporte()" class="bg-purple-50 hover:bg-purple-100 text-purple-600 font-bold px-5 py-2 rounded-xl text-sm transition-colors flex items-center gap-2 self-start md:self-auto">
                <i class="fas fa-download"></i> Exportar Reporte
            </button>
        </div>

        <div class="p-6">
            <div id="progresoContent" class="space-y-6">
                
                <!-- Estado de Carga -->
                <div id="progresoLoading" class="text-center py-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-purple-500 mx-auto"></div>
                    <p class="text-gray-500 mt-4 font-medium">Sincronizando tus métricas...</p>
                </div>

                <!-- Contenido Real -->
                <div id="progresoData" class="hidden space-y-8">
                    <!-- 4 Métricas Clave -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-gray-50/50 border border-gray-100 p-5 text-center rounded-2xl">
                            <div class="text-gray-400 mb-1"><i class="fas fa-weight"></i></div>
                            <div id="pesoPerdido" class="text-2xl md:text-3xl font-black text-green-600 truncate">-0kg</div>
                            <div class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Peso perdido</div>
                        </div>
                        <div class="bg-gray-50/50 border border-gray-100 p-5 text-center rounded-2xl">
                            <div class="text-gray-400 mb-1"><i class="fas fa-fire"></i></div>
                            <div id="reduccionGrasa" class="text-2xl md:text-3xl font-black text-red-500 truncate">-0%</div>
                            <div class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Reducción grasa</div>
                        </div>
                        <div class="bg-gray-50/50 border border-gray-100 p-5 text-center rounded-2xl">
                            <div class="text-gray-400 mb-1"><i class="fas fa-dumbbell"></i></div>
                            <div id="gananciaMuscular" class="text-2xl md:text-3xl font-black text-indigo-500 truncate">+0kg</div>
                            <div class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Masa muscular</div>
                        </div>
                        <div class="bg-gray-50/50 border border-gray-100 p-5 text-center rounded-2xl">
                            <div class="text-gray-400 mb-1"><i class="fas fa-heartbeat"></i></div>
                            <div id="mejoraIMC" class="text-2xl md:text-3xl font-black text-teal-500 truncate">+0</div>
                            <div class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Mejora IMC</div>
                        </div>
                    </div>

                    <!-- Gráfico -->
                    <div class="bg-white border border-gray-100 p-6 rounded-2xl shadow-sm">
                        <h4 class="font-bold text-gray-700 mb-4 text-sm uppercase tracking-wider flex items-center gap-2">
                            <i class="fas fa-chart-area text-purple-400"></i> Historial de Peso
                        </h4>
                        <div id="pesoChart" class="h-48 md:h-60 flex items-end justify-between space-x-2 md:space-x-3 px-2 overflow-x-auto">
                            <!-- El gráfico se generará dinámicamente -->
                        </div>
                    </div>

                    <!-- Metas y Estados -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-white border border-gray-100 p-6 rounded-2xl shadow-sm">
                            <h4 class="font-bold text-gray-700 mb-4 text-sm uppercase tracking-wider">Mis Metas de Salud</h4>
                            <div id="metasList" class="space-y-3">
                                <!-- Metas dinámicas -->
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div class="bg-blue-50/50 p-5 rounded-2xl border border-blue-100">
                                <h4 class="font-bold text-blue-800 mb-3 text-sm">Punto de Partida</h4>
                                <div id="estadoInicial" class="text-sm text-gray-700"></div>
                            </div>
                            <div class="bg-green-50/50 p-5 rounded-2xl border border-green-100">
                                <h4 class="font-bold text-green-800 mb-3 text-sm">Estado Actual</h4>
                                <div id="estadoActual" class="text-sm text-gray-700"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ESTADO VACÍO (Reemplaza al error rojo antiguo) -->
                <div id="progresoError" class="hidden flex-col items-center justify-center py-12 text-center">
                    <div class="w-24 h-24 bg-purple-50 rounded-full flex items-center justify-center mx-auto mb-6 text-purple-400 shadow-inner">
                        <i class="fas fa-weight scale-110 text-5xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">¡Comienza tu transformación!</h3>
                    <p id="errorMessage" class="text-gray-500 max-w-sm mx-auto mb-6 text-sm leading-relaxed">
                        Aún no tenemos registros suficientes para calcular tu progreso. Necesitas registrar tus medidas para desbloquear tus métricas.
                    </p>
                    <button onclick="cargarProgreso()" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-8 rounded-xl shadow-md transition-all flex items-center gap-2 mx-auto">
                        <i class="fas fa-sync-alt"></i> Actualizar Sistema
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>


<!-- ========================================== -->
<!-- MODALES (Estilo Premium con Backdrop-blur) -->
<!-- ========================================== -->

<!-- Modal Asignar Objetivos -->
<div id="asignarObjetivosModal" class="fixed inset-0 z-50 hidden">
    <div class="modal-backdrop fixed inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="closeModal('asignarObjetivosModal')"></div>
    <div class="fixed inset-0 flex items-start sm:items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[85vh] overflow-hidden flex flex-col relative z-10">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-800 flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-50 text-green-500 rounded-xl flex items-center justify-center"><i class="fas fa-bullseye"></i></div>
                    Asignar Objetivos
                </h3>
                <button onclick="closeModal('asignarObjetivosModal')" class="text-gray-400 hover:text-red-500 bg-gray-50 hover:bg-red-50 p-2 rounded-full transition-colors"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-6 overflow-y-auto flex-1 custom-scrollbar">
                <div id="loadingObjetivos" class="text-center py-12"><i class="fas fa-spinner fa-spin text-3xl text-green-500"></i><p class="text-gray-500 mt-4">Cargando catálogo...</p></div>
                <div id="listaObjetivos" class="space-y-3 hidden"></div>
                <div id="errorObjetivos" class="text-center py-8 hidden"><i class="fas fa-exclamation-triangle text-3xl text-red-500 mb-3"></i><p class="text-gray-600">Error al cargar</p></div>
            </div>
            <div class="p-6 border-t border-gray-100 bg-gray-50 flex gap-3">
                <button type="button" onclick="closeModal('asignarObjetivosModal')" class="flex-1 bg-white border border-gray-200 text-gray-700 py-3 rounded-xl hover:bg-gray-100 font-bold transition-colors">Cancelar</button>
                <button type="button" onclick="guardarObjetivos()" class="flex-1 bg-green-500 hover:bg-green-600 text-white py-3 rounded-xl font-bold transition-colors shadow-md"><i class="fas fa-save mr-2"></i> Guardar Selección</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ver Objetivos Seleccionados -->
<div id="verObjetivosModal" class="fixed inset-0 z-50 hidden">
    <div class="modal-backdrop fixed inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="closeModal('verObjetivosModal')"></div>
    <div class="fixed inset-0 flex items-start sm:items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[85vh] overflow-hidden flex flex-col relative z-10">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-800 flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center"><i class="fas fa-list-check"></i></div>
                    Mis Objetivos Activos
                </h3>
                <button onclick="closeModal('verObjetivosModal')" class="text-gray-400 hover:text-red-500 bg-gray-50 hover:bg-red-50 p-2 rounded-full transition-colors"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-6 overflow-y-auto flex-1 custom-scrollbar">
                <div id="loadingVerObjetivos" class="text-center py-12"><i class="fas fa-spinner fa-spin text-3xl text-blue-500"></i><p class="text-gray-500 mt-4">Consultando datos...</p></div>
                <div id="listaVerObjetivos" class="space-y-3 hidden"></div>
                <div id="sinObjetivos" class="text-center py-12 hidden">
                    <i class="fas fa-flag-checkered text-5xl text-gray-200 mb-4"></i>
                    <p class="text-gray-500 font-medium">Aún no tienes objetivos trazados.</p>
                </div>
                <div id="errorVerObjetivos" class="text-center py-8 hidden"><p class="text-red-500">Error de carga</p></div>
            </div>
            <div class="p-6 border-t border-gray-100 bg-gray-50 flex gap-3">
                <button type="button" onclick="closeModal('verObjetivosModal')" class="flex-1 bg-white border border-gray-200 text-gray-700 py-3 rounded-xl hover:bg-gray-100 font-bold transition-colors">Cerrar</button>
                <button type="button" onclick="abrirModalAsignarObjetivos()" class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-xl font-bold transition-colors shadow-md"><i class="fas fa-plus mr-2"></i> Sumar Objetivo</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Asignar Preferencias -->
<div id="asignarPreferenciasModal" class="fixed inset-0 z-50 hidden">
    <div class="modal-backdrop fixed inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="closeModal('asignarPreferenciasModal')"></div>
    <div class="fixed inset-0 flex items-start sm:items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[85vh] overflow-hidden flex flex-col relative z-10">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-800 flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-50 text-red-500 rounded-xl flex items-center justify-center"><i class="fas fa-heart"></i></div>
                    Tus Gustos y Restricciones
                </h3>
                <button onclick="closeModal('asignarPreferenciasModal')" class="text-gray-400 hover:text-red-500 bg-gray-50 hover:bg-red-50 p-2 rounded-full transition-colors"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-6 overflow-y-auto flex-1 custom-scrollbar">
                <div id="loadingPreferencias" class="text-center py-12"><i class="fas fa-spinner fa-spin text-3xl text-red-500"></i><p class="text-gray-500 mt-4">Cargando base de datos...</p></div>
                <div id="listaPreferencias" class="space-y-3 hidden"></div>
                <div id="errorPreferencias" class="text-center py-8 hidden"><p class="text-red-500">Error</p></div>
            </div>
            <div class="p-6 border-t border-gray-100 bg-gray-50 flex gap-3">
                <button type="button" onclick="closeModal('asignarPreferenciasModal')" class="flex-1 bg-white border border-gray-200 text-gray-700 py-3 rounded-xl hover:bg-gray-100 font-bold transition-colors">Cancelar</button>
                <button type="button" onclick="guardarPreferencias()" class="flex-1 bg-red-500 hover:bg-red-600 text-white py-3 rounded-xl font-bold transition-colors shadow-md"><i class="fas fa-save mr-2"></i> Guardar Preferencias</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ver Preferencias Seleccionados -->
<div id="verPreferenciasModal" class="fixed inset-0 z-50 hidden">
    <div class="modal-backdrop fixed inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="closeModal('verPreferenciasModal')"></div>
    <div class="fixed inset-0 flex items-start sm:items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[85vh] overflow-hidden flex flex-col relative z-10">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-800 flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-50 text-red-500 rounded-xl flex items-center justify-center"><i class="fas fa-heartbeat"></i></div>
                    Mis Preferencias Activas
                </h3>
                <button onclick="closeModal('verPreferenciasModal')" class="text-gray-400 hover:text-red-500 bg-gray-50 hover:bg-red-50 p-2 rounded-full transition-colors"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-6 overflow-y-auto flex-1 custom-scrollbar">
                <div id="loadingVerPreferencias" class="text-center py-12"><i class="fas fa-spinner fa-spin text-3xl text-red-500"></i><p class="text-gray-500 mt-4">Consultando tu perfil...</p></div>
                <div id="listaVerPreferencias" class="space-y-3 hidden"></div>
                <div id="sinPreferencias" class="text-center py-12 hidden">
                    <i class="fas fa-apple-alt text-5xl text-gray-200 mb-4"></i>
                    <p class="text-gray-500 font-medium">Aún no has indicado tus preferencias alimenticias.</p>
                </div>
            </div>
            <div class="p-6 border-t border-gray-100 bg-gray-50">
                <button type="button" onclick="closeModal('verPreferenciasModal')" class="w-full bg-white border border-gray-200 text-gray-700 py-3 rounded-xl hover:bg-gray-100 font-bold transition-colors">Volver</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Generar Dieta -->
<div id="modal-preferencia" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm hidden z-50 flex items-start sm:items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col relative z-10">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-purple-50/30">
            <h3 class="text-xl font-bold text-purple-700 flex items-center gap-3">
                <div class="w-10 h-10 bg-purple-100 text-purple-500 rounded-xl flex items-center justify-center"><i class="fas fa-magic"></i></div>
                Asistente Nutricional IA
            </h3>
            
            <!-- NUEVO BOTÓN "X" PARA CERRAR EL MODAL -->
            <button type="button" onclick="cerrarModal()" class="text-gray-400 hover:text-red-500 hover:bg-red-50 p-2 rounded-full transition-colors focus:outline-none flex items-center justify-center w-10 h-10 shadow-sm bg-white border border-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            
        </div>
        <div id="resultado-preferencia" class="mt-2 px-6"></div>
        <div class="flex-1 overflow-y-auto px-6 pb-6 custom-scrollbar" id="modal-contenido">
            <!-- Contenido dinámico Gemini -->
        </div>
    </div>
</div>

<!-- Modal Mis Dietas -->
<div id="dietasModal" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col relative z-10">
        <!-- Cabecera -->
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-3">
                <div class="w-10 h-10 bg-green-50 text-green-500 rounded-xl flex items-center justify-center"><i class="fas fa-book-open"></i></div>
                Mi Historial de Dietas
            </h3>
            <button onclick="cerrarDietas()" class="text-gray-400 hover:text-red-500 bg-gray-50 hover:bg-red-50 p-2 rounded-full transition-colors"><i class="fas fa-times"></i></button>
        </div>
        
        <!-- Contenido -->
        <div id="dietasContent" class="flex-1 p-6 overflow-y-auto custom-scrollbar bg-gray-50/50">
            <div class="text-center py-16"><i class="fas fa-spinner fa-spin text-4xl text-green-500 mb-4"></i><p class="text-gray-500 font-medium">Cargando tus planes de alimentación...</p></div>
        </div>

        <!-- 👇 NUEVO FOOTER ESTILO "OBJETIVOS" 👇 -->
        <div class="p-6 border-t border-gray-100 bg-gray-50 flex gap-3">
            <button type="button" onclick="cerrarDietas()" class="flex-1 bg-white border border-gray-200 text-gray-700 py-3 rounded-xl hover:bg-gray-100 font-bold transition-colors">
                Cerrar
            </button>
            <button type="button" onclick="cerrarDietas(); generarDieta();" class="flex-1 bg-green-500 hover:bg-green-600 text-white py-3 rounded-xl font-bold transition-colors shadow-md">
                <i class="fas fa-magic mr-2"></i> Generar Nueva Dieta
            </button>
        </div>
        <!-- 👆 FIN DEL FOOTER 👆 -->
    </div>
</div>
<!-- SAFELIST PARA TAILWIND (Fuerza la carga de colores dinámicos del Asistente IA) -->
<div class="hidden">
    <span class="from-yellow-50 to-yellow-100 border-yellow-200 text-yellow-500 bg-yellow-500 hover:bg-yellow-600 bg-yellow-50 text-yellow-600 text-yellow-400"></span>
    <span class="from-orange-50 to-orange-100 border-orange-200 text-orange-500 bg-orange-500 hover:bg-orange-600 bg-orange-50 text-orange-600 text-orange-400"></span>
    <span class="from-blue-50 to-blue-100 border-blue-200 text-blue-500 bg-blue-500 hover:bg-blue-600 bg-blue-50 text-blue-600 text-blue-400"></span>
</div>

<div id="verPreferenciasModal" class="fixed inset-0 z-50 hidden">
    <div class="modal-backdrop fixed inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="closeModal('verPreferenciasModal')"></div>
    <div class="fixed inset-0 flex items-start sm:items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[85vh] overflow-hidden flex flex-col relative z-10">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-800 flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-50 text-red-500 rounded-xl flex items-center justify-center"><i class="fas fa-heartbeat"></i></div>
                    Mis Preferencias Activas
                </h3>
                <button onclick="closeModal('verPreferenciasModal')" class="text-gray-400 hover:text-red-500 bg-gray-50 hover:bg-red-50 p-2 rounded-full transition-colors"><i class="fas fa-times"></i></button>
            </div>
            
            <div class="p-6 overflow-y-auto flex-1 custom-scrollbar">
                <div id="loadingVerPreferencias" class="text-center py-12"><i class="fas fa-spinner fa-spin text-3xl text-red-500"></i><p class="text-gray-500 mt-4">Consultando tu perfil...</p></div>
                <div id="listaVerPreferencias" class="space-y-3 hidden"></div>
                <div id="sinPreferencias" class="text-center py-12 hidden">
                    <i class="fas fa-apple-alt text-5xl text-gray-200 mb-4"></i>
                    <p class="text-gray-500 font-medium">Aún no has indicado tus preferencias alimenticias.</p>
                </div>
                <div id="errorVerPreferencias" class="text-center py-8 hidden"><p class="text-red-500 font-bold">Error al cargar los datos</p></div>
            </div>
            
            <div class="p-6 border-t border-gray-100 bg-gray-50 flex gap-3">
                <button type="button" onclick="closeModal('verPreferenciasModal')" class="flex-1 bg-white border border-gray-200 text-gray-700 py-3 rounded-xl hover:bg-gray-100 font-bold transition-colors">
                    Cerrar
                </button>
                <button type="button" onclick="closeModal('verPreferenciasModal'); abrirModalAsignarPreferencias();" class="flex-1 bg-red-500 hover:bg-red-600 text-white py-3 rounded-xl font-bold transition-colors shadow-md">
                    <i class="fas fa-plus mr-2"></i> Sumar Preferencia
                </button>
            </div>
        </div>
    </div>
</div>


<!-- ========================================== -->
<!-- SCRIPTS Y LÓGICA (100% INTACTOS) -->
<!-- ========================================== -->
<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    @keyframes bounce-in {
        0% { transform: scale(0.95); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
    .animate-bounce-in { animation: bounce-in 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }
</style>

<script>
    // Función para abrir el modal y cargar objetivos
    function abrirModalAsignarObjetivos() {
        const modal = document.getElementById('asignarObjetivosModal');
        if (modal) {
            modal.classList.remove('hidden');
            cargarObjetivos();
        } else {
            console.error('Modal no encontrado');
        }
    }

    // Función para cargar Objetivos y actualizar contador
    function cargarObjetivos() {
        const loading = document.getElementById('loadingObjetivos');
        const lista = document.getElementById('listaObjetivos');
        const error = document.getElementById('errorObjetivos');

        // Verificar que los elementos existan
        if (!loading || !lista || !error) {
            console.error('Elementos del modal no encontrados');
            return;
        }

        // Mostrar loading, ocultar otros
        loading.classList.remove('hidden');
        lista.classList.add('hidden');
        error.classList.add('hidden');

        // Usar la ruta objetivos.index
        fetch('{{ route("objetivos.index") }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('Respuesta del servidor:', response.status);
            
            if (!response.ok) {
                throw new Error(`Error ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Datos recibidos:', data);
            
            // Verificar si la respuesta fue exitosa
            if (!data.success) {
                throw new Error(data.error || 'Error en la respuesta del servidor');
            }
            
            // Ocultar loading
            if (loading) loading.classList.add('hidden');
            
            // Actualizar el contador de objetivos
            const contador = document.getElementById('contadorObjetivos');
            if (contador && data.total_objetivos_usuario !== undefined) {
                contador.textContent = data.total_objetivos_usuario;
            }
            
            // Mostrar la lista de objetivos
            if (data.objetivos && data.objetivos.length === 0) {
                lista.innerHTML = `
                    <div class="text-center py-4 text-gray-500">
                        <i class="fas fa-inbox text-3xl mb-2"></i>
                        <p>No hay objetivos disponibles</p>
                    </div>
                `;
            } else if (data.objetivos && Array.isArray(data.objetivos)) {
                let html = '';
                data.objetivos.forEach(objetivo => {
                    html += `
                        <div class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <input type="checkbox" id="objetivo_${objetivo.id}" 
                                   value="${objetivo.id}" 
                                   class="mr-3 h-4 w-4 text-green-500 focus:ring-green-400 border-gray-300 rounded">
                            <label for="objetivo_${objetivo.id}" class="flex-1 cursor-pointer">
                                <div class="font-medium text-gray-800">${objetivo.nombre || 'Objetivo'}</div>
                                ${objetivo.descripcion ? `
                                    <div class="text-sm text-gray-600 mt-1">${objetivo.descripcion}</div>
                                ` : ''}
                            </label>
                        </div>
                    `;
                });
                lista.innerHTML = html;
            } else {
                throw new Error('Estructura de datos incorrecta');
            }
            
            // Mostrar lista
            if (lista) lista.classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error al cargar objetivos:', error);
            
            // Manejar errores de forma segura
            if (loading && loading.classList) loading.classList.add('hidden');
            if (error && error.innerHTML) {
                error.innerHTML = `
                    <div class="text-center py-4 text-red-500">
                        <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                        <p>Error: ${error.message}</p>
                        <button onclick="cargarObjetivos()" class="mt-2 text-sm text-blue-500 hover:text-blue-700">
                            Reintentar
                        </button>
                    </div>
                `;
                error.classList.remove('hidden');
            }
        });
    }

    // Función para guardar objetivos
    function guardarObjetivos() {
        const checkboxes = document.querySelectorAll('#listaObjetivos input[type="checkbox"]:checked');
        const objetivosSeleccionados = Array.from(checkboxes).map(checkbox => checkbox.value);
        
        if (objetivosSeleccionados.length === 0) {
            alert('Por favor selecciona al menos un objetivo');
            return;
        }

        // Mostrar loading
        const botonGuardar = document.querySelector('button[onclick="guardarObjetivos()"]');
        const textoOriginal = botonGuardar.innerHTML;
        botonGuardar.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Guardando...';
        botonGuardar.disabled = true;

        // Enviar al servidor
        fetch('{{ route("objetivos.guardar") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                objetivos: objetivosSeleccionados
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                
                // Actualizar contador
                const contador = document.getElementById('contadorObjetivos');
                if (contador) {
                    const actual = parseInt(contador.textContent) || 0;
                    contador.textContent = actual + data.total_asignados;
                }
                
                closeModal('asignarObjetivosModal');
                
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión');
        })
        .finally(() => {
            botonGuardar.innerHTML = textoOriginal;
            botonGuardar.disabled = false;
        });
    }

    
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    // Función para abrir el modal y cargar objetivos seleccionados
    function abrirModalVerObjetivos() {
        document.getElementById('verObjetivosModal').classList.remove('hidden');
        cargarObjetivosSeleccionados();
    }

    // Función para cargar objetivos seleccionados del usuario
    function cargarObjetivosSeleccionados() {
        const loading = document.getElementById('loadingVerObjetivos');
        const lista = document.getElementById('listaVerObjetivos');
        const sinObjetivos = document.getElementById('sinObjetivos');
        const error = document.getElementById('errorVerObjetivos');

        // Mostrar loading, ocultar otros
        loading.classList.remove('hidden');
        lista.classList.add('hidden');
        sinObjetivos.classList.add('hidden');
        error.classList.add('hidden');

        // Cargar objetivos seleccionados
        fetch('{{ route("objetivos.seleccionados") }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            loading.classList.add('hidden');
            
            if (data.success && data.objetivos && data.objetivos.length > 0) {
                let html = '';
                data.objetivos.forEach(objetivo => {
                    html += `
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-4 border border-gray-200 rounded-lg bg-white shadow-sm gap-3">
                            <div class="flex-1">
                                <div class="font-medium text-gray-800">${objetivo.nombre || 'Objetivo'}</div>
                                ${objetivo.descripcion ? `
                                    <div class="text-sm text-gray-600 mt-1">${objetivo.descripcion}</div>
                                ` : ''}
                                <div class="flex items-center mt-2 text-xs text-gray-500">
                                    <i class="fas fa-calendar mr-1"></i>
                                    <span>Asignado: ${objetivo.fecha_asignacion || 'N/A'}</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2 self-start sm:self-auto">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    ${objetivo.estado || 'Activo'}
                                </span>
                                <button onclick="eliminarObjetivo(${objetivo.id})" class="text-red-500 hover:text-red-700 p-1 rounded text-xs sm:text-sm" title="Eliminar objetivo">
                                    <i class="fas fa-trash text-sm"></i> <span class="hidden sm:inline">Eliminar</span>
                                </button>
                            </div>
                        </div>
                    `;
                });
                lista.innerHTML = html;
                lista.classList.remove('hidden');
            } else {
                sinObjetivos.classList.remove('hidden');
            }
        })
        .catch(error => {
            console.error('Error al cargar objetivos seleccionados:', error);
            loading.classList.add('hidden');
            error.innerHTML = `
                <div class="text-center py-4 text-red-500">
                    <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                    <p>Error: ${error.message}</p>
                    <button onclick="cargarObjetivosSeleccionados()" class="mt-2 text-sm text-blue-500 hover:text-blue-700">
                        Reintentar
                    </button>
                </div>
            `;
            error.classList.remove('hidden');
        });
    }

    // Función para eliminar objetivo (opcional)
    function eliminarObjetivo(objetivoId) {
        if (confirm('¿Estás seguro de que quieres eliminar este objetivo?')) {
            fetch(`/objetivos/${objetivoId}/eliminar`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Objetivo eliminado correctamente');
                    cargarObjetivosSeleccionados(); // Recargar la lista
                    
                    // Actualizar contador
                    const contador = document.getElementById('contadorObjetivos');
                    if (contador) {
                        const actual = parseInt(contador.textContent) || 0;
                        contador.textContent = Math.max(0, actual - 1);
                    }
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al eliminar el objetivo');
            });
        }
    }



    // Función para abrir el modal y cargar preferencias
    function abrirModalAsignarPreferencias() {
        const modal = document.getElementById('asignarPreferenciasModal');
        if (modal) {
            modal.classList.remove('hidden');
            cargarPreferencias();
        } else {
            console.error('Modal no encontrado');
        }
    }

    // Función para cargar Preferencias y actualizar contador
    function cargarPreferencias() {
        const loading = document.getElementById('loadingPreferencias');
        const lista = document.getElementById('listaPreferencias');
        const error = document.getElementById('errorPreferencias');

        // Verificar que los elementos existan
        if (!loading || !lista || !error) {
            console.error('Elementos del modal no encontrados');
            return;
        }

        // Mostrar loading, ocultar otros
        loading.classList.remove('hidden');
        lista.classList.add('hidden');
        error.classList.add('hidden');

        // Usar la ruta preferencias.index
        fetch('{{ route("preferencias.index") }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('Respuesta del servidor:', response.status);
            
            if (!response.ok) {
                throw new Error(`Error ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Datos recibidos:', data);
            
            // Verificar si la respuesta fue exitosa
            if (!data.success) {
                throw new Error(data.error || 'Error en la respuesta del servidor');
            }
            
            // Ocultar loading
            if (loading) loading.classList.add('hidden');
            
            // Actualizar el contador de preferencias
            const contador = document.getElementById('contadorPreferencias');
            if (contador && data.total_preferencias_usuario !== undefined) {
                contador.textContent = data.total_preferencias_usuario;
            }
            
            // Mostrar la lista de preferencias
            if (data.preferencias && data.preferencias.length === 0) {
                lista.innerHTML = `
                    <div class="text-center py-4 text-gray-500">
                        <i class="fas fa-inbox text-3xl mb-2"></i>
                        <p>No hay preferencias disponibles</p>
                    </div>
                `;
            } else if (data.preferencias && Array.isArray(data.preferencias)) {
                let html = '';
                data.preferencias.forEach(preferencia => {
                    html += `
                        <div class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                            <input type="checkbox" id="preferencia_${preferencia.id}" 
                                   value="${preferencia.id}" 
                                   class="mr-3 h-4 w-4 text-green-500 focus:ring-green-400 border-gray-300 rounded">
                            <label for="preferencia_${preferencia.id}" class="flex-1 cursor-pointer">
                                <div class="font-medium text-gray-800">${preferencia.tipo || 'Preferencia'}</div>
                                ${preferencia.descripcion ? `
                                    <div class="text-sm text-gray-600 mt-1">${preferencia.descripcion}</div>
                                ` : ''}
                            </label>
                        </div>
                    `;
                });
                lista.innerHTML = html;
            } else {
                throw new Error('Estructura de datos incorrecta');
            }
            
            // Mostrar lista
            if (lista) lista.classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error al cargar preferencias:', error);
            
            // Manejar errores de forma segura
            if (loading && loading.classList) loading.classList.add('hidden');
            if (error && error.innerHTML) {
                error.innerHTML = `
                    <div class="text-center py-4 text-red-500">
                        <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                        <p>Error: ${error.message}</p>
                        <button onclick="cargarPreferencias()" class="mt-2 text-sm text-blue-500 hover:text-blue-700">
                            Reintentar
                        </button>
                    </div>
                `;
                error.classList.remove('hidden');
            }
        });
    }

    // Función para guardar preferencias
    function guardarPreferencias() {
        const checkboxes = document.querySelectorAll('#listaPreferencias input[type="checkbox"]:checked');
        const preferenciasSeleccionados = Array.from(checkboxes).map(checkbox => checkbox.value);
        
        if (preferenciasSeleccionados.length === 0) {
            alert('Por favor selecciona al menos una preferencias');
            return;
        }

        // Mostrar loading
        const botonGuardar = document.querySelector('button[onclick="guardarPreferencias()"]');
        const textoOriginal = botonGuardar.innerHTML;
        botonGuardar.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Guardando...';
        botonGuardar.disabled = true;

        // Enviar al servidor
        fetch('{{ route("preferencias.guardar") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                preferencias: preferenciasSeleccionados
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                
                // Actualizar contador
                const contador = document.getElementById('contadorPreferencias');
                if (contador) {
                    const actual = parseInt(contador.textContent) || 0;
                    contador.textContent = actual + data.total_asignados;
                }
                
                closeModal('asignarPreferenciasModal');
                
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error de conexión');
        })
        .finally(() => {
            botonGuardar.innerHTML = textoOriginal;
            botonGuardar.disabled = false;
        });
    }

    
    
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    // Función para abrir el modal y cargar preferencias seleccionadas
    function abrirModalVerPreferencias() {
        const modal = document.getElementById('verPreferenciasModal');
        if (modal) {
            modal.classList.remove('hidden');
            cargarPreferenciasSeleccionados();
        } else {
            console.error('Modal ver preferencias no encontrado');
        }
    }

    // Función para cargar preferencias seleccionados del usuario
    function cargarPreferenciasSeleccionados() {
        const loading = document.getElementById('loadingVerPreferencias');
        const lista = document.getElementById('listaVerPreferencias');
        const sinPreferencias = document.getElementById('sinPreferencias');
        const error = document.getElementById('errorVerPreferencias');

        if (!loading || !lista || !sinPreferencias || !error) {
            console.error('Elementos del modal ver preferencias no encontrados');
            return;
        }

        // Mostrar loading, ocultar otros
        loading.classList.remove('hidden');
        lista.classList.add('hidden');
        sinPreferencias.classList.add('hidden');
        error.classList.add('hidden');

        // Cargar objetivos seleccionados
        fetch('{{ route("preferencias.seleccionados") }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            loading.classList.add('hidden');
            
            if (data.success && data.preferencias && data.preferencias.length > 0) {
                let html = '';
                data.preferencias.forEach(preferencia => {
                    html += `
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-4 border border-gray-200 rounded-lg bg-white shadow-sm gap-3">
                            <div class="flex-1">
                                <div class="font-medium text-gray-800">${preferencia.tipo || 'preferencia'}</div>
                                ${preferencia.descripcion ? `
                                    <div class="text-sm text-gray-600 mt-1">${preferencia.descripcion}</div>
                                ` : ''}
                                <div class="flex items-center mt-2 text-xs text-gray-500">
                                    <i class="fas fa-calendar mr-1"></i>
                                    <span>Asignado: ${preferencia.fecha || 'N/A'}</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2 self-start sm:self-auto">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    ${preferencia.estado || 'Activo'}
                                </span>
                                <button onclick="eliminarPreferencia(${preferencia.id})" class="text-red-500 hover:text-red-700 p-1 rounded text-xs sm:text-sm" title="Eliminar objetivo">
                                    <i class="fas fa-trash text-sm"></i> <span class="hidden sm:inline">Eliminar</span>
                                </button>
                            </div>
                        </div>
                    `;
                });
                lista.innerHTML = html;
                lista.classList.remove('hidden');
            } else {
                sinPreferencias.classList.remove('hidden');
            }
        })
        .catch(error => {
            console.error('Error al cargar preferencias seleccionados:', error);
            loading.classList.add('hidden');
            error.innerHTML = `
                <div class="text-center py-4 text-red-500">
                    <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                    <p>Error: ${error.message}</p>
                    <button onclick="cargarPreferenciasSeleccionados()" class="mt-2 text-sm text-blue-500 hover:text-blue-700">
                        Reintentar
                    </button>
                </div>
            `;
            error.classList.remove('hidden');
        });
    }

    // Función para eliminar preferencia 
    function eliminarPreferencia(preferenciaId) {
        if (confirm('¿Estás seguro de que quieres eliminar este preferencia?')) {
            fetch(`/preferencias/${preferenciaId}/eliminar`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Preferencia eliminado correctamente');
                    cargarPreferenciasSeleccionados(); // Recargar la lista
                    
                    // Actualizar contador
                    const contador = document.getElementById('contadorPreferencias');
                    if (contador) {
                        const actual = parseInt(contador.textContent) || 0;
                        contador.textContent = Math.max(0, actual - 1);
                    }
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al eliminar el preferencia');
            });
        }
    }


function generarDieta() {
    // Mostrar loading
    mostrarModal(`
        <div class="flex flex-col items-center justify-center py-12 text-center">
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-purple-500 mb-4"></div>
            <h3 class="text-lg font-bold text-gray-700">La Inteligencia Artificial está cocinando tu dieta...</h3>
            <p class="text-sm text-gray-500 mt-2">Analizando tus objetivos y preferencias.</p>
        </div>
    `);

    fetch(`/dashboard/generar-dieta`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error del servidor: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data.mensaje_personalizado) {
                mostrarResultadoPreferencia(data);
                mostrarAlerta('✅ Plan nutricional generado exitosamente', 'success');
            } else {
                mostrarAlerta('❌ No se pudo generar el plan nutricional', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarAlerta('⚠️ Error de conexión con el servidor', 'error');
        });
}

function mostrarResultadoPreferencia(data) {
    const contenidoHTML = generarContenidoHTML(data);
    
    // Siempre mostrar en modal
    mostrarModal(contenidoHTML);
    
    // También mostrar en contenedor principal (solo en escritorio)
    const divResultado = document.getElementById('resultado-preferencia');
    if(divResultado) divResultado.innerHTML = contenidoHTML;
}

function generarContenidoHTML(data) {
    return `
        <div class="space-y-6">
            <!-- Mensaje Personalizado -->
            <div class="bg-gradient-to-r from-purple-50 to-blue-50 border-l-4 border-purple-500 p-4 md:p-6 rounded-lg">
                <div class="flex items-start">
                    <div class="flex-shrink-0 mr-4">
                        <i class="fas fa-robot text-purple-500 text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-purple-700 mb-2 flex items-center">
                            Mensaje de tu Asistente Nutricional
                        </h4>
                        <p class="text-gray-700 text-justify italic leading-relaxed text-sm md:text-base">"${data.mensaje_personalizado}"</p>
                    </div>
                </div>
            </div>

            <!-- Sección de Menús -->
            ${generarSeccionMenus(data)}

            <!-- Información Nutricional -->
            ${generarInformacionNutricional(data)}
        </div>
    `;
}

function generarSeccionMenus(data) {
    return `
        <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
            <!-- Header de Menús -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-4 py-3 border-b border-gray-200">
                <h3 class="font-bold text-gray-800 flex items-center text-sm md:text-base">
                    <i class="fas fa-clipboard-list mr-2 text-green-500"></i>
                    Menús Recomendados del Día
                </h3>
            </div>

            <div class="p-4 space-y-6">
                <!-- Desayuno -->
                ${generarMenuComida(data, 'desayuno', 'Desayuno', 'fas fa-sun', 'yellow', '☀️')}
                
                <!-- Almuerzo -->
                ${generarMenuComida(data, 'almuerzo', 'Almuerzo', 'fas fa-utensils', 'orange', '🍽️')}
                
                <!-- Cena -->
                ${generarMenuComida(data, 'cena', 'Cena', 'fas fa-moon', 'blue', '🌙')}

                <!-- Resumen Calórico -->
                ${data.calorias_totales ? `
                    <div class="bg-gradient-to-r from-red-50 to-orange-50 rounded-lg p-4 border border-red-100">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3">
                            <div class="flex items-center">
                                <i class="fas fa-fire text-red-500 text-xl mr-3"></i>
                                <div>
                                    <div class="font-semibold text-gray-800 text-sm md:text-base">Total Calórico Diario</div>
                                    <div class="text-xs md:text-sm text-gray-600">Suma de todas las comidas seleccionadas</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-xl md:text-2xl font-bold text-red-600">${data.calorias_totales}</div>
                                <div class="text-xs md:text-sm text-gray-500">calorías</div>
                            </div>
                        </div>
                    </div>
                ` : ''}
            </div>
        </div>
    `;
}

function generarMenuComida(data, comida, titulo, icono, color, emoji) {
    let alimentos = data.alimentos_por_comida[comida];
    const calorias = data.calorias_por_comida[comida] || 0;
    
    if (alimentos && !Array.isArray(alimentos)) {
        alimentos = Object.values(alimentos);
    }
    
    const tieneAlimentos = alimentos && Array.isArray(alimentos) && alimentos.length > 0;

    return `
        <div class="border border-gray-200 rounded-lg overflow-hidden">
            <!-- Header del Menú -->
            <div class="bg-gradient-to-r from-${color}-50 to-${color}-100 px-4 py-3 border-b border-${color}-200">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center mr-3 flex-shrink-0 shadow-sm">
                            <i class="${icono} text-${color}-500"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 flex items-center text-sm md:text-base">
                                ${emoji} ${titulo}
                            </h4>
                            <p class="text-xs md:text-sm text-gray-600">${calorias} calorías</p>
                        </div>
                    </div>
                    <button 
                        onclick="seleccionarMenuCompleto('${comida}', [${tieneAlimentos ? alimentos.map(a => a.id).join(',') : ''}],'${calorias}')"
                        class="bg-${color}-500 hover:bg-${color}-600 text-white px-3 sm:px-4 py-2 rounded-lg transition-colors flex items-center justify-center text-xs sm:text-sm w-full md:w-auto shadow-sm"
                        id="btn-menu-${comida}" ${!tieneAlimentos ? 'disabled style="opacity: 0.5; cursor: not-allowed;"' : ''}>
                        <i class="fas fa-check mr-2"></i>
                        Guardar este Menú
                    </button>
                </div>
            </div>

            <!-- Contenido del Menú -->
            <div class="p-4">
                ${!tieneAlimentos ? `
                    <div class="text-center py-6 text-gray-500 text-sm">
                        <i class="fas fa-inbox text-3xl mb-2"></i>
                        <p>No hay alimentos disponibles para ${titulo.toLowerCase()}</p>
                    </div>
                ` : `
                    <div class="grid gap-3">
                        ${alimentos.map(alimento => `
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-100 shadow-sm">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full bg-${color}-50 flex items-center justify-center mr-3 flex-shrink-0">
                                        <i class="fas fa-utensil-spoon text-${color}-500 text-xs"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-800 text-sm md:text-base">${alimento.nombre}</div>
                                        <div class="text-xs text-gray-500">Porción recomendada</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-${color}-600 text-sm md:text-base">${alimento.calorias}</div>
                                    <div class="text-xs text-gray-400">calorías</div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                `}
            </div>
        </div>
    `;
}

function generarInformacionNutricional(data) {
    let infoHTML = '';
    
    if (data.GET || data.calorias_recomendadas || data.objetivos_usuario) {
        infoHTML += `
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
                <!-- Header Información Nutricional -->
                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-4 py-3 border-b border-gray-200">
                    <h3 class="font-bold text-gray-800 flex items-center text-sm md:text-base">
                        <i class="fas fa-chart-pie mr-2 text-indigo-500"></i>
                        Resumen Nutricional
                    </h3>
                </div>

                <div class="p-4 space-y-4">
        `;

        // Métricas Principales
        if (data.GET || data.calorias_recomendadas) {
            infoHTML += `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    ${data.GET ? `
                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-burn text-blue-500 text-xl mr-3"></i>
                                    <div>
                                        <div class="font-semibold text-gray-800 text-sm md:text-base">GET</div>
                                        <div class="text-xs md:text-sm text-gray-600">Gasto Energético Total</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xl md:text-2xl font-bold text-blue-600">${data.GET}</div>
                                    <div class="text-xs md:text-sm text-gray-500">cal</div>
                                </div>
                            </div>
                        </div>
                    ` : ''}
                    
                    ${data.calorias_recomendadas ? `
                        <div class="bg-purple-50 rounded-lg p-4 border border-purple-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-bullseye text-purple-500 text-xl mr-3"></i>
                                    <div>
                                        <div class="font-semibold text-gray-800 text-sm md:text-base">Recomendadas</div>
                                        <div class="text-xs md:text-sm text-gray-600">Calorías meta</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xl md:text-2xl font-bold text-purple-600">${data.calorias_recomendadas}</div>
                                    <div class="text-xs md:text-sm text-gray-500">cal</div>
                                </div>
                            </div>
                        </div>
                    ` : ''}
                </div>
            `;
        }

        // Estado y Diferencia
        if (data.diferencia_calorias !== undefined && data.estado_calorias) {
            const estadoConfig = {
                'óptimo': { color: 'green', icon: 'fa-check-circle' },
                'bajo': { color: 'yellow', icon: 'fa-exclamation-triangle' },
                'alto': { color: 'red', icon: 'fa-exclamation-circle' }
            };
            
            const estado = estadoConfig[data.estado_calorias] || estadoConfig.óptimo;
            
            infoHTML += `
                <div class="bg-${estado.color}-50 rounded-lg p-4 border border-${estado.color}-100">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                        <div class="flex items-center">
                            <i class="fas ${estado.icon} text-${estado.color}-500 text-xl mr-3"></i>
                            <div>
                                <div class="font-semibold text-gray-800 text-sm md:text-base">Estado del Plan</div>
                                <div class="text-xs md:text-sm text-gray-600">Balance calórico proyectado</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg md:text-xl font-bold text-${estado.color}-600 capitalize">${data.estado_calorias}</div>
                            <div class="text-xs md:text-sm font-bold ${data.diferencia_calorias >= 0 ? 'text-green-600' : 'text-red-600'}">
                                ${data.diferencia_calorias >= 0 ? '+' : ''}${data.diferencia_calorias} cal respecto a meta
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        // Objetivos del Usuario
        if (data.objetivos_usuario && data.objetivos_usuario.length > 0) {
            infoHTML += `
                <div class="bg-indigo-50 rounded-lg p-4 border border-indigo-100">
                    <h5 class="font-semibold text-gray-800 mb-3 flex items-center text-sm md:text-base">
                        <i class="fas fa-tasks text-indigo-500 mr-2"></i>
                        Este plan atiende a tus objetivos:
                    </h5>
                    <div class="grid gap-2">
                        ${data.objetivos_usuario.map(objetivo => `
                            <div class="flex items-center p-2 bg-white rounded border border-indigo-100">
                                <i class="fas fa-check-circle text-indigo-400 mr-3"></i>
                                <span class="text-gray-700 text-xs md:text-sm font-medium">${objetivo}</span>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
        }

        infoHTML += `
                </div>
            </div>
        `;
    }
    
    return infoHTML;
}

// Funciones del Modal (se mantienen igual)
function mostrarModal(contenido) {
    const modal = document.getElementById('modal-preferencia');
    const modalContenido = document.getElementById('modal-contenido');
    
    modalContenido.innerHTML = contenido;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function cerrarModal() {
    const modal = document.getElementById('modal-preferencia');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
    location.reload(); // Recargar la página al cerrar para reflejar cambios
}


    function mostrarAlerta(mensaje, tipo = 'info') {
        const tipos = {
            error: 'bg-red-100 border-red-400 text-red-700',
            success: 'bg-green-100 border-green-400 text-green-700',
            info: 'bg-blue-100 border-blue-400 text-blue-700'
        };
        
        const iconos = {
            error: 'fa-exclamation-triangle',
            success: 'fa-check-circle',
            info: 'fa-info-circle'
        };
        
        const alertaHTML = `
            <div class="border-l-4 ${tipos[tipo]} p-4 mb-4 rounded-lg shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0 mt-0.5">
                        <i class="fas ${iconos[tipo]}"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">${mensaje}</p>
                    </div>
                </div>
            </div>
        `;
        
        // Insertar al inicio del contenedor de resultados (si existe)
        const divResultado = document.getElementById('resultado-preferencia');
        if(divResultado) {
            divResultado.innerHTML = alertaHTML;
            // Auto-remover después de 5 segundos
            setTimeout(() => {
                if (divResultado.innerHTML === alertaHTML) {
                    divResultado.innerHTML = '';
                }
            }, 5000);
        } else {
            // Fallback si no existe el contenedor
            alert(mensaje);
        }
    }

    // Mejora: Cerrar modal con ESC key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modalPref = document.getElementById('modal-preferencia');
            if(modalPref && !modalPref.classList.contains('hidden')){
                cerrarModal();
            }
        }
    });

    // Mejora: Cerrar modal haciendo click fuera del contenido
    document.getElementById('modal-preferencia').addEventListener('click', function(event) {
        // Solo cerrar si el clic fue directamente en el fondo gris oscuro
        if (event.target === this) {
            cerrarModal();
        }
    });

let menusSeleccionados = {};

function seleccionarMenuCompleto(tipoMenu, alimentosIds, calorias) {
    const boton = document.getElementById(`btn-menu-${tipoMenu}`);
    
    // Verificar si el menú ya está seleccionado
    if (menusSeleccionados[tipoMenu]) {
        // Deseleccionar menú
        delete menusSeleccionados[tipoMenu];
        boton.classList.remove('bg-gray-500', 'hover:bg-gray-600');
        boton.classList.add(`bg-${getColorByTipo(tipoMenu)}-500`, `hover:bg-${getColorByTipo(tipoMenu)}-600`);
        boton.innerHTML = '<i class="fas fa-check mr-2"></i> Guardar este Menú';
    } else {
        // Seleccionar menú
        menusSeleccionados[tipoMenu] = {
            tipo: tipoMenu,
            calorias : calorias,
            alimentos: alimentosIds,
            fecha: new Date().toISOString().split('T')[0] // Fecha actual
        };
        boton.classList.remove(`bg-${getColorByTipo(tipoMenu)}-500`, `hover:bg-${getColorByTipo(tipoMenu)}-600`);
        boton.classList.add('bg-gray-500', 'hover:bg-gray-600');
        boton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Guardando...';
        
        // GUARDAR AUTOMÁTICAMENTE al seleccionar
        guardarMenuSeleccionado(tipoMenu, alimentosIds,calorias);
    }
}

// Función para guardar el menú en el backend
async function guardarMenuSeleccionado(tipoMenu, alimentosIds, calorias) {
    try {
        const response = await fetch('/menus', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                tipo: tipoMenu,
                fecha_asignacion: new Date().toISOString().split('T')[0],
                alimentos: alimentosIds,
                calorias : calorias
            })
        });
        
        const result = await response.json();
        const boton = document.getElementById(`btn-menu-${tipoMenu}`);
        
        if (result.success) {
            console.log(`✅ Menú ${tipoMenu} guardado correctamente`);
            boton.innerHTML = '<i class="fas fa-check-circle mr-2"></i> ¡Menú Guardado!';
            boton.classList.remove('bg-gray-500', 'hover:bg-gray-600');
            boton.classList.add('bg-green-500', 'hover:bg-green-600');
            // No revertimos, lo dejamos en verde indicando éxito
        } else {
            console.error('Error al guardar menú:', result.message);
            alert(`Error al guardar menú: ${result.message}`);
            
            // Revertir selección si hay error
            delete menusSeleccionados[tipoMenu];
            boton.classList.remove('bg-gray-500', 'hover:bg-gray-600', 'bg-green-500', 'hover:bg-green-600');
            boton.classList.add(`bg-${getColorByTipo(tipoMenu)}-500`, `hover:bg-${getColorByTipo(tipoMenu)}-600`);
            boton.innerHTML = '<i class="fas fa-check mr-2"></i> Guardar este Menú';
        }
    } catch (error) {
        console.error('Error de conexión:', error);
        alert('Error de conexión al guardar el menú');
        
        // Revertir selección si hay error de conexión
        const boton = document.getElementById(`btn-menu-${tipoMenu}`);
        delete menusSeleccionados[tipoMenu];
        boton.classList.remove('bg-gray-500', 'hover:bg-gray-600', 'bg-green-500', 'hover:bg-green-600');
        boton.classList.add(`bg-${getColorByTipo(tipoMenu)}-500`, `hover:bg-${getColorByTipo(tipoMenu)}-600`);
        boton.innerHTML = '<i class="fas fa-check mr-2"></i> Guardar este Menú';
    }
}

// Función para obtener color por tipo de menú
function getColorByTipo(tipoMenu) {
    const colores = {
        'desayuno': 'yellow',
        'almuerzo': 'orange', 
        'cena': 'blue',
        'otro': 'gray'
    };
    return colores[tipoMenu] || 'gray';
}



// Función para notificaciones
function mostrarNotificacion(mensaje, tipo = 'info') {
    // Puedes usar Toast, SweetAlert, o simplemente un alert
    if (tipo === 'success') {
        alert(`✅ ${mensaje}`);
    } else if (tipo === 'error') {
        alert(`❌ ${mensaje}`);
    } else {
        alert(`ℹ️ ${mensaje}`);
    }
}


function cargarProgreso(pacienteId = null) {
    const loading = document.getElementById('progresoLoading');
    const data = document.getElementById('progresoData');
    const error = document.getElementById('progresoError');
    
    if (!loading || !data || !error) {
        console.error('Elementos del progreso no encontrados');
        return;
    }
    
    loading.classList.remove('hidden');
    loading.classList.add('block'); // Asegurarnos que block reemplaza hidden si es necesario
    data.classList.add('hidden');
    error.classList.remove('flex'); // Cambiamos esto para el nuevo estado vacio
    error.classList.add('hidden');

    let url = '/progreso/datos';
    if (pacienteId) {
        url += `/${pacienteId}`;
    }

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error(`No hay registros`);
            }
            return response.json();
        })
        .then(result => {
            loading.classList.add('hidden');
            if (result.success) {
                renderProgreso(result.data);
                data.classList.remove('hidden');
            } else {
                throw new Error(result.message || 'Error desconocido del servidor');
            }
        })
        .catch(err => {
            console.error('Info:', err);
            loading.classList.add('hidden');
            // Mostrar nuestro nuevo estado vacío bonito
            error.classList.remove('hidden');
            error.classList.add('flex');
        });
}

// Cargar progreso automáticamente al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    cargarProgreso();
});



function renderPesoChart(historialPeso) {
    const chartContainer = document.getElementById('pesoChart');
    if (!chartContainer) return;
    
    chartContainer.innerHTML = '';

    if (!historialPeso || historialPeso.length === 0) {
        chartContainer.innerHTML = '<p class="text-gray-400 text-center text-sm w-full py-8 italic">No hay historial de peso suficiente para graficar.</p>';
        return;
    }

    // Ordenar por fecha para asegurar correcta visualización
    historialPeso.sort((a, b) => new Date(a.fecha_registro) - new Date(b.fecha_registro));
    
    const pesos = historialPeso.map(item => item.peso).filter(peso => peso != null);
    if (pesos.length === 0) {
        chartContainer.innerHTML = '<p class="text-gray-400 text-center text-sm w-full py-8 italic">No hay historial válido de peso.</p>';
        return;
    }

    // Calcular rangos para mejor visualización
    const maxPeso = Math.max(...pesos);
    const minPeso = Math.min(...pesos);
    const rangoTotal = maxPeso - minPeso;
    
    // Ajustar el rango para que no sea demasiado pequeño
    const rangoVisual = rangoTotal > 5 ? rangoTotal : 10;
    const pesoBase = minPeso - 2; // Margen inferior

    // Crear contenedor principal
    const chartWrapper = document.createElement('div');
    chartWrapper.className = 'w-full h-full flex items-end justify-between space-x-2 md:space-x-4 px-2 sm:px-4 pb-6';

    historialPeso.forEach((item, index) => {
        if (item.peso == null) return;
        
        // Calcular altura basada en el rango real
        const alturaPorcentaje = ((item.peso - pesoBase) / rangoVisual) * 90;
        const barContainer = document.createElement('div');
        barContainer.className = 'flex flex-col items-center justify-end flex-1 h-full group relative';
        
        // Barra/Punto principal
        const bar = document.createElement('div');
        const esUltimo = index === historialPeso.length - 1;
        const esPrimero = index === 0;
        
        bar.className = `w-4 sm:w-8 md:w-10 rounded-t-xl transition-all duration-700 cursor-pointer shadow-sm ${
            esUltimo ? 'bg-purple-500' :
            esPrimero ? 'bg-indigo-300' :
            'bg-purple-300'
        } hover:opacity-80`;
        bar.style.height = '0%';
        
        // Valor del peso
        const valueLabel = document.createElement('div');
        valueLabel.className = 'text-[10px] sm:text-sm font-bold text-gray-700 mb-2 transition-all duration-300';
        valueLabel.textContent = `${item.peso}kg`;
        
        // Fecha (Movida abajo)
        const dateLabel = document.createElement('div');
        dateLabel.className = 'absolute -bottom-6 text-[9px] sm:text-xs text-gray-400 text-center font-medium whitespace-nowrap';
        const fecha = new Date(item.fecha_registro);
        dateLabel.textContent = fecha.toLocaleDateString('es-ES', { 
            month: 'short', 
            day: 'numeric' 
        });
        
        barContainer.appendChild(valueLabel);
        barContainer.appendChild(bar);
        barContainer.appendChild(dateLabel);
        chartWrapper.appendChild(barContainer);

        // Animación de entrada
        setTimeout(() => {
            bar.style.height = `${alturaPorcentaje}%`;
        }, index * 100);
    });
    
    chartContainer.appendChild(chartWrapper);
}

function renderMetas(metas) {
    const metasContainer = document.getElementById('metasList');
    if (!metasContainer) return;
    
    metasContainer.innerHTML = '';

    if (!metas || metas.length === 0) {
        metasContainer.innerHTML = '<p class="text-gray-400 text-sm italic py-4 text-center">No has establecido metas aún.</p>';
        return;
    }

    // Ordenar metas: completadas primero, luego por porcentaje descendente
    const metasOrdenadas = metas.sort((a, b) => {
        if (a.completada && !b.completada) return -1;
        if (!a.completada && b.completada) return 1;
        
        const porcentajeA = a.porcentaje !== undefined ? a.porcentaje : Math.min(100, (a.progreso / a.objetivo) * 100);
        const porcentajeB = b.porcentaje !== undefined ? b.porcentaje : Math.min(100, (b.progreso / b.objetivo) * 100);
        
        return porcentajeB - porcentajeA;
    });

    metasOrdenadas.forEach(meta => {
        const isCompleted = meta.completada;
        
        const metaElement = document.createElement('div');
        metaElement.className = `p-4 rounded-xl border transition-all duration-300 ${
            isCompleted ? 'bg-green-50/50 border-green-200' : 'bg-gray-50/50 border-gray-100'
        }`;
        
        metaElement.innerHTML = `
            <div class="flex items-center">
                <div class="flex-shrink-0 mr-4">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center ${
                        isCompleted ? 'bg-green-100 text-green-500' : 'bg-blue-100 text-blue-500'
                    }">
                        <i class="fas ${isCompleted ? 'fa-check' : 'fa-flag'} text-sm"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="font-bold text-sm md:text-base ${
                        isCompleted ? 'text-green-800' : 'text-gray-800'
                    }">
                        ${meta.descripcion}
                    </div>
                    ${meta.objetivo_origen ? `
                        <div class="text-xs text-gray-500 mt-0.5">Asociado a: ${meta.objetivo_origen}</div>
                    ` : ''}
                </div>
            </div>
        `;
        metasContainer.appendChild(metaElement);
    });
}

function renderEstados(estadoInicial, estadoActual) {
    const estadoInicialContainer = document.getElementById('estadoInicial');
    const estadoActualContainer = document.getElementById('estadoActual');

    if (estadoInicialContainer) {
        estadoInicialContainer.innerHTML = estadoInicial ? `
            <div class="space-y-2 mt-2">
                <div class="flex justify-between items-center pb-2 border-b border-blue-100/50">
                    <span class="text-sm text-gray-600">Peso registrado:</span>
                    <span class="text-sm font-black text-gray-800">${estadoInicial.peso} kg</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-500">Fecha del registro:</span>
                    <span class="text-xs font-bold text-gray-600">${new Date(estadoInicial.fecha_registro).toLocaleDateString()}</span>
                </div>
            </div>
        ` : '<p class="text-gray-400 text-sm italic mt-2">No existen registros iniciales.</p>';
    }

    if (estadoActualContainer) {
        estadoActualContainer.innerHTML = estadoActual ? `
            <div class="space-y-2 mt-2">
                <div class="flex justify-between items-center pb-2 border-b border-green-100/50">
                    <span class="text-sm text-gray-600">Peso actual:</span>
                    <span class="text-sm font-black ${
                        estadoActual.peso < estadoInicial?.peso ? 'text-green-600' : 
                        estadoActual.peso > estadoInicial?.peso ? 'text-red-500' : 
                        'text-gray-800'
                    }">${estadoActual.peso} kg</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-500">Última actualización:</span>
                    <span class="text-xs font-bold text-gray-600">${new Date(estadoActual.fecha_registro).toLocaleDateString()}</span>
                </div>
            </div>
        ` : '<p class="text-gray-400 text-sm italic mt-2">Aún no hay actualizaciones.</p>';
    }
}

function renderProgreso(data) {
    // Métricas originales
    safeSetText('pesoPerdido', `${data.metricas.pesoPerdido > 0 ? '-' : ''}${Math.abs(data.metricas.pesoPerdido).toFixed(1)}kg`);    
    safeSetText('reduccionGrasa', `${data.metricas.reduccionGrasa > 0 ? '-' : '+'}${Math.abs(data.metricas.reduccionGrasa).toFixed(1)}%`);
    safeSetText('gananciaMuscular', `${data.metricas.gananciaMuscular > 0 ? '+' : ''}${data.metricas.gananciaMuscular.toFixed(1)}kg`);
    safeSetText('mejoraIMC', `${data.metricas.mejoraIMC > 0 ? '+' : ''}${data.metricas.mejoraIMC.toFixed(2)}`);

    if (data.historialPeso) {
        renderPesoChart(data.historialPeso);
    }

    if (data.metas) {
        renderMetas(data.metas);
    }

    renderEstados(data.estadoInicial, data.estadoActual);
}

function safeSetText(elementId, text) {
    const element = document.getElementById(elementId);
    if (element) {
        element.textContent = text;
    }
}

function verDietas() {
    // Mostrar loading
    document.getElementById('dietasModal').classList.remove('hidden');
    
    // Hacer petición al controlador
    fetch('/mis-dietas')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderDietas(data.data);
            } else {
                mostrarErrorDietasModal('Error al cargar las dietas');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarErrorDietasModal('Error de conexión');
        });
}


function renderDietas(menus) {
    const dietasContainer = document.getElementById('dietasContent');
    
    if (!menus || menus.length === 0) {
        dietasContainer.innerHTML = `
            <div class="text-center py-16">
                <i class="fas fa-utensils text-gray-200 text-6xl mb-4"></i>
                <p class="text-gray-500 font-medium">Aún no has guardado ninguna dieta.</p>
                <button onclick="cerrarDietas(); generarDieta();" class="mt-6 bg-green-500 text-white px-6 py-2 rounded-xl font-bold hover:bg-green-600 transition-colors">Generar mi primera dieta</button>
            </div>
        `;
        return;
    }

    // Agrupar menús por tipo
    const menusPorTipo = {
        'desayuno': [],
        'almuerzo': [], 
        'cena': [],
        'general': []
    };

    menus.forEach(menu => {
        const tipo = menu.tipo || 'general';
        if (menusPorTipo[tipo]) {
            menusPorTipo[tipo].push(menu);
        }
    });

    dietasContainer.innerHTML = `
        <div class="space-y-6">
            ${Object.entries(menusPorTipo).map(([tipo, menusDelTipo]) => {
                if (menusDelTipo.length === 0) return '';
                
                return `
                <div class="border border-gray-100 rounded-2xl p-6 bg-white shadow-sm">
                    <div class="flex items-center mb-6 pb-4 border-b border-gray-50">
                        <div class="w-12 h-12 bg-${getColorTipo(tipo)}-50 text-${getColorTipo(tipo)}-500 rounded-xl flex items-center justify-center text-2xl mr-4">
                            <i class="fas ${getIconoTipo(tipo)}"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-xl capitalize">${tipo}</h4>
                            <p class="text-gray-500 text-sm font-medium">${menusDelTipo.length} opción(es) guardada(s)</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        ${menusDelTipo.map(menu => {
                            const alimentosMenu = menu.alimentos || [];
                            const caloriasTotales = menu.calorias || alimentosMenu.reduce((sum, al) => sum + (al.calorias || 0), 0);
                            
                            // Lógica segura para el sello del nutriólogo (por si decides usarlo después)
                            let badgeHtml = '';
                            if (menu.validado !== undefined) {
                                badgeHtml = (menu.validado == 1 || menu.validado === true) 
                                    ? '<span class="mt-3 bg-green-50 text-green-700 border border-green-200 text-[10px] font-bold px-2 py-1 rounded-md flex items-center w-max"><i class="fas fa-check-circle mr-1 text-green-500"></i> Aprobado por Nutriólogo</span>'
                                    : '<span class="mt-3 bg-yellow-50 text-yellow-700 border border-yellow-200 text-[10px] font-bold px-2 py-1 rounded-md flex items-center w-max"><i class="fas fa-clock mr-1 text-yellow-500"></i> Revisión Pendiente</span>';
                            }
                            
                            return `
                            <div class="border border-gray-100 rounded-xl p-5 bg-gray-50/50 hover:bg-white hover:shadow-md transition-all group relative">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex-1 pr-2">
                                        <h5 class="font-bold text-gray-800 text-lg mb-1">
                                            ${menu.nombre || `Plan de ${tipo}`}
                                        </h5>
                                        <div class="flex items-center text-xs text-gray-400 font-medium">
                                            <i class="fas fa-calendar-alt mr-1"></i>
                                            Guardado el ${new Date(menu.fecha_asignacion).toLocaleDateString('es-ES')}
                                        </div>
                                        ${badgeHtml}
                                    </div>
                                    <div class="flex flex-col items-end gap-2">
                                        <span class="bg-${getColorTipo(tipo)}-100 text-${getColorTipo(tipo)}-700 text-xs font-bold px-3 py-1 rounded-lg h-max">
                                            ${caloriasTotales} kcal
                                        </span>
                                        <button onclick="eliminarDieta(${menu.id})" class="text-red-500 hover:text-white hover:bg-red-500 bg-red-50 px-2 py-1 rounded-lg text-xs font-bold transition-colors flex items-center gap-1 shadow-sm">
                                            <i class="fas fa-trash-alt"></i> Eliminar
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <h6 class="font-bold text-gray-400 text-[10px] uppercase tracking-wider mb-2">
                                        Ingredientes de la porción
                                    </h6>
                                    <div class="space-y-1.5">
                                        ${alimentosMenu.map(alimento => `
                                            <div class="flex justify-between items-center text-sm p-2 bg-white rounded-lg border border-gray-100 group-hover:border-gray-200 transition-colors">
                                                <span class="font-medium text-gray-700">
                                                    ${alimento.alimento?.nombre || 'Alimento'}
                                                </span>
                                                <div class="text-right text-xs font-bold text-gray-400">
                                                    ${alimento.cantidad || ''} ${alimento.unidad || ''}
                                                </div>
                                            </div>
                                        `).join('')}
                                    </div>
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

// Lógica para enviar la orden de borrado a tu base de datos
function eliminarDieta(id) {
    if (confirm('¿Estás seguro de que deseas eliminar esta dieta de tu historial?')) {
        fetch(`/menus/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizamos el contador visual en la tarjeta
                const contador = document.getElementById('contadorDietas');
                if (contador) contador.textContent = data.total_menus;
                
                // Recargamos el modal automáticamente
                verDietas(); 
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al intentar eliminar la dieta');
        });
    }
}
// Funciones auxiliares
function getIconoTipo(tipo) {
    const iconos = {
        'desayuno': 'fa-sun',
        'almuerzo': 'fa-utensils', 
        'cena': 'fa-moon',
        'general': 'fa-apple-alt'
    };
    return iconos[tipo] || 'fa-apple-alt';
}

function getColorTipo(tipo) {
    const colores = {
        'desayuno': 'yellow',
        'almuerzo': 'orange',
        'cena': 'blue',
        'general': 'gray'
    };
    return colores[tipo] || 'gray';
}

function cerrarDietas() {
    document.getElementById('dietasModal').classList.add('hidden');
}

function mostrarErrorDietasModal(mensaje) {
    const dietasContainer = document.getElementById('dietasContent');
    dietasContainer.innerHTML = `
        <div class="text-center py-12 text-red-500">
            <i class="fas fa-exclamation-triangle text-4xl mb-4"></i>
            <p class="font-bold">${mensaje}</p>
        </div>
    `;
}

function eliminarDieta(id) {
    if (confirm('¿Estás seguro de que deseas eliminar esta dieta de tu historial?')) {
        fetch(`/menus/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // 1. Actualizar el contador gigante en la tarjeta principal de dietas
                const contador = document.getElementById('contadorDietas');
                if (contador) {
                    contador.textContent = data.total_menus;
                }
                
                // 2. Recargar la ventana del historial de dietas al instante
                verDietas(); 
                
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al intentar eliminar la dieta');
        });
    }
}

</script>
@endsection