<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($uniforme) ? 'Editar Uniforme' : 'Agregar Uniforme' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .form-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 28px;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 16px;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 5px;
            display: block;
        }

        .form-input,
        .form-textarea,
        .form-select {
            padding: 10px;
            border: 1px solid #e9ecef;
            border-radius: 5px;
            font-size: 16px;
            color: #2c3e50;
            width: 100%;
            box-sizing: border-box;
        }

        .form-textarea {
            height: 100px;
            resize: vertical;
        }

        .form-select {
            appearance: none;
            background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTcgMTBsNS41IDUuNSA1LjUtNS41IiBzdHJva2U9IiM3ZjhjOGQiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIi8+Cjwvc3ZnPgo=');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 24px;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn-primary {
            background-color: #e67e22;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #d35400;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: #fff;
            color: #2c3e50;
            border: 1px solid #e9ecef;
        }

        .btn-secondary:hover {
            background-color: #f5f6fa;
            transform: translateY(-2px);
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .photo-inputs {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>{{ isset($uniforme) ? 'Editar Uniforme' : 'Agregar Uniforme' }}</h1>
        
        <!-- Mostrar errores de validación -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <!-- Mostrar mensaje de éxito -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <!-- Mostrar mensaje de error -->
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        <!-- Formulario -->
        <form action="{{ isset($uniforme) ? route('uniformes.update', $uniforme->id) : route('uniformes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($uniforme))
                @method('PUT')
            @endif
            
            <!-- Campo Nombre -->
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-input" value="{{ old('nombre', $uniforme->nombre ?? '') }}" required>
            </div>
            
            <!-- Campo Descripción -->
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-textarea" required>{{ old('descripcion', $uniforme->descripcion ?? '') }}</textarea>
            </div>
            
            <!-- Campo Categoría -->
            <div class="form-group">
                <label for="categoria">Categoría</label>
                <select name="categoria" id="categoria" class="form-select" required>
                    <option value="">Selecciona una categoría</option>
                    <option value="Industriales" {{ old('categoria', $uniforme->categoria ?? '') == 'Industriales' ? 'selected' : '' }}>Industriales</option>
                    <option value="Médicos" {{ old('categoria', $uniforme->categoria ?? '') == 'Médicos' ? 'selected' : '' }}>Médicos</option>
                    <option value="Escolares" {{ old('categoria', $uniforme->categoria ?? '') == 'Escolares' ? 'selected' : '' }}>Escolares</option>
                    <option value="Corporativos" {{ old('categoria', $uniforme->categoria ?? '') == 'Corporativos' ? 'selected' : '' }}>Corporativos</option>
                </select>
            </div>
            
            <!-- Campo Tipo -->
            <div class="form-group">
                <label for="tipo">Tipo</label>
                <input type="text" name="tipo" id="tipo" class="form-input" value="{{ old('tipo', $uniforme->tipo ?? '') }}" required>
            </div>
            
            <!-- Campo Fotos -->
            <div class="form-group">
                <label>Fotos (puedes seleccionar varias)</label>
                <div id="photo-inputs" class="photo-inputs">
                    <input type="file" name="fotos[]" class="form-input" multiple accept="image/*">
                </div>
                <button type="button" class="btn btn-primary" onclick="addPhotoInput()" style="margin-top: 10px;">Agregar Más Fotos</button>
            </div>
            
            <!-- Botones de acción -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">{{ isset($uniforme) ? 'Actualizar' : 'Guardar' }}</button>
                <a href="{{ route('uniformes.index') }}" class="btn btn-secondary">Ver Lista</a>
            </div>
        </form>
    </div>

    <!-- Script para agregar campos de fotos dinámicamente -->
    <script>
        function addPhotoInput() {
            const photoInputs = document.getElementById('photo-inputs');
            const newInput = document.createElement('input');
            newInput.type = 'file';
            newInput.name = 'fotos[]';
            newInput.className = 'form-input';
            newInput.multiple = true;
            newInput.accept = 'image/*';
            newInput.style.marginTop = '10px';
            photoInputs.appendChild(newInput);
        }
    </script>
</body>
</html>