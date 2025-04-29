<!DOCTYPE html>
<html>
<head>
    <title>Lista de Documentos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-size: 12px;
            text-transform: uppercase;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .estado-proceso {
            color: #059669;
            background-color: #d1fae5;
            padding: 4px 8px;
            border-radius: 4px;
            display: inline-block;
        }
        .estado-cancelado {
            color: #dc2626;
            background-color: #fee2e2;
            padding: 4px 8px;
            border-radius: 4px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <h1>Lista de Documentos</h1>
    
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo de Documento</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($documents as $document)
                <tr>
                    <td>{{ $document->nombre }}</td>
                    <td>{{ $document->tipo_documento }}</td>
                    <td>
                        <span class="{{ $document->estado === 'en_proceso' ? 'estado-proceso' : 'estado-cancelado' }}">
                            {{ $document->estado === 'en_proceso' ? 'En Proceso' : 'Cancelado' }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 