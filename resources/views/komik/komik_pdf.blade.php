<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komik List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: transparent;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .table-info {
            text-align: left;
            margin-bottom: 20px;
        }

        h1, p {
            color: #3D63D3;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        th {
            background-color: #3D63D3;
            color: #fff;
        }

        tr:hover {
            background-color: #e9ecef;
        }

        .note {
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .note p {
            margin: 0;
            color: #555;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        @media only screen and (max-width: 600px) {
            table {
                font-size: 12px;
            }

            th, td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="note">
            <p>Berikut adalah data komik yang telah dibuat oleh author diplatform Echomic.</p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Komik</th>
                    <th>Rilis</th>
                    <th>Author</th>
                    <th>Total Volume</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($komiks as $no => $komik)
                <tr>
                    <td>{{ $no + 1 }}</td>
                    <td>{{ $komik->judul_komik }}</td>
                    <td>{{ $komik->tgl_rilis }}</td>
                    <td>{{ $komik->user->name }}</td>
                    <td>{{ $komik->volumes_count }}</td> <!-- Menampilkan total volume -->
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
