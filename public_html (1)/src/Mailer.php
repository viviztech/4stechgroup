<?php

declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

final class Mailer
{
    /**
     * Send the enquiry notification. Failure is logged, never fatal —
     * the enquiry is already safely stored in SQLite by the time this
     * runs, so a broken SMTP config must not break the form for the
     * visitor.
     */
    public static function sendEnquiryNotification(array $enquiry): bool
    {
        $mailConfig = config('mail');

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $mailConfig['host'];
            $mail->Port = $mailConfig['port'];
            $mail->SMTPAuth = $mailConfig['username'] !== '';
            if ($mail->SMTPAuth) {
                $mail->Username = $mailConfig['username'];
                $mail->Password = $mailConfig['password'];
            }
            if ($mailConfig['encryption'] === 'ssl') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } elseif ($mailConfig['encryption'] === 'tls') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }

            $mail->setFrom($mailConfig['from_email'], $mailConfig['from_name']);
            $mail->addAddress($mailConfig['to_email']);
            if (!empty($enquiry['email'])) {
                $mail->addReplyTo($enquiry['email'], $enquiry['name'] ?? '');
            }

            $type = $enquiry['type'] === 'rfq' ? 'Request for Quote' : 'Contact Enquiry';
            $mail->Subject = sprintf('[%s] New %s from %s', config('site_name_short'), $type, $enquiry['name'] ?? 'Website visitor');

            $mail->isHTML(true);
            $mail->Body = self::buildBody($enquiry);
            $mail->AltBody = strip_tags(str_replace('<br>', "\n", self::buildBody($enquiry)));

            $mail->send();

            return true;
        } catch (PHPMailerException $exception) {
            error_log('[Mailer] Enquiry notification failed: ' . $exception->getMessage());

            return false;
        }
    }

    private static function buildBody(array $enquiry): string
    {
        $rows = '';
        foreach ($enquiry as $key => $value) {
            if ($value === null || $value === '' || $key === 'attachment_path') {
                continue;
            }
            $label = ucwords(str_replace('_', ' ', $key));
            $rows .= sprintf('<tr><td><strong>%s</strong></td><td>%s</td></tr>', e($label), nl2br(e((string) $value)));
        }

        return '<table cellpadding="6" cellspacing="0">' . $rows . '</table>';
    }
}
