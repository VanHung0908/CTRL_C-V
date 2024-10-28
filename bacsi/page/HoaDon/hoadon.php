
<div class="main-content" id="main-content">
    <h2 class="header-title">Hóa Đơn Thanh Toán</h2>

    <h3 class="section-title">Thông tin bệnh nhân</h3>
    <p class="text"><strong>Tên bệnh nhân:</strong> Châu Duy Khánh</p>
    <p class="text"><strong>Mã bệnh nhân:</strong> 01042003</p>

    <h3 class="section-title">Thông tin xuất viện</h3>
    <p class="text"><strong>Ngày nhập viện:</strong> 01/10/2024</p>
    <p class="text"><strong>Ngày xuất viện:</strong> 25/10/2024</p>
    <p class="text"><strong>Tổng số ngày nằm viện:</strong> 24 ngày</p>

    <h3 class="section-title">Chi tiết chi phí</h3>
    <table class="table-cost">
        <thead>
            <tr>
                <th>Loại chi phí</th>
                <th>Tên</th>
                <th>Số lượng</th>
                <th>Giá (VNĐ)</th>
                <th>Thành tiền (VNĐ)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan="2">Thuốc</td>
                <td>Thuốc giảm đau</td>
                <td>5 viên</td>
                <td>150,000</td>
                <td>750,000</td>
            </tr>
            <tr>
                <td>Kháng sinh</td>
                <td>3 lọ</td>
                <td>250,000</td>
                <td>750,000</td>
            </tr>
            <tr>
                <td>Giường</td>
                <td>Tiền giường</td>
                <td>24 ngày</td>
                <td>120,000</td>
                <td>2,880,000</td>
            </tr>
            <tr>
                <td>Tạm ứng</td>
                <td>Tiền tạm ứng</td>
                <td></td>
                <td></td>
                <td>-1,000,000</td>
            </tr>
            <tr>
                <td>Bảo hiểm y tế</td>
                <td>Bảo hiểm y tế chi trả (80%)</td>
                <td></td>
                <td></td>
                <td>-3,064,000</td>
            </tr>
        </tbody>
    </table>

    <p class="total-amount"><strong>Tổng chi phí:</strong> <span>766,000 VNĐ</span></p>
    <p class="payable-amount"><strong>Số tiền bệnh nhân cần thanh toán:</strong> <span>766,000 VNĐ</span></p>

    <a href="#" class="btn-payment">Thanh toán</a>
</div>

<script>
    const prices = [
        { quantity: 5, unitPrice: 150000 }, 
        { quantity: 3, unitPrice: 250000 }, 
        { quantity: 24, unitPrice: 120000 }, 
        { quantity: 0, unitPrice: 0 }, 
        { quantity: 0, unitPrice: 0 }  
    ];

    let totalCost = 0;
    const totalDrugCost = (prices[0].quantity * prices[0].unitPrice) + (prices[1].quantity * prices[1].unitPrice);
    const bedCost = prices[2].quantity * prices[2].unitPrice;
    const advancePayment = -1000000;
    const insurancePayment = -3064000;

    totalCost = totalDrugCost + bedCost + advancePayment + insurancePayment;

    document.querySelector('.total-amount span').textContent = totalCost.toLocaleString('vi-VN') + ' VNĐ';
    document.querySelector('.payable-amount span').textContent = totalCost.toLocaleString('vi-VN') + ' VNĐ';
</script>

