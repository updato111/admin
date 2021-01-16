<?php
//------@mriven----//
define('API_KEY','1540440182:AAFZHmKRSowjg2XSE3m1vljijUQyl-rvyao');
//-----@mriven-----//
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
function sendmessage($chat_id, $text){
 bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>$text,
 'parse_mode'=>"MarkDown"
 ]);
 } 
//=====@mriven=====//
function getAdminsCount($username, $token)
{
    $html_site = file_get_contents('https://t.me/' . substr($username, 1));
    $htm = new DOMDocument();
    $htm->loadHTML($html_site);
    $finder = new DomXPath($htm);
    $classname = 'tgme_page_extra';
    $nodes = $finder->query("//*[contains(@class, '$classname')]");
    $members = $nodes->item(0)->textContent;
    $count = preg_replace("/[^\d]/", '', $members);
    $all = file_get_contents('https://api.telegram.org/bot' . $token . '/getChatMembersCount?chat_id=' . $username);
    $all = json_decode($all)->result;
    return $all - $count;
}
//-------@mriven-----//
$update = json_decode(file_get_contents('php://input'));
$from_id = $update->message->from->id; 
$chat_id = $update->message->chat->id;
$chatid = $update->callback_query->message->chat->id;
$data = $update->callback_query->data;
$text = $update->message->text;
$message_id = $update->callback_query->message->message_id;
$message_id_feed = $update->message->message_id;
////------@mriven-----//
if(preg_match('/^\/([Ss]tart)/',$text)){
bot('sendMessage',[
    'chat_id'=>$chat_id,
    'text'=>"✋سلام دوست عزیز✋
➖➖➖➖➖➖➖
🤖به ربات دریافت ادمین چنل ها خوش اومدید🤖
➖➖➖➖➖➖➖
✡این ربات به شما این قابلیت را می دهد تا تعداد ادمین های یک چنل رو دریافت کنید✡
➖➖➖➖➖➖➖
⛻: @DarkSkyTM",
    'parse_mode'=>'html',
   'reply_markup'=>json_encode([
      'inline_keyboard'=>[
      [
['text'=>'✌😏بزن بریم دوست من😏✌','callback_data'=>'go']
]
  ]
  ])
  ]);
  }elseif ($data == "blok") {
  bot('editMessagetext',[
    'chat_id'=>$chatid,
 'message_id'=>$message_id,
    'text'=>"✋سلام دوست عزیز✋
➖➖➖➖➖➖➖
🤖به ربات دریافت ادمین چنل ها خوش اومدید🤖
➖➖➖➖➖➖➖
✡این ربات به شما این قابلیت را می دهد تا تعداد ادمین های یک چنل رو دریافت کنید✡
➖➖➖➖➖➖➖
⛻: @DarkSkyTM",
    'parse_mode'=>'html',
   'reply_markup'=>json_encode([
      'inline_keyboard'=>[
      [
['text'=>'✌😏بزن بریم دوست من😏✌','callback_data'=>'go']
]
  ]
  ])
  ]);
  }elseif ($data == "go") {
  bot('editMessagetext',[
    'chat_id'=>$chatid,
 'message_id'=>$message_id,
    'text'=>"😅سلامی مجدد😅
➖➖➖➖➖➖➖➖
🤖دوست من حالا ایدی چنل مورد نظرتو وارد کن🤖
➖➖➖➖➖➖➖➖
⛻برای مثال: @DarkSkyTM",
    'parse_mode'=>'html',
   'reply_markup'=>json_encode([
      'inline_keyboard'=>[
   [
['text'=>'🏡ولش برگردیم 🏡','callback_data'=>'blok']
]
  ]
  ])
  ]);
  }
elseif($text){
$c = getAdminsCount($text,API_KEY);
if($c == 0){
bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"😑مگه مرض داری ایدی کانال میفرستی که وجود نداره😑",
 'parse_mode'=>"MarkDown",

 ]);
}else {
bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"😊فکر کردی نمیتونم بگم😊
➖➖➖➖➖➖➖➖
🤖این کانالی کا فرستادی🤖:
👉 $text 👈
➖➖➖➖➖➖➖➖
😊ادمیناش برابر است با این✌️:
👉 $c 👈
➖➖➖➖➖➖➖➖
😋حالا من که بهت گفتم این کانال چندتا ادمین داره توهم عضو کانالم شو @DarkSkyTM اگه نشی ناراحت میشم😋",
 'parse_mode'=>"MarkDown",

 ]);
}
}
?>