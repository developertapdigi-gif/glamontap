<!DOCTYPE html>
<html>
<head>
    <title>Appointment Status Updated</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .header {
            background-color: #4a90e2;
            color: white;
            padding: 20px;
            border-radius: 5px 5px 0 0;
            text-align: center;
        }
        .content {
            padding: 30px;
            background-color: white;
            border-radius: 0 0 5px 5px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 3px;
            font-weight: bold;
        }
        .status-pending { background-color: #ffc107; color: #333; }
        .status-confirmed { background-color: #28a745; color: white; }
        .status-completed { background-color: #007bff; color: white; }
        .status-cancelled { background-color: #dc3545; color: white; }
        .appointment-details {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-left: 4px solid #4a90e2;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Appointment Status Update</h1>
        </div>
        
        <div class="content">
            <p>Dear <strong>{{ $appointment->name }}</strong>,</p>
            
            <p>We are writing to inform you that the status of your appointment has been updated.</p>
            
            <div class="appointment-details">
                <p><strong>Appointment ID:</strong> #{{ $appointment->id }}</p>
                <p><strong>Service:</strong> {{ $appointment->service }}</p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F d, Y') }}</p>
                <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
                <p>
                    <strong>Status Changed:</strong> 
                    <span class="status-badge status-{{ $oldStatus }}">{{ ucfirst($oldStatus) }}</span>
                    → 
                    <span class="status-badge status-{{ $appointment->status }}">{{ ucfirst($appointment->status) }}</span>
                </p>
            </div>
            
            @if($appointment->status == 'confirmed')
                <p><strong>✅ Your appointment has been confirmed!</strong> We look forward to serving you.</p>
            @elseif($appointment->status == 'completed')
                <p><strong>✅ Appointment Completed!</strong> Thank you for choosing our services.</p>
            @elseif($appointment->status == 'cancelled')
                <p><strong>❌ Appointment Cancelled</strong> We apologize for any inconvenience. Please contact us if you need to reschedule.</p>
            @endif
            
            <p>If you have any questions, please don't hesitate to contact us.</p>
            
            <p>Thank you for choosing our services!</p>
        </div>
        
        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} Your Company Name. All rights reserved.</p>
        </div>
    </div>
</body>
</html>