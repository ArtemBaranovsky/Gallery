<?php
class CropAvatar {
  private $src;
  private $data;
  private $dst;
  private $type;
  private $extension;
  private $msg;
 
  function __construct($src, $data, $file) {
    $this -> setSrc($src);
    $this -> setData($data);
    $this -> setFile($file);
    $this -> crop($this -> src, $this -> dst, $this -> data);
  }
 
  private function setSrc($src) {
    if (!empty($src)) {
      $type = exif_imagetype($src);
 
      if ($type) {
        $this -> src = $src;
        $this -> type = $type;
        $this -> extension = image_type_to_extension($type);
        $this -> setDst();
      }
    }
  }
 
  private function setData($data) {
    if (!empty($data)) {
      $this -> data = json_decode(stripslashes($data));
    }
  }
 
  private function setFile($file) {
    $errorCode = $file['error'];
 
    if ($errorCode === UPLOAD_ERR_OK) {
      $type = exif_imagetype($file['tmp_name']);
 
      if ($type) {
        $extension = image_type_to_extension($type);
        $src = 'img/' . date('YmdHis') . '.original' . $extension;
 
        if ($type == IMAGETYPE_GIF || $type == IMAGETYPE_JPEG || $type == IMAGETYPE_PNG) {
 
          if (file_exists($src)) {
            unlink($src);
          }
 
          $result = move_uploaded_file($file['tmp_name'], $src);
 
          if ($result) {
            $this -> src = $src;
            $this -> type = $type;
            $this -> extension = $extension;
            $this -> setDst();
          } else {
             $this -> msg = '������ ���������� �����';
          }
        } else {
          $this -> msg = '����������, ��������� ����������� ��������� �����: JPG, PNG, GIF';
        }
      } else {
        $this -> msg = '����������, ��������� ���� �����������';
      }
    } else {
      $this -> msg = $this -> codeToMessage($errorCode);
    }
  }
 
  private function setDst() {
    $this -> dst = 'img/' . date('YmdHis') . '.png';
  }
 
  private function crop($src, $dst, $data) {
    if (!empty($src) && !empty($dst) && !empty($data)) {
      switch ($this -> type) {
        case IMAGETYPE_GIF:
          $src_img = imagecreatefromgif($src);
          break;
 
        case IMAGETYPE_JPEG:
          $src_img = imagecreatefromjpeg($src);
          break;
 
        case IMAGETYPE_PNG:
          $src_img = imagecreatefrompng($src);
          break;
      }
 
      if (!$src_img) {
        $this -> msg = "�� ������� ��������� ���� �����������";
        return;
      }
 
      $size = getimagesize($src);
      $size_w = $size[0]; // ����������� ������
      $size_h = $size[1]; // ����������� ������
 
      $src_img_w = $size_w;
      $src_img_h = $size_h;
 
      $degrees = $data -> rotate;
 
      // ��������� �������� �����������
      if (is_numeric($degrees) && $degrees != 0) {
        // �������� � PHP �������������� �������� �� CSS
        $new_img = imagerotate( $src_img, -$degrees, imagecolorallocatealpha($src_img, 0, 0, 0, 127) );
 
        imagedestroy($src_img);
        $src_img = $new_img;
 
        $deg = abs($degrees) % 180;
        $arc = ($deg > 90 ? (180 - $deg) : $deg) * M_PI / 180;
 
        $src_img_w = $size_w * cos($arc) + $size_h * sin($arc);
        $src_img_h = $size_w * sin($arc) + $size_h * cos($arc);
 
        // ��������� ����������� ����������� �� 1px, ����� �������� < 0
        $src_img_w -= 1;
        $src_img_h -= 1;
      }
 
      $tmp_img_w = $data -> width;
      $tmp_img_h = $data -> height;
      $dst_img_w = 220;
      $dst_img_h = 220;
 
      $src_x = $data -> x;
      $src_y = $data -> y;
 
      if ($src_x <= -$tmp_img_w || $src_x > $src_img_w) {
        $src_x = $src_w = $dst_x = $dst_w = 0;
      } else if ($src_x <= 0) {
        $dst_x = -$src_x;
        $src_x = 0;
        $src_w = $dst_w = min($src_img_w, $tmp_img_w + $src_x);
      } else if ($src_x <= $src_img_w) {
        $dst_x = 0;
        $src_w = $dst_w = min($tmp_img_w, $src_img_w - $src_x);
      }
 
      if ($src_w <= 0 || $src_y <= -$tmp_img_h || $src_y > $src_img_h) {
        $src_y = $src_h = $dst_y = $dst_h = 0;
      } else if ($src_y <= 0) {
        $dst_y = -$src_y;
        $src_y = 0;
        $src_h = $dst_h = min($src_img_h, $tmp_img_h + $src_y);
      } else if ($src_y <= $src_img_h) {
        $dst_y = 0;
        $src_h = $dst_h = min($tmp_img_h, $src_img_h - $src_y);
      }
 
      // ������� �������� ������� � ������
      $ratio = $tmp_img_w / $dst_img_w;
      $dst_x /= $ratio;
      $dst_y /= $ratio;
      $dst_w /= $ratio;
      $dst_h /= $ratio;
 
      $dst_img = imagecreatetruecolor($dst_img_w, $dst_img_h);
 
      // �������� ���������� ��� � ������� �����������
      imagefill($dst_img, 0, 0, imagecolorallocatealpha($dst_img, 0, 0, 0, 127));
      imagesavealpha($dst_img, true);
 
      $result = imagecopyresampled($dst_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
 
      if ($result) {
        if (!imagepng($dst_img, $dst)) {
          $this -> msg = "�� ������� ��������� ���������� ���� �����������";
        }
      } else {
        $this -> msg = "�� ������� �������� ���� �����������";
      }
 
      imagedestroy($src_img);
      imagedestroy($dst_img);
    }
  }
 
  private function codeToMessage($code) {
    $errors = array(
      UPLOAD_ERR_INI_SIZE =>'����������� ���� ��������� ��������� upload_max_filesize � php.ini',
      UPLOAD_ERR_FORM_SIZE =>'����������� ���� ��������� ������ max_file_size, ���������� � HTML-�����',
      UPLOAD_ERR_PARTIAL =>'����������� ���� ��� �������� ���� ��������',
      UPLOAD_ERR_NO_FILE =>'���� �� ��� ��������',
      UPLOAD_ERR_NO_TMP_DIR =>'����������� ��������� �����',
      UPLOAD_ERR_CANT_WRITE =>'�� ������� �������� ���� �� ����',
      UPLOAD_ERR_EXTENSION =>'������ �������� ����� ��-�� ����������',
    );
 
    if (array_key_exists($code, $errors)) {
      return $errors[$code];
    }
 
    return '����������� ������ ��������';
  }
 
  public function getResult() {
    return !empty($this -> data) ? $this -> dst : $this -> src;
  }
 
  public function getMsg() {
    return $this -> msg;
  }
}
 
$crop = new CropAvatar(
  isset($_POST['avatar_src']) ? $_POST['avatar_src'] : null,
  isset($_POST['avatar_data']) ? $_POST['avatar_data'] : null,
  isset($_FILES['avatar_file']) ? $_FILES['avatar_file'] : null
);
 
$response = array(
  'state'  => 200,
  'message' => $crop -> getMsg(),
  'result' => $crop -> getResult()
);
 
echo json_encode($response);