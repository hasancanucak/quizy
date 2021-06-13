<?php

return [
	'settings'    => 'Ayarlar',
	'general'     => 'Genel',
	'timer'       => 'Zamanlayıcı',
	'data'        => 'Veri',
	'ctfName'     => 'Site İsmi',
	'memberLimit' => 'Takım Üye Limiti',
	'theme'       => 'Tema',
	'default'     => 'Default',

	'updatedSuccessfully' => 'Ayarlar başarıyla güncellendi',

	// general settings
	'ctfNameTitle'         => 'Site ismi',
	'ctfNameDesc'          => 'Yarışmanın ismi. Yada site nin ismi.',
	'teamMemberLimitTitle' => 'Takım Üye limiti',
	'teamMemberLimitDesc'  => 'Maximum takim üyesi sayısı.',
	'themeTitle'           => 'Tema',
	'themeDesc'            => 'Sitenin teması',
	'allowRegister'        => 'Yeni üye kaydına izin ver.',
	'disallowRegister'     => 'Yeni üye kaydına izin verme.',
	'allowRegisterTitle'   => 'Yeni Üye Kaydı',
	'allowRegisterDesc'    => 'Siteye yeni bir kullanıcı kaydolabilsin mi?',
	'needHash'             => 'Flagler için hash gereksin',
	'noNeedHash'           => 'Flagler için hash gerekmesin',
	'needHashTitle'        => 'Flagler İçin Hash Almak Gereksin mi?',
	'needHashDesc'         => 'Bu ayar aktifleştiğinde flagler için panelden hash almak zorunlu olacak. Aksi taktirde flag kabul edilmeyecek.',
	'needHashKeyDesc'      => 'Bu anahtar flag hash alınmadan önce flagin sonuna eklenir.',
	'hashSecretKey'        => 'Hash Gizli Anahtar',
	'regenHashSecretKey'   => 'Gizli Kodu Tekrar Oluştur',

	// timer settings
	'ctfTimer'             => 'Soru Zamanlayıcı',
	'timerTitle'           => 'Zamanlayıcı',
	'timerDesc'            => 'Soru Zamanlayıcıyı Ayarla',
	'startTime'            => 'Başlama Zamanı',
	'endTime'              => 'Bitiş Zamanı',

	// theme settings
	'themes'               => 'Temalar',
	'deleteTheme'          => 'Temayı sil',
	'importTheme'          => 'Temayı içeri aktar',
	'themeChanged'         => 'Tema başarıyla değiştirildi',
	'defaultThemeErr'      => 'Varsayılan tema silinemez!',
	'themeValidationErr'   => 'Tema geçerli bir tema değil!',
	'currentThemeErr'      => 'Mevcut tema silinemez. Lütfen önce temayı değiştirin!',
	'themeDeleted'         => 'Tema başarıyla silindi',
	'themeImported'        => 'Tema içeri aktarıldı.',

	// data settings
	'backup'               => 'Yedekle',
	'reset'                => 'Sıfırla',
	'download'             => 'İndir',
	'backupDesc'           => 'Yedek al',
	'backupSuccessful'     => 'Yedek alma başarılı',
	'deletedSuccessfully'  => 'Başarıyla silindi',
	'fileNotExist'         => 'Dosya bulunamadı {file}',
	'deleteError'          => 'Dosya silerken bir hata oldu',
	'reseted'              => 'Başarıyla sıfırlandı',
	'resetConfirm'         => 'Devam etmek istediğinden eminmisin. BU İŞLEM GERİ ALINAMAZ !!!',
	'confirmCheckbox'      => 'Quizy\'i sıfırlamak istediğime eminim.',
	'resetWarningTitle'    => 'Bu işlem <b>geri alınamaz</b>. Lütfen hata yapmayın.',
	'resetWarningList' => [
		'Bütün kategoriler, sorular, bayraklar, ipuçları SİLİNECEK',
		'Bütün kullanıcılar (admin grubundaki kullanıcılar hariç) SİLİNECEK',
		'Bütün yüklenen dosyalar SİLİNECEK',
	],
	'resetWarning2' => 'Devam etmek istediğinden emin misin ???',

	// home page settings
	'home'                 => 'Anasayfa',
	'pageChangeError'      => 'Anasayfa değiştirilemedi',
	'pageChanged'          => 'Anasayfa başarıyla değiştirildi',
	'note'                 => 'Not',
	'noteContent'          => 'Burada Jquery ve Bootstrap 4 kullanabilirsiniz.',
	'warning'              => 'Uyarı',
	'jsWarning'            => 'Lütfen burada javascript kodu koyarken dikkatli olun. Bu içerik herhangi bir koruma olmadan anasayfada kullanılacak!',
];
