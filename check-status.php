<?php
// Lấy UID hoặc link Facebook từ query string
$uid = isset($_GET['uid']) ? $_GET['uid'] : '';

// Kiểm tra nếu không có UID/link
if (empty($uid)) {
  echo json_encode(['status' => 'ERROR', 'message' => 'UID hoặc link không hợp lệ']);
  exit();
}

// Xử lý link Facebook (tạo URL đầy đủ nếu chưa có)
if (!filter_var($uid, FILTER_VALIDATE_URL)) {
  $uid = 'https://www.facebook.com/' . $uid;
}

// Cấu hình curl để gửi yêu cầu HTTP
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $uid);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // Theo dõi các chuyển hướng (nếu có)
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Bỏ qua kiểm tra SSL (nếu có vấn đề với SSL)

$response = curl_exec($ch);
curl_close($ch);

// Kiểm tra trạng thái
if ($response !== false) {
  // Nếu có nội dung trả về, cho rằng trang là LIVE
  echo json_encode(['status' => 'LIVE']);
} else {
  // Nếu không thể tải trang, cho rằng trang là DIE
  echo json_encode(['status' => 'DIE']);
}
?>
