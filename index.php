<?php
include ('benhnhan/layout/header.php');
?>


  <!-- Section-1 -->

  <div class="section-1">
    <div class="row">
      <div class="col-xl-12">
        <div class="name">
          BỆNH VIỆN ĐA KHOA
        </div>
        <div class="inner-name">
          BARRY MEDICAL
        </div>
      </div>
      <div class="col-xl-12">
        <div class="inner-wrap">
          <div class="inner-work">
            <div class="inner-title">
              Giờ làm việc
            </div>
            <div class="inner-box">
              <div class="inner-time">
                <i class="fa-solid fa-clock"></i>
                <span>Thứ 2 – Thứ 6 &nbsp&nbsp&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 07:00-
                  17:00</span>
              </div>
              <hr>
             <br>
              <div class="inner-time">
                <i class="fa-solid fa-clock"></i>
                <span>Thứ 7 - Chủ nhật &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
                  &nbsp Nghỉ</span>
              </div>
            </div>
          </div>
          <div class="inner-contact">
            <div class="inner-title">
              Chi tiết liên hệ
            </div>
            <div class="inner-box">
              <div class="inner-place">
                <i class="fa-solid fa-location-dot"></i>
                <span>
                  12 Nguyễn Văn Bảo, Phường 4, Quận Gò Vấp, Tp.HCM
                </span>
              </div>
              <a href="https://www.google.com/maps/place/Industrial+University+of+Ho+Chi+Minh+City/@10.821606,106.6872675,17z/data=!4m15!1m8!3m7!1s0x317529d313f06481:0x780176de17d954cb!2zMTIgTmd1eeG7hW4gVsSDbiBC4bqjbywgUGjGsOG7nW5nIDQsIEfDsiBW4bqlcCwgSOG7kyBDaMOtIE1pbmg!3b1!8m2!3d10.821606!4d106.6872675!16s%2Fg%2F11sw08c2s8!3m5!1s0x3174deb3ef536f31:0x8b7bb8b7c956157b!8m2!3d10.8221589!4d106.6868454!16s%2Fm%2F02pyzdj?entry=ttu&g_ep=EgoyMDI0MDgyOC4wIKXMDSoASAFQAw%3D%3D" target="_blank" class="style-a">
                <div class="button">
                  Xem bản đồ
                </div>
              </a>
              
            </div>
          </div>
          <div class="inner-schedule">
            <div class="inner-title">
              Đặt lịch khám bệnh
            </div>
            <div class="inner-box">
              <div class="inner-time  ">
                <i class="fa-solid fa-calendar-days"></i>
                <span>
                  Bất cứ lúc nào bạn cần, chúng tôi đều có mặt.
                </span>
              </div>
              <?php if (isset($_SESSION['dangnhap']) && $_SESSION['dangnhap'] == 1): ?>
                        <a href="/QLBV/benhnhan/page/datlich.php" class="style-a"><div class="button">
                Đặt lịch ngay
              </div></a> <!-- Trang đặt lịch -->
                    <?php else: ?>
                        <a href="/QLBV/benhnhan/auth/login.php" class="style-a"><div class="button">
                Đặt lịch ngay
              </div></a> <!-- Chuyển đến trang đăng nhập -->
                    <?php endif; ?>
              <a href="./benhnhan/auth/login.php" class="style-a">
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Section-1 -->


  <!-- Section-2 -->

  <div class="section-2" id="gioi-thieu">
    <div class="inner-wrap wow fadeInRight">
      <div class="inner-title">
        Điểm khác biệt ở bệnh viện Barry
      </div>
      <div class="inner-dsc">
        Với phương châm "Chọn sức khỏe, chọn để dẫn đầu", chúng tôi luôn cung cấp dịch vụ y tế mới mẻ, hiện đại và đảm bảo chất lượng. Với các thế mạnh:
      </div>
      <div class="inner-bottom">
        <div class="box">
          <img src="assets/images/+.png" alt="">
          <span>Tư vấn miễn phí</span>
        </div>
        <div class="box">
          <img src="assets/images/pay.png" alt="">
          <span>Giá cả phải chăng</span>
        </div>
        <div class="box">
          <img src="assets/images/people.png" alt="">
          <span>Bác sĩ chuyên môn giỏi</span>
        </div>
        <div class="box">
          <img src="assets/images/;ap.png" alt="">
          <span>Nhân viên chuyên nghiệp</span>
        </div>
        <div class="box">
          <img src="assets/images/clock.png" alt="">
          <span>Phục vụ 24/7</span>
        </div>
        <div class="box">
          <img src="assets/images/like.png" alt="">
          <span>Hơn 5000 khách hàng hài lòng</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Section-2 -->


  <!-- Section-3 -->

  <div class="section-3" id="dich-vu">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-8">
          <div class="box-head">
            <div class="inner-title">Dịch vụ y tế của chúng tôi</div>
            <div class="inner-dsc">Chúng tôi cung cấp một loạt các dịch vụ y tế đa dạng, từ chăm sóc tổng quát đến các chuyên khoa cao cấp, bao gồm cả chẩn đoán, điều trị, và phòng ngừa bệnh tật. Khách hàng của chúng tôi có thể yên tâm về sự đa dạng và chất lượng của các dịch vụ y tế mà chúng tôi cung cấp.</div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="inner-wrap wow pulse">
          <div class="box">
            <div class="inner-img">
              <img src="assets/images/tongquat.png" alt="">
            </div>
            <div class="inner-title">
              Khám tổng quát
            </div>
            <div class="inner-dsc"> Khám tổng quát là điểm đến đầu tiên cho sức khỏe toàn diện của bạn</div>
          </div>
          <div class="box">
            <div class="inner-img">
              <img src="assets/images/turyen.png" alt="">
            </div>
            <div class="inner-title">
              Truyền dịch y tế
            </div>
            <div class="inner-dsc">Nơi cung cấp các liệu pháp truyền dịch chất lượng và an toàn, hỗ trợ phục hồi sức khỏe của bệnh nhân một cách toàn diện</div>
          </div>
          <div class="box">
            <div class="inner-img">
              <img src="assets/images/cc.png" alt="">
            </div>
            <div class="inner-title">
              Cấp cứu hồi sức
            </div>
            <div class="inner-dsc">Đối mặt tình huống khẩn cấp, mang lại hy vọng và sự bền bỉ</div>
          </div>
          <div class="box">
            <div class="inner-img">
              <img src="assets/images/do.png" alt="">
            </div>
            <div class="inner-title">
              Đo điện tim
            </div>
            <div class="inner-dsc">Chuyên sâu trong việc đánh giá và theo dõi sức khỏe tim mạch của bệnh nhân, đảm bảo quy trình chẩn đoán chính xác và kịp thời</div>
          </div>
          <div class="box">
            <div class="inner-img">
              <img src="assets/images/chup.png" alt="">
            </div>
            <div class="inner-title">
              Chụp X-quang
            </div>
            <div class="inner-dsc">Cung cấp dịch vụ chụp hình chính xác và nhanh chóng, hỗ trợ chẩn đoán và điều trị các vấn đề y tế một cách hiệu quả.</div>
          </div>
          <div class="box">
            <div class="inner-img">
              <img src="assets/images/xetnghiem.png" alt="">
            </div>
            <div class="inner-title">
              Xét nghiệm máu
            </div>
            <div class="inner-dsc">Tận tâm trong việc đánh giá chất lượng và phân tích dữ liệu máu, hỗ trợ chẩn đoán và theo dõi tình trạng sức khỏe của bệnh nhân với độ chính xác cao</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Section-3 -->



  <!-- Section-5 -->

  <div class="section-5">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="box-head">
            <div class="inner-title">
              Các bác sĩ của chúng tôi
            </div>
            <div class="inner-dsc">
              Với đội ngũ bác sĩ có kinh nghiệm và tận tâm, chúng tôi cam kết mang lại cho bạn dịch vụ y tế chất lượng và an toàn.
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="inner-people">
            <div class="item">
              <div class="inner-img">
                <img src="assets/images/tk.jpg" alt="">
              </div>
              <div class="name">
                Mai Linh
              </div>
              <div class="inner-job">
                Bác sĩ Da liễu
              </div>
            </div>
            <div class="item">
              <div class="inner-img">
                <img src="assets/images/Văn Bình.jpg" alt="">
              </div>
              <div class="name">
                Tấn Đạt
              </div>
              <div class="inner-job">
                Bác sĩ Thẩm mỹ
              </div>
            </div>
            <div class="item">
              <div class="inner-img">
                <img src="assets/images/Văn Bình.jpg" alt="">
              </div>
              <div class="name">
                Duy Khánh
              </div>
              <div class="inner-job">
                Bác sĩ Tai Mũi Họng
              </div>
            </div>
            <div class="item">
              <div class="inner-img">
                <img src="assets/images/Văn Bình.jpg" alt="">
              </div>
              <div class="name">
                Văn Hưng
              </div>
              <div class="inner-job">
                Bác sĩ Mắt
              </div>
            </div>
            <div class="item">
              <div class="inner-img">
                <img src="assets/images/Văn Bình.jpg" alt="">
              </div>
              <div class="name">
                Gia Khánh
              </div>
              <div class="inner-job">
                Bác sĩ Xương khớp
              </div>
            </div>
            <div class="item">
              <div class="inner-img">
                <img src="assets/images/Văn Bình.jpg" alt=""> 
              </div>
              <div class="name">
                Tấn Đạt
              </div>
              <div class="inner-job">
                Bác sĩ Tim mạch
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Section-5 -->


  <!-- Section-6 -->

  <div class="section-6">
    <div class="container">
      <div class="col-12">
        <div class="inner-title">
          Nhận xét của khách hàng
        </div>
      </div>
      <div class="col-12">
        <div class="item">
          <div class="inner-img">
            <img src="assets/images/duymanh.png" alt="">
          </div>
          <div class="inner-rating">
            Những phản hồi tích cực từ khách hàng là động lực quan trọng giúp chúng tôi nâng cao chất lượng dịch vụ. Chúng tôi rất cảm kích về mọi ý kiến đóng góp và cam kết tiếp tục cung cấp sự phục vụ tối ưu cho mọi bệnh nhân.
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Section-6 -->

  <?php
include ('benhnhan/layout/footer.php');
// Nhận thông báo từ URL
$status = $_GET['status'] ?? null;
$message = $_GET['message'] ?? null;

if ($status && $message): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.onload = function () {
            Swal.fire({
                icon: '<?php echo $status === "success" ? "success" : "error"; ?>',
                title: '<?php echo $status === "success" ? "Thành công" : "Lỗi"; ?>',
                text: '<?php echo urldecode($message); ?>',
                confirmButtonText: 'OK'
            });
        };
    </script>
<?php endif; ?>
