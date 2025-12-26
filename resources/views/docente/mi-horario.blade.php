<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi Horario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Period Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4">
                    <form method="GET" action="{{ route('docente.mi-horario') }}" class="flex items-end gap-4">
                        <div>
                            <x-input-label for="periodo_id" value="Período Lectivo" />
                            <select id="periodo_id" name="periodo_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" onchange="this.form.submit()">
                                @foreach($periodos as $periodo)
                                    <option value="{{ $periodo->id }}" {{ $periodoId == $periodo->id ? 'selected' : '' }}>
                                        {{ $periodo->nombre }} {{ $periodo->activo ? '(Activo)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-6 gap-2">
                        @php
                            $diasNombres = [
                                'lunes' => 'Lunes',
                                'martes' => 'Martes',
                                'miercoles' => 'Miércoles',
                                'jueves' => 'Jueves',
                                'viernes' => 'Viernes',
                                'sabado' => 'Sábado',
                            ];
                        @endphp
                        
                        @foreach($diasNombres as $dia => $diaNombre)
                            <div class="border rounded-lg">
                                <div class="bg-primary-900 text-white text-center py-2 rounded-t-lg font-medium">
                                    {{ $diaNombre }}
                                </div>
                                <div class="p-2 min-h-[200px]">
                                    @if(!empty($horarioPorDia[$dia]))
                                        @foreach($horarioPorDia[$dia] as $clase)
                                            <div class="bg-secondary-50 border-l-4 border-secondary-500 p-2 mb-2 rounded text-xs">
                                                <p class="font-bold text-primary-900">{{ $clase['unidad'] }}</p>
                                                <p class="text-gray-600">
                                                    {{ \Carbon\Carbon::parse($clase['hora_inicio'])->format('H:i') }} - 
                                                    {{ \Carbon\Carbon::parse($clase['hora_fin'])->format('H:i') }}
                                                </p>
                                                @if($clase['aula'])
                                                    <p class="text-gray-500">Aula: {{ $clase['aula'] }}</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-gray-400 text-center text-xs mt-4">Sin clases</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
