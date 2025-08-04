<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan {{ ucfirst($jenis) }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>Laporan {{ ucfirst($jenis) }}</h2>
    <table>
        <thead>
            <tr>
                @foreach (array_keys((array) $data->first()) as $header)
                    <th>{{ ucfirst(str_replace('_', ' ', $header)) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    @foreach ((array) $row as $col)
                        <td>{{ $col }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
