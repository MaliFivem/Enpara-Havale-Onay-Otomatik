<?php
  
/* Gmail baglanti */
$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
$username = 'mailadresiniz<span class="userTag">@gmail.com';</span>
$password = 'sifreniz';
$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());
  
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