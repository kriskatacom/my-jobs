<?php

namespace Core;

use InvalidArgumentException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    protected PHPMailer $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);

        $this->setup();
    }

    protected function setup(): void
    {
        $this->mailer->isSMTP();
        $this->mailer->Host = $_ENV['MAIL_HOST'];
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $_ENV['MAIL_USERNAME'];
        $this->mailer->Password = $_ENV['MAIL_PASSWORD'];
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = 587;

        $this->mailer->setFrom($_ENV['MAIL_FROM'], $_ENV['MAIL_FROM_NAME']);
        $this->mailer->isHTML(true);
        $this->mailer->CharSet = 'UTF-8';
    }

    public function send(string $to, string $subject, string $body): bool
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($to);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;

            return $this->mailer->send();
        } catch (Exception $e) {
            error_log("PHPMailer error: " . $e->getMessage());
            error_log("Mailer->ErrorInfo: " . $this->mailer->ErrorInfo);
            var_dump($this->mailer->ErrorInfo);
            return false;
        }
    }

    public static function renderTemplatePlaceholders(string $html, object|array $data): string
    {
        if (is_object($data)) {
            $data = get_object_vars($data);
        }

        foreach ($data as $key => $value) {
            $placeholder = '{{ ' . $key . ' }}';
            $html = str_replace($placeholder, htmlspecialchars((string) $value), $html);
        }

        return $html;
    }
}
