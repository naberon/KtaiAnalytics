<?php echo '<?xml version="1.0" encoding="Shift_JIS"?>'."\n" ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>03.������ׯ�ݸ� | KtaiAnalytics�����</title>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=Shift_JIS" />
</head>
<body>
<div style="font-size:x-small;">
<h1 style="font-size:medium;">03.������ׯ�ݸ�</h1>
<div>������ׯ�ݸނ���ꍇ���̻����</div>
<div><a href="./index.php">�ڎ��֖߂�</a></div>
</div>

<?php
// KtaiAnalytics.php ��path�̒ʂ��Ă���f�B���N�g���ɂ���Ă�
require_once 'KtaiAnalytics.php';
$ka = new KtaiAnalytics();

// �h�L�������g���[�g���T�u�f�B���N�g���ȉ��̏ꍇ(�����^���T�[�o�[�ɂ悭�����)
// ��> https://www.exmple.com/analytics/
//$ka->img_path = 'analytics/ka.php';

// �f�o�b�OON(ka.php�̃w�b�_�[��google�ɑ΂��ă��N�G�X�g����URL���o�͂����)
//$ka->debug = true;

// �v���t�@�C��ID�ݒ�(����MO�Ȏ��ɋC�����āIUA����Ȃ���)
$ka->_setAccount("MO-XXXXX-YY");

// �y�[�W�^�C�g���ݒ�
$ka->_setTitle("03.������ׯ�ݸ� | KtaiAnalytics�����");

// �C�x���g�ݒ�
$ka->_trackEvent('category', 'action', 'opt_label', 10);
$ka->_trackEvent('category2', 'action2', 'opt_label2', 20); // 1�y�[�W�ŕ����C�x���g���ݒ��

// �g���b�L���O
$ka->_trackPageview();
?>
</body>
</html>
