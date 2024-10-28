<?php
session_start();

$message = '';
$patientData = [];
$prescription = []; 

function getPatientInfo($patientId) {
    // Sample patient data with diagnoses
    $patients = [
        1 => [
            'name' => 'Nguyễn Văn A',
            'dob' => '1990-01-01',
            'gender' => 'Nam',
            'diagnosis' => 'Viêm phổi', // Diagnosis for Patient A
            'id' => 1
        ],
        2 => [
            'name' => 'Trần Thị B',
            'dob' => '1985-05-15',
            'gender' => 'Nữ',
            'diagnosis' => 'Cúm', // Diagnosis for Patient B
            'id' => 2
        ]
    ];
    return $patients[$patientId] ?? null;
}

$medicinesList = [
    ['id' => 1, 'name' => 'Paracetamol', 'amount' => '500mg'],
    ['id' => 2, 'name' => 'Amoxicillin', 'amount' => '250mg'],
    ['id' => 3, 'name' => 'Ibuprofen', 'amount' => '400mg'],
];

if (isset($_POST['select_patient'])) {
    $patientId = $_POST['patient_id'];
    $patientData = getPatientInfo($patientId);
}

if (isset($_POST['create_treatment_plan'])) {
    $treatmentPlan = [
        'patient_id' => $_POST['patient_id'],
        'medication_date' => $_POST['medication_date'],
        'dosage' => $_POST['dosage'],
        'duration' => $_POST['duration'],
        'notes' => $_POST['notes'],
        'usage' => $_POST['usage'],
        'diagnosis' => $_POST['diagnosis'],
        'recovery_instructions' => $_POST['recovery_instructions'],
        'selected_medicine' => $_POST['medicine_id'] 
    ];

    $message = "Lập phác đồ điều trị cho bệnh nhân thành công.";

    $prescription = [
        'medication_date' => $treatmentPlan['medication_date'],
        'dosage' => $treatmentPlan['dosage'],
        'duration' => $treatmentPlan['duration'],
        'notes' => $treatmentPlan['notes'],
        'usage' => $treatmentPlan['usage'],
        'diagnosis' => $patientData['diagnosis'], // Use the diagnosis from the patient data
        'recovery_instructions' => $treatmentPlan['recovery_instructions'],
        'selected_medicine' => $medicinesList[array_search($treatmentPlan['selected_medicine'], array_column($medicinesList, 'id'))]
    ];
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lập Phác Đồ Điều Trị</title>
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #eef2f5;
        margin: 0;
        padding: 20px;
    }

    .container {
        background: #ffffff;
        max-width: 800px;
        margin: 20px auto;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 6px 30px rgba(0, 0, 0, 0.1);
    }

    h1,
    h2 {
        text-align: center;
        color: #2c3e50;
        margin: 0 0 20px;
    }

    label {
        display: block;
        margin: 8px 0 4px;
        font-weight: bold;
        color: #34495e;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 55px;
        /* Khoảng cách giữa các ô */
        margin-bottom: 20px;
    }

    input[type="text"],
    input[type="date"],
    select,
    textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #bdc3c7;
        border-radius: 5px;
        font-size: 14px;
        color: #2c3e50;
        background-color: #ecf0f1;
        transition: border-color 0.3s, background-color 0.3s;
    }

    input[type="text"]:focus,
    input[type="date"]:focus,
    select:focus,
    textarea:focus {
        border-color: #3498db;
        background-color: #ffffff;
        outline: none;
    }

    button {
        width: 100%;
        padding: 12px;
        background-color: #3498db;
        border: none;
        border-radius: 5px;
        color: white;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        margin-top: 15px;
        transition: background-color 0.3s, transform 0.2s;
    }

    button:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
    }

    .message {
        margin: 20px 0;
        padding: 15px;
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        border-radius: 5px;
        text-align: center;
        font-weight: bold;
    }

    .prescription {
        margin-top: 20px;
        border: 1px solid #17a2b8;
        padding: 15px;
        border-radius: 5px;
        background-color: #f1f9fc;
    }

    .prescription h3 {
        color: #17a2b8;
        margin-top: 0;
    }

    .prescription ul {
        padding-left: 20px;
        list-style: disc;
        color: #2c3e50;
    }

    .tooltip {
        display: none;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
        font-size: 14px;
        color: #333;
    }

    .show-tooltip {
        display: block;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Lập Phác Đồ Điều Trị</h1>

        <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if (empty($patientData)): ?>
        <form method="POST" action="">
            <h2>Chọn bệnh nhân:</h2>
            <select name="patient_id" required>
                <option value="">Chọn bệnh nhân</option>
                <option value="1">Nguyễn Văn A</option>
                <option value="2">Trần Thị B</option>
            </select>
            <button type="submit" name="select_patient">Chọn</button>
        </form>
        <?php else: ?>
        <h2>Thông tin bệnh nhân:</h2>
        <p>Tên: <?php echo $patientData['name']; ?></p>
        <p>Ngày sinh: <?php echo $patientData['dob']; ?></p>
        <p>Giới tính: <?php echo $patientData['gender']; ?></p>

        <form method="POST" action="">
            <input type="hidden" name="patient_id" value="<?php echo $patientData['id']; ?>">

            <h2>Lập phác đồ điều trị:</h2>

            <div class="form-row">
                <div>
                    <label for="medication_date">Ngày phát thuốc:</label>
                    <input type="date" id="medication_date" name="medication_date" value="<?php echo date('Y-m-d'); ?>"
                        required>
                </div>
                <div>
                    <label for="diagnosis">Chẩn đoán:</label>
                    <input type="text" id="diagnosis" name="diagnosis" value="<?php echo $patientData['diagnosis']; ?>"
                        readonly>
                </div>

            </div>

            <div class="form-row">
                <div>
                    <label for="medicine_id">Chọn đơn thuốc:</label>

                    <select name="medicine_id" id="medicine_id" required>
                        <option value="">Chọn thuốc</option>
                        <?php foreach ($medicinesList as $medicine): ?>
                        <option value="<?php echo $medicine['id']; ?>">
                            <?php echo $medicine['name'] . ' - ' . $medicine['amount']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="duration">Thời gian dùng thuốc (ngày):</label>
                    <input type="text" id="dosage" name="dosage" placeholder="Nhập thời gian" required>
                </div>

            </div>

            <div class="form-row">
                <div>
                    <label for="usage">Cách dùng:</label>
                    <textarea id="usage" name="usage" placeholder="Nhập cách dùng thuốc" required></textarea>
                </div>
                <div>
                    <label for="dosage">Liều lượng:</label>
                    <textarea type="text" id="dosage" name="dosage" placeholder="Nhập liều lượng" required></textarea>
                </div>
            </div>

            <div class="form-row">
                <div>
                    <label for="notes">Thông tin lưu ý:</label>
                    <textarea id="notes" name="notes" placeholder="Nhập thông tin lưu ý khi dùng thuốc"></textarea>
                </div>
                <div>
                    <label for="recovery_instructions">Hướng phục hồi:</label>
                    <textarea id="recovery_instructions" name="recovery_instructions" placeholder="Nhập hướng phục hồi"
                        required></textarea>
                </div>
            </div>

            <button type="submit" name="create_treatment_plan">Xác nhận</button>

            <div class="tooltip" id="medicationTooltip">Thông tin về đơn thuốc sẽ được hiển thị ở đây.</div>
        </form>

        <?php if (!empty($prescription)): ?>
        <div class="prescription">
            <h3>Đơn thuốc:</h3>
            <p><strong>Ngày phát thuốc:</strong> <?php echo $prescription['medication_date']; ?></p>
            <p><strong>Liều lượng:</strong> <?php echo $prescription['dosage']; ?></p>
            <p><strong>Cách dùng:</strong> <?php echo $prescription['usage']; ?></p>
            <p><strong>Chẩn đoán:</strong> <?php echo $prescription['diagnosis']; ?></p>
            <p><strong>Hướng phục hồi:</strong> <?php echo $prescription['recovery_instructions']; ?></p>
            <p><strong>Thời gian dùng thuốc:</strong> <?php echo $prescription['duration']; ?> ngày</p>
            <p><strong>Thông tin lưu ý:</strong> <?php echo $prescription['notes']; ?></p>
            <h4>Thuốc kê đơn:</h4>
            <ul>
                <li><?php echo $prescription['selected_medicine']['name'] . ' - ' . $prescription['selected_medicine']['amount']; ?>
                </li>
            </ul>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </div>

    <script>
    const tooltip = document.getElementById('medicationTooltip');
    const button = document.querySelector('button[name="create_treatment_plan"]');

    button.addEventListener('mouseover', function(event) {
        tooltip.style.left = event.pageX + 'px';
        tooltip.style.top = event.pageY + 'px';
        tooltip.classList.add('show-tooltip');
    });

    button.addEventListener('mouseout', function() {
        tooltip.classList.remove('show-tooltip');
    });
    </script>
</body>

</html>