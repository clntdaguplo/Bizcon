<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Consultations Report</title>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            font-size: 12px;
            color: #111827;
            margin: 20px;
        }
        h1 {
            font-size: 20px;
            margin-bottom: 4px;
        }
        h2 {
            font-size: 14px;
            margin-top: 0;
            color: #6b7280;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }
        th, td {
            border: 1px solid #e5e7eb;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background-color: #f3f4f6;
            font-weight: 600;
        }
        tr:nth-child(even) td {
            background-color: #f9fafb;
        }
        .meta {
            font-size: 11px;
            color: #6b7280;
            margin-top: 4px;
        }
        @media print {
            button#print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <button id="print-btn" onclick="window.print()" style="padding:6px 10px;margin-bottom:16px;">
        Print / Save as PDF
    </button>

    <h1>Consultations Report</h1>
    <h2>BizConsult Admin</h2>
    <p class="meta">
        Generated at: {{ now()->format('Y-m-d H:i') }} |
        Total consultations: {{ $consultations->count() }}
    </p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Consultant</th>
                <th>Customer</th>
                <th>Topic</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($consultations as $consultation)
                <tr>
                    <td>{{ $consultation->id }}</td>
                    <td>{{ $consultation->consultantProfile->user->name ?? 'N/A' }}</td>
                    <td>{{ $consultation->customer->name ?? 'N/A' }}</td>
                    <td>{{ $consultation->topic ?? 'N/A' }}</td>
                    <td>{{ $consultation->status ?? 'N/A' }}</td>
                    <td>{{ $consultation->created_at?->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No consultations found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>


