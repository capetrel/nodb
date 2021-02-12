<?php


namespace App;


use GuzzleHttp\Psr7\Response;

class ValidateForm
{

    private array $data;
    private string $url;

    public function __construct(array $data, string $url)
    {
        $this->data = $data;
        $this->url = $url;
    }

    public function validate()
    {

        $validator = (new Validator($this->data))
            ->required('name', 'email', 'message')
            ->textLength('name', 5)
            ->email('email')
            ->mustBeEmpty('info')
            ->textLength('message', 10);

        if ($validator->isValid()) {
            $to      = getEnvValue('MAIL_ADMIN_ADDRESS');
            $subject = 'Formulaire de contact de votre site';
            $message = $this->data['message'];
            $headers = [
                'From' => $this->data['name'],
                'Reply-To' => $this->data['email'],
                'X-Mailer' => 'PHP/' . phpversion()
            ];
            mail($to, $subject, $message, $headers);
            $flash = new \Slim\Flash\Messages();
            $flash->addMessage('success', 'Merci pour votre email');
            return new Response(302, ['Location' => $this->url]);
        } else {
            return $validator->getErrors();
        }
    }

    public function getValues()
    {
        return $this->data;
    }
}