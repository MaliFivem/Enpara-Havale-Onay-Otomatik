# Enpara Otomatik Onay Php

Enpara.com için havale ile gelen ödemelerin sisteminize otomatik onay vermesini sağlayan kendi yazdığım ve kullandığım kodlardır.  
Açıklamaya BORC-SC34 yazdırdığımız zaman sistem 34 id'li üyeye yatırılan bakiyeyi otomatik olarak ekler. 41. satırda kendinize göre düzenleyebilirsiniz.  
Sistemi havale işlemleri için test ettim herhangi bir sorun olmadı 1 haftadır aktif kullanıyorum. EFT için henüz test etmeye fırsatım olmadı.  
  
Sistem enpara.com'da havale geldiğinde gelen maili okuyarak işlem yapar.  
  
Edit: Çalışmıyordu düzeltildi....  
[https://security.google.com/settings...y/apppasswords](https://security.google.com/settings/security/apppasswords) burdan Uygulamaya özel şifre oluşturarak sorunsuzca maile bağlanmayı sağlayabilirsiniz.  
Havale açıklamasındaki yazıda büyük/küçük harf önemlidir.  
  
Sistem hakkında destek vermiyorum. Sisteminize entegre etmek için yazılımcınız ile görüşebilirsiniz. Zaten basit bir yapıda, diğer bankalar için de aynı şekilde geliştirilebilir.

 ###  Not bu kodlar alıntıdır. Kendimde saklamak için buraya atmış bulunmaktayım. Dileyneler aşağıdan orjinal adresine giderek konuyu takip edebilir.
 Orjinal Konu : [En Para Otomatik Onay Kodu](https://www.r10.net/ucretsiz-scriptler/1653999-enpara-havale-otomatik-odeme-onayi.html)

    // Php Code SSilistre.me
        <?php
    
    /* Gmail baglanti */
    
    $hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
    
    $username = 'mailadresiniz<span class="userTag">@gmail.com';</span>
    
    $password = 'sifreniz';
    
    $inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: '  .  imap_last_error());
    
    /* Okunmayan ve enparadan gelen mailleri listele */
    
    $emails = imap_search($inbox,'UNSEEN From Enpara');
    
    if($emails) {
    
    rsort($emails);
    
    foreach($emails as $email_number) {
    
    $headerInfo = imap_headerinfo($inbox,$email_number);
    
    $structure = imap_fetchstructure($inbox, $email_number);
    
    $overview = imap_fetch_overview($inbox,$email_number,0);
    
    $message = imap_qprint(imap_fetchbody($inbox,$email_number,1));
    
    preg_match('#Tutar(.*?)TL</span></p></td>#si',$message,$degisken);
    
    preg_match('#klama(.*?)<td style="width: 3.3000002px#si',$message,$degisken2);
    
    preg_match('#Ad / unvan(.*?)<tr valign="top">#si',$message,$degisken3);
    
    $gonderen = trim(strip_tags($degisken3[1]));
    
    $gonderen = str_replace(":", "", $gonderen);
    
    $aciklama = trim(strip_tags($degisken2[1]));
    
    $aciklama = str_replace(":", "", $aciklama);
    
    $tutar = trim(strip_tags($degisken[1]));
    
    $tutar = str_replace(":", "", $tutar);
    
    $tutar = explode(",", $tutar);
    
    $tutar = $tutar[0];
    
    if(strstr($aciklama, 'BORC-SC')) {
    
    $userid = explode("SC", $aciklama);
    
    $userid = $userid[1];
    
    // Odeme basarili ise $userid havale kismindaki aciklamaya yazdirdiginiz ID numarasini verir. Burdan sonrası mysql ile sisteminize entegre etmesi.
    
    // $tutar yatirilan tutar, virgulden sonrasini almaz.
    
    // $gonderen gonderen kisi isim ve soyisim
    
    }
    
    /* mail okundu olarak isaretlenir */
    
    $status = imap_setflag_full($inbox, $overview[0]->msgno, "Seen Flagged");
    
    }
    
    }
    
    /* imap baglantisi kapat */
    
    imap_close($inbox);
    
    ?>
