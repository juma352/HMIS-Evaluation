<!DOCTYPE html>
<html>
<head>
    <title>Evaluation Report - {{ $vendorEvaluation->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }
        h1, h2, h3, h4 {
            color: #333;
        }
        h1 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .section:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        .value {
            display: inline-block;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Vendor Evaluation Report</h1>

        <div class="section">
            <h3>General Information</h3>
            <p><span class="label">Vendor Name:</span> <span class="value">{{ $vendorEvaluation->vendor_name }}</span></p>
            <p><span class="label">Form Type:</span> <span class="value">{{ ucfirst(str_replace('_', ' ', $vendorEvaluation->form_type)) }}</span></p>
            <p><span class="label">Evaluator:</span> <span class="value">{{ $vendorEvaluation->user->name }}</span></p>
            <p><span class="label">Evaluation Date:</span> <span class="value">{{ $vendorEvaluation->created_at->format('M d, Y') }}</span></p>
        </div>

        <div class="section">
            <h3>Evaluation Details</h3>
            <table>
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Answer</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vendorEvaluation->evaluation_data as $key => $value)
                        <tr>
                            <td>{{ ucfirst(str_replace('_', ' ', $key)) }}</td>
                            <td>{{ $value }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
