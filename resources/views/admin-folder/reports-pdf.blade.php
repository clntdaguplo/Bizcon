<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 40px; color: #1f2937; }
        table { width: 100%; border-collapse: collapse; margin-top: 25px; }
        th, td { padding: 12px 8px; border-bottom: 1px solid #e5e7eb; text-align: left; font-size: 12px; }
        th { background-color: #f9fafb; font-weight: 600; text-transform: uppercase; font-size: 11px; letter-spacing: 0.05em; color: #4b5563; border-top: 1px solid #e5e7eb; }
        tr:nth-child(even) { background-color: #f9fafb; }
        .header { margin-bottom: 40px; border-bottom: 2px solid #2563eb; padding-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; color: #111827; }
        .header p { margin: 5px 0 0; color: #6b7280; font-size: 14px; }
        .meta { display: flex; justify-content: space-between; margin-top: 10px; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: bold; }
        .status-completed { background: #d1fae5; color: #065f46; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .footer { position: fixed; bottom: 0; left: 0; width: 100%; text-align: center; font-size: 10px; color: #9ca3af; padding: 20px; border-top: 1px solid #e5e7eb; background: white; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
            .header { margin-top: 0; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px; text-align: right; background: #eff6ff; padding: 15px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
        <span style="font-weight: bold; color: #1e40af;">Running Report...</span>
        <div>
            <button onclick="window.print()" style="padding: 10px 20px; background: #2563eb; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">Save as PDF / Print</button>
            <button onclick="window.close()" style="padding: 10px 20px; background: white; color: #4b5563; border: 1px solid #d1d5db; border-radius: 6px; cursor: pointer; margin-left: 10px;">Close</button>
        </div>
    </div>

    <div class="header">
        <h1>{{ $title }}</h1>
        <div class="meta">
            <p><strong>Range:</strong> {{ $dateRange }}</p>
            <p><strong>Generated:</strong> {{ now()->format('M d, Y H:i:s') }}</p>
        </div>
    </div>



    <table>
        <thead>
            <tr>
                <th style="width: 15%">Date</th>
                <th style="width: 20%">Consultant</th>
                <th style="width: 20%">Customer</th>
                <th style="width: 25%">Topic</th>
                <th style="width: 10%">Status</th>
                <th style="width: 10%">Rating</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $row)
            <tr>
                <td>{{ $row->created_at->format('Y-m-d') }}<br><span style="color:#9ca3af; font-size:10px">{{ $row->created_at->format('H:i') }}</span></td>
                <td>{{ optional($row->consultantProfile->user)->name ?? 'Unknown' }}</td>
                <td>{{ optional($row->customer)->name ?? 'Unknown' }}</td>
                <td>{{ $row->topic }}</td>
                <td>
                    <span class="badge {{ $row->status == 'Completed' ? 'status-completed' : 'status-pending' }}">
                        {{ $row->status }}
                    </span>
                </td>
                <td>{{ optional($row->customerRating)->rating ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 20px; color: #6b7280;">No records found for this period.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if(isset($revenueStats))
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; margin-top: 30px; display: flex; justify-content: space-between;">
        <div style="width: 45%;">
            <h2 style="font-size: 14px; margin: 0 0 10px 0; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">Revenue Summary</h2>
            <p style="font-size: 28px; font-weight: 800; margin: 0; color: #2563eb;">₱{{ number_format($totalRev, 2) }}</p>
        </div>
        <div style="width: 50%;">
            <table style="margin-top: 0; border: none;">
                <tbody>
                    @foreach(['Weekly', 'Quarterly', 'Annual'] as $plan)
                    <tr>
                        <td style="border: none; padding: 4px 0; color: #475569;">{{ $plan }} Plan:</td>
                        <td style="border: none; padding: 4px 0; text-align: right; font-weight: bold; color: #1e293b;">₱{{ number_format($revenueStats->get($plan, 0), 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
    
    <div class="footer">
        Bizcon Platform • Confidential Report • Page <span class="page-number"></span>
    </div>

    <script>
        // Auto-print after slight delay to ensure rendering
        window.onload = function() { 
            setTimeout(function() { 
                // window.print(); 
            }, 800); 
        }
    </script>
</body>
</html>
