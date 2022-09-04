<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mailjet
{
    private $api_key = 'c4b05617c1b0a7bb8f993e0b81a164c1';
    private $api_key_secret = '5e67a08d71d19cea286d15c75a76a5a6';

    public function send($to_email, $to_name, $subject, $content)
    {
        $mj = new Client($this->api_key, $this->api_key_secret,true,['version' => 'v3.1']);
        
$body = [
    'Messages' => [
        [
            'From' => [
                'Email' => "investirinafrica@gmail.com",
                'Name' => "my_project_afrique"
            ],
            'To' => [
                [
                    'Email' => "$to_email",
                    'Name' => "$to_name"
                ]
            ],
            'TemplateID' => 3918846,
            'TemplateLanguage' => true,
            'Subject' => $subject,
            'Variables' => [
                'content' => $content,
                
            ]
        ]
    ]
];
$response = $mj->post(Resources::$Email, ['body' => $body]);
$response->success();
    }

}