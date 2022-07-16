<?php
//error_reporting(E_ALL);
//ini_set('error_log', __DIR__ . '/log.txt');
//error_log('Запись в лог', 0);
// определяем кодировку
header('Content-type: text/html; charset=utf-8');
require_once('MySQL/connect.php');
// Создаем объект бота
$bot = new Bot($db);
// Обрабатываем пришедшие данные
$bot->init('php://input');

/**
 * Class Bot
 */
class Bot
{
    // <bot_token> - созданный токен для нашего бота от @BotFather
    private $botToken = "2053023186:AAGLGqSImlFIVs54klP4X4WZEHKtsEp9BYU";

    public $db;
    private $cron;
    public function __construct($db)
    {
        $this->db = $db;
        $this->cron = isset($_GET['cron']) ? true : false;
    }

    // адрес для запросов к API Telegram
    private $apiUrl = "https://api.telegram.org/bot";

    // админы
    private $ADMIN = [ 122815990, 1660455309,5405337295,659025951];
    private $adminSend = [5405337295,1660455309];
    private $arrayAgent = [
        ['name'=> 'Lucas Nagad Linebet', 'id' => ['01785608019','01717666961','01706171815','01712103463']],
        ['name' => 'Dedun Nagad Linebet', 'id' => ['01839760298','01777484055']],
        ['name' => 'Sisko Nagad Linebet', 'id' => ['01310278676']],
        ['name' => 'Grenade Nagad Linebet', 'id' => ['01850992199', '01723162009', '01853737238']],
        ['name' => 'Kairo Nagad Linebet', 'id' => ['01957875860']],
        ['name' => 'Ares Nagad Linebet', 'id' => ['01613112345', '01639885080', '01778942191', '01913335560', '01948313358']],
        ['name' => 'Olympus Nagad Linebet', 'id' => ['01974904932', '01608616565', '01313562494']],
        ['name' => 'Troy Nagad Linebet', 'id' => ['01777204172', '01308838299', '01881484343', '01980732103', '01922236411', '01723202424', '01990115976', '01308379200']],
        ['name' => 'Oliver Nagad Linebet', 'id' => ['01842430095', '01613671988', '01858104564', '01932799521', '01400001331', '01942265377', '01918644783', '01817000712']],
        ['name' => 'Mars Nagad Linebet', 'id' => ['01881493230', '01821784720', '01726030354', '01315035165', '01860771111', '01862197059']],
        ['name' => 'Caleb Nagad Linebet', 'id' => ['01908022544', '01956107737', '01990516309']],
        ['name' => 'Abram Nagad Linebet', 'id' => []],
        ['name' => 'Brich Rocket Linebet', 'id' => ['018121293332']],
        ['name' => 'Lucas  Rocket Linebet', 'id' => ['01867379319']],
        ['name' => 'Windy  Rocket Linebet', 'id' => ['01778811660']],
        ['name' => 'Odin  Rocket Linebet', 'id' => ['01754462107']],
        ['name' => 'Oliver  Rocket Linebet', 'id' => ['019543484349']],
        ['name' => 'Mars Upay Linebet', 'id' => ['01927704905']],
        ['name' => 'Amon Bkash Linebet', 'id' => ['01718448694', '01755449964', '01982744497', '01778797820', '01884328328']],
        ['name' => 'Starlette Bkash Linebet', 'id' => ['01794412613', '01793827006']],
        ['name' => 'Hades Bkash Linebet', 'id' => ['01312522203', '01795672856', '01707173789', '01314967636', '01303680592', '01710471654', '01611633814', '01880252649','01917014838']],
        ['name' => 'Ben Bkash Linebet', 'id' => ['01749551872', '01879497064', '01759635274']],
        ['name' => 'Colton Bkash Linebet', 'id' => ['01701127231']],
        ['name' => 'Vidar Bkash Linebet', 'id' => ['01793385616']],
        ['name' => 'Hera Bkash Linebet', 'id' => ['01780533045', '01793675779', '01601152771', '01310443131']],
        ['name' => 'Bonno Bkash Linebet', 'id' => ['01725559222', '01724944848', '01708521452', '01601207853']],
        ['name' => 'Landon Bkash Linebet', 'id' => ['01733738355']],
        ['name' => 'Coven Bkash Linebet', 'id' => ['01759161654', '01701731061', '01717711600', '01779757570']],
        ['name' => 'Chapman Bkash Linebet', 'id' => ['01858735453']],
        ['name' => 'Cronos Bkash Linebet', 'id' => ['01401209023', '01301664966', '01644631122']],
        ['name' => 'Bruno Bkash Linebet ', 'id' => ['01716319491', '01307532827', '01791315185']],
        ['name' => 'Henry Bkash Linebet', 'id' => ['01723158993', '01782701180', '01317344694', '01315221311']],
        ['name' => 'Brich Nagad Linebet', 'id' => ['01849797897', '01317872767', '01812129333']],
        ['name' => 'Anakin Nagad Linebet', 'id' => ['01943892965']]

    ];

