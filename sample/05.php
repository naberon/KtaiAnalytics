<?php echo '<?xml version="1.0" encoding="Shift_JIS"?>'."\n" ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>05.e �ϰ� �ׯ�ݸ� | KtaiAnalytics�����</title>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=Shift_JIS" />
</head>
<body>
<div style="font-size:x-small;">
<h1 style="font-size:medium;">04.e �ϰ� �ׯ�ݸ�</h1>
<div>e �ϰ� �ׯ�ݸނ���ꍇ���̻����</div>
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
$ka->debug = true;

// �v���t�@�C��ID�ݒ�(����MO�Ȏ��ɋC�����āIUA����Ȃ���)
$ka->_setAccount("MO-XXXXX-YY");

// �y�[�W�^�C�g���ݒ�
$ka->_setTitle("e �ϰ� �ׯ�ݸ� | KtaiAnalytics�����");

// �g���b�L���O
$ka->_trackPageview();

/*
 * e �R�}�[�X�g���b�L���O
 */
// e �R�}�[�X�ł̌��ς̐ݒ�
$ka->_addTrans(
    '1234',           // �󒍔ԍ�(�K�{)
    '�w�l��',             // ��g�p�[�g�i�[
    '4327',          // ������v(�K�{)
    '129',           // �ŋ�
    '1500',          // ����
    '���q�s',       // �s�s
    '�_�ސ쌧',     // ��
    '���{'             // ��
);
// e �R�}�[�X�ł̊e���i�̐ݒ�
$ka->_addItem(
    '1234',           // �󒍔ԍ�(�K�{) _addTrans �Ŏw�肵���l�Ɠ���
    'DD44',           // �i��(�K�{)
    'T�V���c A',        // ���i��
    '�� M �T�C�Y',      // �J�e�S��(�T�C�Y��F��)
    '1199',          // ���i�P��(�K�{)
    '1'               // �w����(�K�{)
);
// e �R�}�[�X�ł̊e���i�̐ݒ�
$ka->_addItem(
    '1234',           // �󒍔ԍ�(�K�{) _addTrans �Ŏw�肵���l�Ɠ���
    'DD45',           // �i��(�K�{)
    'T�V���c B',        // ���i��
    '�� M �T�C�Y',      // �J�e�S��(�T�C�Y��F��)
    '1499',          // ���i�P��(�K�{)
    '1'               // �w����(�K�{)
);
$ka->_trackTrans();

?>
</body>
</html>
