<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Uniformes</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #333; }
        .success { color: green; text-align: center; margin-bottom: 15px; }
        .uniforme { border-bottom: 1px solid #ddd; padding: 10px 0; }
        .uniforme img { width: 50px; height: 50px; object-fit: cover; margin-right: 10px; }
        .actions { margin-top: 10px; }
        .btn { padding: 5px 10px; border-radius: 4px; text-decoration: none; color: white; }
        .btn-edit { background-color: #007bff; }
        .btn-delete { background-color: #dc3545; }
        .btn-add { background-color: #28a745; display: inline-block; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lista de Uniformes</h1>

        @if (session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('uniformes.create') }}" class="btn btn-add">Agregar Nuevo Uniforme</a>

        @if ($uniformes->isEmpty())
            <p>No hay uniformes registrados.</p>
        @else
            @foreach ($uniformes as $uniforme)
                <div class="uniforme">
                    <h3>{{ $uniforme->nombre }}</h3>
                    <p>{{ $uniforme->descripcion }}</p>
                    <p>Categoría: {{ $uniforme->categoria }} | Tipo: {{ $uniforme->tipo }}</p>
                    @if ($uniforme->fotos->isNotEmpty())
                        @foreach ($uniforme->fotos as $foto)
                            <img src="{{ asset('storage/' . $foto->foto_path) }}" alt="{{ $uniforme->nombre }}">
                        @endforeach
                    @endif
                    <div class="actions">
                        <a href="{{ route('uniformes.edit', $uniforme->id) }}" class="btn btn-edit">Editar</a>
                        <form action="{{ route('uniformes.destroy', $uniforme->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete" onclick="return confirm('¿Seguro que deseas eliminar este uniforme?')">Eliminar</button>
                        </form>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</body>
</html>