    public function init($data_php)
    {
        if($this->cron === true){
            $stat = $this->getStat();
            $this->sendMessage(122815990,$stat);
        }
        // создаем массив из пришедших данных от API Telegram
        $data = $this->getData($data_php);
        // id чата отправителя


        //включаем логирование будет лежать рядом с этим файлом
//            $this->setFileLog( $data, "log.txt" );

        if (array_key_exists('message', $data)) {

            $start = $this->getKeyBoard([
                [
                    ["text" => "Deposit"],
                    ["text" => "Withdraw"],
                ]
            ]);
            $kassa = $this->getKeyBoard([
                [
                    ["text" => "Upay"],
                    ["text" => "Bkash"],
                    ["text" => "Nagad"],
                    ["text" => "Rocket"]

                ],
                [
                    ["text" => "Cancel"]
                ]
            ]);
            $otmena = $this->getKeyBoard([
                [
                    ["text" => "Cancel"]
                ]
            ]);
            $chat_id = $data['message']['chat']['id'];
            $message = $data['message']['text'];


            if ($message == "/start" || $message == "/stop") {

                if($this->isAdmin($chat_id) === true) {
                    $dataSend = array(
                        'text' => "Admin",
                        'chat_id' => $chat_id,
                    );
                    $this->requestToTelegram($dataSend, "sendMessage");
                }else{
                    $dataSend = array(
                        'text' => "Choose an action.",
                        'chat_id' => $chat_id,
                        'reply_markup' => $start,
                    );
                    $this->requestToTelegram($dataSend, "sendMessage");
                }

            }

            if ($message == "Cancel") {

                $dataSend = array(
                    'text' => "Undoing Actions",
                    'chat_id' => $chat_id,
                    'reply_markup' => $start,
                );
                file_put_contents("chat_id/$chat_id.txt", "");
                $this->requestToTelegram($dataSend, "sendMessage");


            }

            $file = file_get_contents("chat_id/$chat_id.txt");
            if ($this->isJSON($file) === false) {
                $file_one = explode(",", $file);
                $file_explode = $file_one;
                $file_one = $file_one[0];
                $file = substr_count($file, ',');
            }
            switch ($file) {
                case 1:
                    if ($file_one == "Deposit") $data_post = "Transaction ID:";
                    if ($file_one == "Withdraw") $data_post = "Withdrawal request id:";
                    $this->post_save_data($chat_id, $data_post, $message, $otmena);
                    break;
                case 2:
                    if ($file_one == "Deposit") $data_post = "Client phone number:";
                    if ($file_one == "Withdraw") $data_post = "Client phone number:";
                    $this->post_save_data($chat_id, $data_post, $message, $otmena);
                    break;
                case 3:
                    if ($file_one == "Deposit") $data_post = "Agent number:";
                    if ($file_one == "Withdraw") $data_post = "Date:";
                    $this->post_save_data($chat_id, $data_post, $message, $otmena);
                    break;
                case 4:
                    if ($file_one == "Deposit") $data_post = "Date:";
                    if ($file_one == "Withdraw") $data_post = "Time:";
                    $this->post_save_data($chat_id, $data_post, $message, $otmena);
                    break;
                case 5:
                    if ($file_one == "Deposit") $data_post = "Time:";
                    if ($file_one == "Withdraw") $data_post = "Amount:";
                    $this->post_save_data($chat_id, $data_post, $message, $otmena);
                    break;
                case 6:
                    if ($file_one == "Deposit") {
                        $data_post = "Amount:";
                        $this->post_save_data($chat_id, $data_post, $message, $otmena);
                    }
                    if($file_one == 'Withdraw') {

                        $text = $file_explode[0] . ": " . $file_explode[1] . "
User id: " . $file_explode[2] . "
Withdrawal request id: " . $file_explode[3] . "
Client phone number: " . $file_explode[4] . "
Date: " . $file_explode[5] . "
Time: " . $file_explode[6] . "
Amount: " . $message . "

<i>is the data correct</i>";

                        $answer_options = $this->getinline_KeyBoard([
                            [
                                [
                                    "text" => "Yes",
                                    "callback_data" => "Yes"
                                ],
                                [
                                    "text" => "No",
                                    "callback_data" => "No"
                                ],
                            ]
                        ]);

                        $dataSend = array(
                            'text' => $text,
                            'chat_id' => $chat_id,
                            'reply_markup' => $answer_options,
                            "parse_mode" => "HTML"
                        );
                        $this->requestToTelegram($dataSend, "sendMessage");
                        file_put_contents("chat_id/$chat_id.txt", ",$message", FILE_APPEND);
                    }
                    break;
                case 7:
                    if ($file_one == "Deposit") {
                        $data_post = "Screenshot or Video:";
                        $this->post_save_data($chat_id, $data_post, $message, $otmena);
                    }
                    break;
                case 8:
                    if ($file_one == "Deposit") {
                        if (array_key_exists('photo', $data['message']) || array_key_exists('document', $data['message']) || array_key_exists('video', $data['message'])) {
//                    $this->setFileLog( $_SERVER[ 'DOCUMENT_ROOT' ], "log.txt" );   
                            $img = "";
                            if ($data['message']['photo']) {
                                $img = $data['message']['photo'][count($data['message']['photo']) - 1]['file_id'];
                            }
                            if ($data['message']['video']) {
                                $img = $data['message']['video']['file_id'];
                            }

                            if ($img != "") {
                                file_put_contents("chat_id/$chat_id.txt", ",$img", FILE_APPEND);

                                $text = $file_explode[0] . ": " . $file_explode[1] . "
User ID: " . $file_explode[2] . "
Transaction ID: " . $file_explode[3] . "
Client phone number: " . $file_explode[4] . "
Agent number: " . $file_explode[5] . "
Date: " . $file_explode[6] . "
Time: " . $file_explode[7] . "
Amount: " . $file_explode[8] . "
<i>is the data correct</i>";

                                $answer_options = $this->getinline_KeyBoard([
                                    [
                                        [
                                            "text" => "Yes",
                                            "callback_data" => "Yes"
                                        ],
                                        [
                                            "text" => "No",
                                            "callback_data" => "No"
                                        ],
                                    ]
                                ]);

                                if($data['message']['photo']) {
                                    $dataSend = array(
                                        'caption' => $text,
                                        'chat_id' => $chat_id,
                                        'reply_markup' => $answer_options,
                                        "parse_mode" => "HTML",
                                        "photo" => $img
                                    );
                                    $this->requestToTelegram($dataSend, "sendPhoto");
                                }
                                if($data['message']['video']) {
                                    $dataSend = array(
                                        'caption' => $text,
                                        'chat_id' => $chat_id,
                                        'reply_markup' => $answer_options,
                                        "parse_mode" => "HTML",
                                        "video" => $img
                                    );
                                    $this->requestToTelegram($dataSend, "sendVideo");
                                }
                            }
                        } else {

                            $this->sendMessage($chat_id, "Insert photo or video");
                        }

                    }
                    break;
            }

            if ($message == "Upay" || $message == "Bkash" || $message == "Nagad" || $message == "Rocket") {

                $dataSend = array(
                    'text' => "User id:",
                    'chat_id' => $chat_id,
                    'reply_markup' => $otmena,
                );
                file_put_contents("chat_id/$chat_id.txt", ",$message", FILE_APPEND);
                $this->requestToTelegram($dataSend, "sendMessage");

            }
            if ($message == "Deposit" || $message == "Withdraw") {

                $dataSend = array(
                    'text' => "Choose a payment system",
                    'chat_id' => $chat_id,
                    'reply_markup' => $kassa,
                );
                file_put_contents("chat_id/$chat_id.txt", $message);
                $this->requestToTelegram($dataSend, "sendMessage");

            }

            if ($message == '/stats') {
                if ($this->isAdmin($chat_id)) {

                    $stat = $this->getStat();
                    $this->sendMessage($chat_id, $stat);
                }
            }
            if ($message == "/stats_week") {
                if ($this->isAdmin($chat_id)) {
                    $array = ["status"];
                    $rez = $this->db->SQL_Select($array, 'applications', "604800 > UNIX_TIMESTAMP() - time", false);
                    $applications = 0;
                    $working = 0;
                    $failured = 0;
                    $approved = 0;
                    if ($rez) {
                        foreach ($rez as $value) {
                            $applications++;
                            if ($value['status'] == "working") $working++;
                            if ($value['status'] == "failured") $failured++;
                            if ($value['status'] == "approved") $approved++;
                        }
                        $stat = "Total applications: $applications
                    Working: $working
                    Failured: $failured
                    Approved: $approved";
                        $this->sendMessage($chat_id, $stat);
                    }
                }
            }
            if ($this->isJSON($file) === true) {
                $array = json_decode($file, true);
//            $this->setFileLog( $array, "log.txt" );
$requestId = $array['requestId'];
                $type = $array['type'];
                $text = $array['text'] . "
            
Comment:
$message";
                if ($type == 'text') {
                    $dataSend = array(
                        'text' => $text,
                        'chat_id' => $array['chatId'],
                        'message_id' => $array['messageId'],
                        "parse_mode" => "HTML"

                    );
                    $this->requestToTelegram($dataSend, "editMessageText");
                    if ($requestCache = json_decode(file_get_contents('requests_cache/' . $requestId . '.json'))) {
                        foreach ($requestCache as $messageData) {
                            $dataSend['chat_id'] = $messageData->chat_id;
                            $dataSend['message_id'] = $messageData->message_id;
                            $this->requestToTelegram($dataSend, "editMessageText");
                        }
                    }
                    unlink('requests_cache/' . $requestId . '.json');
                    $dataSend = array(
                        'text' => $text,
                        'chat_id' => $chat_id,
                        'message_id' => $array['messageIdCallback'],
                        "parse_mode" => "HTML"

                    );
                    $this->requestToTelegram($dataSend, "editMessageText");
                }
                if ($type == 'photo') {
                    $dataSend = array(
                        'caption' => $text,
                        'chat_id' => $array['chatId'],
                        'message_id' => $array['messageId'],
                        "parse_mode" => "HTML"

                    );
                    $this->requestToTelegram($dataSend, "editMessageCaption");
                    if ($requestCache = json_decode(file_get_contents('requests_cache/' . $requestId . '.json'))) {
                        foreach ($requestCache as $messageData) {
                            $dataSend['chat_id'] = $messageData->chat_id;
                            $dataSend['message_id'] = $messageData->message_id;
                            $this->requestToTelegram($dataSend, "editMessageCaption");
                        }
                    }
                    $dataSend = array(
                        'caption' => $text,
                        'chat_id' => $chat_id,
                        'message_id' => $array['messageIdCallback'],
                        "parse_mode" => "HTML"

                    );
                    $this->requestToTelegram($dataSend, "editMessageCaption");
                }
                $this->sendMessageReply($array['chatId'], "Application status changed", $array['messageId'], $start);
                file_put_contents("chat_id/$chat_id.txt", "");
            }

        }

        if (isset($data['callback_query'])) {
            $start = $this->getKeyBoard([
                [
                    ["text" => "Deposit"],
                    ["text" => "Withdraw"],
                ]
            ]);

            $chat_id = $data['callback_query']['from']['id'];
            $messageId = $data['callback_query']['message']['message_id'];
//        $this->setFileLog( $data, "log.txt" );
            $a = $data['callback_query']['data'];

            if (!empty($a)) {

//          $callback_data = explode( "|", $a );
                if ($a == "Yes") {

                    $file = file_get_contents("chat_id/$chat_id.txt");
                    if(empty($file) === true) die();
                    $file_explode = explode(",", $file);


                    if ($data['callback_query']['message']['text']) {

                        $information = [
                            $file_explode[0] => $file_explode[1],
                            "User id" => $file_explode[2],
                            "Withdrawal request id" => $file_explode[3],
                            "Client phone number" => $file_explode[4],
                            "Date" => $file_explode[5],
                            "Time" => $file_explode[6],
                            'Amount' => $file_explode[7]
                        ];

                        $text = $file_explode[0] . ": " . $file_explode[1] . "
User id: " . $file_explode[2] . "
Withdrawal request id: " . $file_explode[3] . "
Client phone number: " . $file_explode[4] . "
Date: " . $file_explode[5] . "
Time: " . $file_explode[6] . "
Amount: " . $file_explode[7] . "
";
                    }
                    if ($data['callback_query']['message']['photo'] || $data['callback_query']['message']['video']) {

                        $information = [
                            $file_explode[0] => $file_explode[1],
                            "User id" => $file_explode[2],
                            "Transaction id" => $file_explode[3],
                            "Client phone number" => $file_explode[4],
                            "Agent number" => $file_explode[5],
                            "Date" => $file_explode[6],
                            "Time" => $file_explode[7],
                            "Amount" => $file_explode[8],
                            "Screenshot" => $file_explode[9],
                        ];


                        for ($i = 0; $i < count($this->arrayAgent);$i++) {
                            if(in_array($file_explode[5],$this->arrayAgent[$i]['id'])) {
                                $nameAgent = $this->arrayAgent[$i]['name'];
                                break;
                            }else {
                                $nameAgent = 'Такого нет';
                            }
                        }

                        $text = $file_explode[0] . ": " . $file_explode[1] . "
User id: " . $file_explode[2] . "
Transaction id: " . $file_explode[3] . "
Client phone number: " . $file_explode[4] . "
Agent number: " . $file_explode[5] . "
Agent name: $nameAgent
Date: " . $file_explode[6] . "
Time: " . $file_explode[7] . "
Amount: " . $file_explode[8];
                    }
                    $array = [
                        "information" => json_encode($information),
                        "chat_id" => $data['callback_query']['from']['id'],
                        "name" => $data['callback_query']['from']['first_name'] . " " . $data['callback_query']['from']['last_name'],
                        "status" => "working",
                        'time'=> time()
                    ];
                    $rez = $this->db->SQL_Insert($array, 'applications', true);
                    $answer_options = $this->getinline_KeyBoard([
                        [
                            [
                                "text" => "Approve✅",
                                "callback_data" => "approve|" . $rez . "|$chat_id|" . $data['callback_query']['message']['message_id']
                            ],
                            [
                                "text" => "Failure❌",
                                "callback_data" => "failure|" . $rez . "|$chat_id|" . $data['callback_query']['message']['message_id']
                            ]

                        ],
                        [
                            [
                                "text" => "Approve✅ + Comment",
                                "callback_data" => "approve|" . $rez . "|$chat_id|" . $data['callback_query']['message']['message_id'] . "|comment"
                            ],
                            [
                                "text" => "Failure❌ + Comment",
                                "callback_data" => "failure|" . $rez . "|$chat_id|" . $data['callback_query']['message']['message_id'] . "|comment"
                            ]
                        ]
                    ]);
                    if ($data['callback_query']['message']['text']) {
                        $cache = [];
                        foreach ($this->adminSend as $item) {
                            $dataSend = array(
                                'text' => $text,
                                'chat_id' => $item,
                                'reply_markup' => $answer_options,
                            );
                            if ($messId = $this->requestToTelegram($dataSend, "sendMessage")) {
                                $tmp = json_decode($messId)->result;
                                $cache[] = [
                                    'chat_id' => $tmp->chat->id,
                                    'message_id' => $tmp->message_id
                                ];
                            }
                        }
                        file_put_contents('requests_cache/' . $rez . '.json', json_encode($cache));


                        $text = $file_explode[0] . ": " . $file_explode[1] . "
User id: " . $file_explode[2] . "
Withdrawal request id: " . $file_explode[3] . "
Client phone number: " . $file_explode[4] . "
Date: " . $file_explode[5] . "
Time: " . $file_explode[6] . "
Amount: " . $file_explode[7] . "

<b>Status:</b> in work 👨‍💻";

                        $dataSend = array(
                            'text' => $text,
                            'chat_id' => $chat_id,
                            'message_id' => $data['callback_query']['message']['message_id'],
                            "parse_mode" => "HTML"

                        );
                        $this->requestToTelegram($dataSend, "editMessageText");
                    }
                    if ($data['callback_query']['message']['photo'] || $data['callback_query']['message']['video']) {
                        if($data['callback_query']['message']['photo']) {
                            $cache = [];
                            foreach ($this->adminSend as $item) {
                                $dataSend = array(
                                    'caption' => $text,
                                    'chat_id' => $item,
                                    'reply_markup' => $answer_options,
                                    "parse_mode" => "HTML",
                                    "photo" => $data['callback_query']['message']['photo'][count($data) - 1]['file_id']
                                );
                                if ($messId = $this->requestToTelegram($dataSend, "sendPhoto")) {
                                    $tmp = json_decode($messId)->result;
                                    $cache[] = [
                                        'chat_id' => $tmp->chat->id,
                                        'message_id' => $tmp->message_id
                                    ];
                                }
                            }
                            file_put_contents('requests_cache/' . $rez . '.json', json_encode($cache));

                        }
                        if($data['callback_query']['message']['video']) {
                            foreach ($this->adminSend as $item) {
                                $dataSend = array(
                                    'caption' => $text,
                                    'chat_id' => $item,
                                    'reply_markup' => $answer_options,
                                    "parse_mode" => "HTML",
                                    "video" => $data['callback_query']['message']['video']['file_id']
                                );
                                if ($messId = $this->requestToTelegram($dataSend, "sendVideo")) {
                                    $tmp = json_decode($messId)->result;
                                    $cache[] = [
                                        'chat_id' => $tmp->chat->id,
                                        'message_id' => $tmp->message_id
                                    ];
                                }
                            }
                            file_put_contents('requests_cache/' . $rez . '.json', json_encode($cache));

                        }

                        $text = $file_explode[0] . ": " . $file_explode[1] . "
User id: " . $file_explode[2] . "
Transaction id: " . $file_explode[3] . "
Client phone number: " . $file_explode[4] . "
Agent number: " . $file_explode[5] . "
Date: " . $file_explode[6] . "
Time: " . $file_explode[7] . "
Amount: " . $file_explode[8] . "

<b>Status:</b> in work 👨‍💻";

                        $dataSend = array(
                            'caption' => $text,
                            'chat_id' => $chat_id,
                            'message_id' => $data['callback_query']['message']['message_id'],
                            "parse_mode" => "HTML"

                        );
                        $this->requestToTelegram($dataSend, "editMessageCaption");
                    }
                    $this->sendMessageReply($chat_id, "Application status changed", $data['callback_query']['message']['message_id'], $start);


                    file_put_contents("chat_id/$chat_id.txt", "");
                }
                if ($a == "No") {

                    $content = [
                        'chat_id' => $chat_id,
                        'message_id' => $data['callback_query']['message']['message_id'],
                    ];
                    // отправляем запрос на удаление
                    $this->requestToTelegram($content, "deleteMessage");
                    file_put_contents("chat_id/$chat_id.txt", "");

                    $dataSend = array(
                        'text' => "Cancellation of application",
                        'chat_id' => $chat_id,
                        'reply_markup' => $start,
                    );
                    $this->requestToTelegram($dataSend, "sendMessage");
                }
                if (strpos($a, 'approve') !== false || strpos($a, 'failure') !== false) {
                    if (strpos($a, 'approve') !== false) {
                        $selection = 'approved';
                        $selectionText = 'approved✅';
                    }
                    if (strpos($a, 'failure') !== false) {
                        $selection = 'failured';
                        $selectionText = 'failured❌';
                    }
                    $post = explode("|", $a);
                    $array = ["status = '$selection'"];
                    $where = "id = '" . $post[1] . "'";
                    $this->db->SQL_Update($array, 'applications', $where);

                    if ($data['callback_query']['message']['text']) {
                        $type = 'text';
                        $text = $data['callback_query']['message']['text'] . "
                    
<b>Status:</b> $selectionText";

                        $dataSend = array(
                            'text' => $text,
                            'chat_id' => $chat_id,
                            'message_id' => $data['callback_query']['message']['message_id'],
                            "parse_mode" => "HTML"

                        );
                        $this->requestToTelegram($dataSend, "editMessageText");
                        if ($requestCache = json_decode(file_get_contents('requests_cache/' . $post[1] . '.json'))) {
                            foreach ($requestCache as $messageData) {
                                $dataSend['chat_id'] = $messageData->chat_id;
                                $dataSend['message_id'] = $messageData->message_id;
                                $this->requestToTelegram($dataSend, "editMessageText");
                            }
                        }
                        


                        $dataSend = array(
                            'text' => $text,
                            'chat_id' => $post[2],
                            'message_id' => $post[3],
                            "parse_mode" => "HTML"

                        );
                        $this->requestToTelegram($dataSend, "editMessageText");

                        $this->sendMessageReply($post[2], "Application status changed", $post[3], $start);
                    }

                    if ($data['callback_query']['message']['photo'] || $data['callback_query']['message']['video']) {
                        $type = 'photo';
                        $text = $data['callback_query']['message']['caption'] . "
                    
<b>Status:</b> $selectionText";

                        $dataSend = array(
                            'caption' => $text,
                            'chat_id' => $chat_id,
                            'message_id' => $data['callback_query']['message']['message_id'],
                            "parse_mode" => "HTML"

                        );
                        $this->requestToTelegram($dataSend, "editMessageCaption");
                        if ($requestCache = json_decode(file_get_contents('requests_cache/' . $post[1] . '.json'))) {
                            foreach ($requestCache as $messageData) {
                                $dataSend['chat_id'] = $messageData->chat_id;
                                $dataSend['message_id'] = $messageData->message_id;
                                $this->requestToTelegram($dataSend, "editMessageCaption");
                            }
                        }
                        $text = explode(PHP_EOL,$data['callback_query']['message']['caption']);
                        unset($text[5]);
                        $text =  implode("\n",$text);
                        $text = $text . "
                    
<b>Status:</b> $selectionText";

                        $dataSend = array(
                            'caption' => $text,
                            'chat_id' => $post[2],
                            'message_id' => $post[3],
                            "parse_mode" => "HTML"

                        );
                        $this->requestToTelegram($dataSend, "editMessageCaption");

                        $this->sendMessageReply($post[2], "Application status changed", $post[3], $start);
                    }
                }
                if ($post[4]) {
                    $this->sendMessage($chat_id, 'Напишите комментарий');
                    $array = [
                        'text' => $text,
                        'chatId' => $post[2],
                        'messageId' => $post[3],
                        'messageIdCallback' => $messageId,
                        'type' => $type,
                        'requestId' => $post[1],
                    ];
                    file_put_contents("chat_id/$chat_id.txt", json_encode($array));
                } else {
                    unlink('requests_cache/' . $post[1] . '.json');
                }

            }

        }

    }

