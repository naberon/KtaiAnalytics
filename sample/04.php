<?php echo '<?xml version="1.0" encoding="Shift_JIS"?>'."\n" ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>04.���ѕϐ� | KtaiAnalytics�����</title>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=Shift_JIS" />
</head>
<body>
<div style="font-size:x-small;">
<h1 style="font-size:medium;">04.���ѕϐ�</h1>
<div>���ѕϐ���ݒ肷��ꍇ���̻����</div>
<div><a href="./index.php">�ڎ��֖߂�</a></div>
</div>

<?php
// KtaiAnalytics.php ��path�̒ʂ��Ă���f�B���N�g���ɂ���Ă�
require_once 'KtaiAnalytics.php';
$ka = new KtaiAnalytics();

//$ka->img_path = 'analytics/ka.php';
//$ka->debug = true;

// �v���t�@�C��ID�ݒ�
$ka->_setAccount("MO-XXXXX-YY");
// �y�[�W�^�C�g���ݒ�
$ka->_setTitle("04.���ѕϐ� | KtaiAnalytics�����");

// �J�X�^���ϐ��̐ݒ�(5�܂�)
// ��>���O�C��������Ƀ��[�U�[�̌l����ݒ�
$ka->_setCustomVar(1, "userID", "10025", 2); // 1.���[�U�[ID 10025
$ka->_setCustomVar(2, "sex", "male", 2); // 2.���� �j
$ka->_setCustomVar(3, "generation", "30-39", 2); // 3.���� 30��
$ka->_setCustomVar(4, "pref", "tokyo", 2); // 4.�n�� ����
$ka->_setCustomVar(5, "mail", "OFF", 2); // 5.�����}�K��� �ł͂Ȃ�

// �g���b�L���O���s
$ka->_trackPageview();
?>
</body>
</html>
