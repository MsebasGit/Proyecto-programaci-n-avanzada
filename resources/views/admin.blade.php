@extends('layouts.app')

@section('titulo', 'Administración')

@section('contenido')
<h1>Panel de Administración</h1>

@if(session('exito'))
    <div class="alerta-exito">
        {{ session('exito') }}
    </div>
@endif

<!-- SECCION: MATERIAS -->
<div class="caja" style="align-items: flex-start;">
    <h2 class="admin-seccion-titulo">Gestión de Materias (Notas)</h2>

    <!-- Listado de Materias -->
    <div style="flex: 2; min-width: 320px; padding: 0 15px; margin-top: 15px;">
        <h3>Listado de Materias</h3>
        <div class="contenedor-tabla">
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Materia</th>
                        <th>Créditos</th>
                        <th>Nota</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($materias as $materia)
                        <tr style="background: {{ $materia->getColorEstado() }}">
                            <td>{{ $materia->getCodigo() }}</td>
                            <td>{{ $materia->getNombre() }}</td>
                            <td>{{ $materia->getCreditos() }}</td>
                            <td><strong>{{ $materia->getNota() }}</strong></td>
                            <td>
                                <div class="acciones-col">
                                    <a href="{{ route('admin', ['edit_materia_id' => $materia->id]) }}" class="btn-small btn-editar">
                                        Editar
                                    </a>

                                    <form action="{{ route('admin.materias.destroy', $materia->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar la materia {{ addslashes($materia->nombre) }}?')" style="display:inline; margin:0; padding:0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-small btn-eliminar">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No hay materias registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Formularios de Materias -->
    <div style="flex: 1; min-width: 280px; padding: 0 15px; display: flex; flex-direction: column; gap: 20px; margin-top: 15px;">

        @if($editMateria)
            <!-- Formulario: Editar Materia -->
            <form id="form-edit-materia" action="{{ route('admin.materias.update', $editMateria->id) }}" method="POST" style="border: 2px dashed var(--sapphire); padding: 15px; border-radius: 8px;">
                @csrf
                @method('PUT')
                <h3 style="color: var(--sapphire); margin-top: 0;">Editar Materia</h3>

                <label for="edit-materia-nombre">Nombre:</label>
                <input type="text" name="nombre" id="edit-materia-nombre" value="{{ old('nombre', $editMateria->nombre) }}" required>
                @error('nombre')
                    <span class="mensaje-error">{{ $message }}</span>
                @enderror

                <label for="edit-materia-codigo">Código:</label>
                <input type="text" name="codigo" id="edit-materia-codigo" value="{{ old('codigo', $editMateria->codigo) }}" required>
                @error('codigo')
                    <span class="mensaje-error">{{ $message }}</span>
                @enderror

                <label for="edit-materia-creditos">Créditos:</label>
                <input type="number" name="creditos" id="edit-materia-creditos" value="{{ old('creditos', $editMateria->creditos) }}" required min="1">
                @error('creditos')
                    <span class="mensaje-error">{{ $message }}</span>
                @enderror

                <label for="edit-materia-nota">Nota Obtenida:</label>
                <input type="number" step="0.1" name="nota_obtenida" id="edit-materia-nota" value="{{ old('nota_obtenida', $editMateria->nota_obtenida) }}" required min="0" max="100">
                @error('nota_obtenida')
                    <span class="mensaje-error">{{ $message }}</span>
                @enderror

                <button type="submit" style="background-color: var(--sapphire);">Actualizar Materia</button>
                <a href="{{ route('admin') }}" class="btn-cancelar">Cancelar</a>
            </form>
        @else
            <!-- Formulario: Agregar Materia -->
            <form action="{{ route('admin.materias.store') }}" method="POST">
                @csrf
                <h3>Agregar Materia</h3>

                <label for="materia-nombre">Nombre:</label>
                <input type="text" name="nombre" id="materia-nombre" value="{{ old('nombre') }}" required placeholder="Ej. Cálculo I">
                @error('nombre')
                    <span class="mensaje-error">{{ $message }}</span>
                @enderror

                <label for="materia-codigo">Código:</label>
                <input type="text" name="codigo" id="materia-codigo" value="{{ old('codigo') }}" required placeholder="Ej. SIS-101">
                @error('codigo')
                    <span class="mensaje-error">{{ $message }}</span>
                @enderror

                <label for="materia-creditos">Créditos:</label>
                <input type="number" name="creditos" id="materia-creditos" value="{{ old('creditos') }}" required min="1" placeholder="Ej. 4">
                @error('creditos')
                    <span class="mensaje-error">{{ $message }}</span>
                @enderror

                <label for="materia-nota">Nota Obtenida:</label>
                <input type="number" step="0.1" name="nota_obtenida" id="materia-nota" value="{{ old('nota_obtenida') }}" required min="0" max="100" placeholder="Ej. 85.5">
                @error('nota_obtenida')
                    <span class="mensaje-error">{{ $message }}</span>
                @enderror

                <button type="submit">Guardar Materia</button>
            </form>
        @endif

    </div>
