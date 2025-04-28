<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lista de Documentos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
        }
        .status-proceso {
            background-color: #dcfce7;
            color: #166534;
        }
        .status-cancelado {
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Lista de Documentos</h1>
        <p>Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

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
                        <span class="status {{ $document->estado === 'en_proceso' ? 'status-proceso' : 'status-cancelado' }}">
                            {{ $document->estado === 'en_proceso' ? 'En Proceso' : 'Cancelado' }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 