    private function getStat()
    {
        $array = ["status"];
        $rez = $this->db->SQL_Select($array, 'applications', "", false);
        $applications = 0;
        $working = 0;
        $failured = 0;
        $approved = 0;
        if ($rez) {
            foreach ($rez as $value) {
                $applications++;
                if ($value['status'] == "working") $working++;
                if ($value['status'] == "failured") $failured++;
                if ($value['status'] == "approved") $approved++;
            }
        }
        $stat = "Total applications: $applications
                    Working: $working
                    Failured: $failured
                    Approved: $approved";
        return $stat;
    }

    private function isJSON($string)
    {
        return is_string($string) && is_array(json_decode($string, true)) ? true : false;
    }

    // общая функция загрузки картинки
    private function getPhoto($data)
    {
        // берем последнюю картинку в массиве
        $file_id = $data[count($data) - 1]['file_id'];
        // получаем file_path
        $file_path = $this->getPhotoPath($file_id);
        // возвращаем результат загрузки фото
        return $this->copyPhoto($file_path);
    }

    // функция получения метонахождения файла
    private function getPhotoPath($file_id)
    {
        // получаем объект File
        $array = json_decode($this->requestToTelegram(['file_id' => $file_id], "getFile"), TRUE);
        // возвращаем file_path
        return $array['result']['file_path'];
    }