</div>

<!-- SECCION: HABILIDADES -->
<div class="caja" style="align-items: flex-start; margin-top: 30px;">
    <h2 class="admin-seccion-titulo">Gestión de Habilidades</h2>

    <!-- Listado de Habilidades -->
    <div style="flex: 2; min-width: 320px; padding: 0 15px; margin-top: 15px;">
        <h3>Listado de Habilidades</h3>
        <div class="contenedor-tabla">
            <table>
                <thead>
                    <tr>
                        <th>Habilidad</th>
                        <th>Porcentaje</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($habilidades as $habilidad)
                        <tr>
                            <td>{{ $habilidad->nombre }}</td>
                            <td><strong>{{ $habilidad->porcentaje }}%</strong></td>
                            <td>
                                <div class="acciones-col">
                                    <a href="{{ route('admin', ['edit_habilidad_id' => $habilidad->id]) }}" class="btn-small btn-editar">
                                        Editar
                                    </a>

                                    <form action="{{ route('admin.habilidades.destroy', $habilidad->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar la habilidad {{ addslashes($habilidad->nombre) }}?')" style="display:inline; margin:0; padding:0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-small btn-eliminar">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No hay habilidades registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Formularios de Habilidades -->
    <div style="flex: 1; min-width: 280px; padding: 0 15px; display: flex; flex-direction: column; gap: 20px; margin-top: 15px;">

        @if($editHabilidad)
            <!-- Formulario: Editar Habilidad -->
            <form id="form-edit-habilidad" action="{{ route('admin.habilidades.update', $editHabilidad->id) }}" method="POST" style="border: 2px dashed var(--sapphire); padding: 15px; border-radius: 8px;">
                @csrf
                @method('PUT')
                <h3 style="color: var(--sapphire); margin-top: 0;">Editar Habilidad</h3>

                <label for="edit-habilidad-nombre">Nombre:</label>
                <input type="text" name="nombre" id="edit-habilidad-nombre" value="{{ old('nombre', $editHabilidad->nombre) }}" required>
                @error('nombre')
                    <span class="mensaje-error">{{ $message }}</span>
                @enderror

                <label for="edit-habilidad-porcentaje">Porcentaje:</label>
                <input type="number" name="porcentaje" id="edit-habilidad-porcentaje" value="{{ old('porcentaje', $editHabilidad->porcentaje) }}" required min="0" max="100">
                @error('porcentaje')
                    <span class="mensaje-error">{{ $message }}</span>
                @enderror

                <button type="submit" style="background-color: var(--sapphire);">Actualizar Habilidad</button>
                <a href="{{ route('admin') }}" class="btn-cancelar">Cancelar</a>
            </form>
        @else
            <!-- Formulario: Agregar Habilidad -->
            <form action="{{ route('admin.habilidades.store') }}" method="POST">
                @csrf
                <h3>Agregar Habilidad</h3>

                <label for="habilidad-nombre">Nombre:</label>
                <input type="text" name="nombre" id="habilidad-nombre" value="{{ old('nombre') }}" required placeholder="Ej. Python">
                @error('nombre')
                    <span class="mensaje-error">{{ $message }}</span>
                @enderror

                <label for="habilidad-porcentaje">Porcentaje:</label>
                <input type="number" name="porcentaje" id="habilidad-porcentaje" value="{{ old('porcentaje') }}" required min="0" max="100" placeholder="Ej. 80">
                @error('porcentaje')
                    <span class="mensaje-error">{{ $message }}</span>
                @enderror

                <button type="submit">Guardar Habilidad</button>
            </form>
        @endif

    </div>
</div>

@endsection