    // копируем фото к себе
    private function copyPhoto($file_path)
    {
        // ссылка на файл в телеграме
        $file_from_tgrm = "https://api.telegram.org/file/bot" . $this->botToken . "/" . $file_path;
        // достаем расширение файла
        $ext = end(explode(".", $file_path));
        // назначаем свое имя здесь время_в_секундах.расширение_файла
        $uniqid = uniqid('', true);
        $name_our_new_file = $uniqid . "." . $ext;

        $y = date('Y');
        $m = date('m');
        // проверяем существование папки
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/linebet_deposit_widthdraw/img/$y/")) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . "/linebet_deposit_widthdraw/img/$y/", 0700);
        }
        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/linebet_deposit_widthdraw/img/$y/$m/")) {
            mkdir($_SERVER['DOCUMENT_ROOT'] . "/linebet_deposit_widthdraw/img/$y/$m/", 0700);
        }
        $name_our_new_file = str_replace(".jpeg", ".jpg", $name_our_new_file);
        copy($file_from_tgrm, $_SERVER['DOCUMENT_ROOT'] . "/linebet_deposit_widthdraw/img/$y/$m/" . $name_our_new_file);

        return $_SERVER['DOCUMENT_ROOT'] . "/linebet_deposit_widthdraw/img/$y/$m/" . $name_our_new_file;

    }


    // запрос/сохранение данных
    private function post_save_data($chat_id, $data_post, $data_save, $otmena)
    {

        $dataSend = array(
            'text' => "$data_post",
            'chat_id' => $chat_id,
            'reply_markup' => $otmena,
        );
        file_put_contents("chat_id/$chat_id.txt", ",$data_save", FILE_APPEND);
        $this->requestToTelegram($dataSend, "sendMessage");

    }

    //клавиатура
    private function getKeyBoard($data, $one_time_keyboard = false)
    {
        $keyboard = array(
            "keyboard" => $data,
            "one_time_keyboard" => $one_time_keyboard,
            "resize_keyboard" => true
        );
        return json_encode($keyboard);
    }

    //inline клавиатура
    private function getinline_KeyBoard($data)
    {
        $keyboard = array(
            "inline_keyboard" => $data,
            "one_time_keyboard" => false,
            "resize_keyboard" => true
        );
        return json_encode($keyboard);
    }

    // проверка на админа
    private function isAdmin($chat_id)
    {

        return in_array($chat_id, $this->ADMIN);
    }

    // функция ответа текстового сообщения
    private function sendMessageReply($chat_id, $text, $id, $buttons)
    {
        $id_message = $this->requestToTelegram([
            'chat_id' => $chat_id,
            'text' => $text,
            "parse_mode" => "HTML",
            "disable_web_page_preview" => true,
            "reply_to_message_id" => $id,
            'reply_markup' => $buttons,
        ], "sendMessage");
        return ($id_message);
    }

    // функция отправки текстового сообщения
    private function sendMessage($chat_id, $text)
    {
        $id_message = $this->requestToTelegram([
            'chat_id' => $chat_id,
            'text' => $text,
            "parse_mode" => "HTML",
            "disable_web_page_preview" => true,
        ], "sendMessage");
        return ($id_message);
    }

    // функция логирования в файл
    private function setFileLog($data, $file)
    {
        $fh = fopen($file, 'a') or die('can\'t open file');
        ((is_array($data)) || (is_object($data))) ? fwrite($fh, print_r($data, TRUE) . "\n") : fwrite($fh, $data . "\n");
        fclose($fh);
    }

    /**
     * Парсим что приходит преобразуем в массив
     * @param $data
     * @return mixed
     */
    private function getData($data)
    {
        return json_decode(file_get_contents($data), TRUE);
    }

    /** Отправляем запрос в Телеграмм
     * @param $data
     * @param string $type
     * @return mixed
     */
    private function requestToTelegram($data, $type)
    {
        $result = null;

        if (is_array($data)) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl . $this->botToken . '/' . $type);
            curl_setopt($ch, CURLOPT_POST, count($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $result = curl_exec($ch);
            curl_close($ch);
        }
        return $result;
    }

}

//            $arr_json = [
//                "Bkash" => [
//                    "1b" => false,
//                    "2b" => false,
//                    "3b" => false,
//                    "4b" => false,
//                    "5b" => false
//                ],
//                "Nagad" => [
//                    "1n" => false,
//                    "2n" => false,
//                    "3n" => false,
//                    "4n" => false,
//                    "5n" => false
//                ],
//                "Rocket" => [
//                    "1r" => false,
//                    "2r" => false,
//                    "3r" => false,
//                    "4r" => false,
//                    "5r" => false
//                ],
//                "Upay" => [
//                    "1u" => false,
//                    "2u" => false,
//                    "3u" => false,
//                    "4u" => false,
//                    "5u" => false
//                ]
//            ];
//            file_put_contents("list_players.json", json_encode($arr_json));            

?>