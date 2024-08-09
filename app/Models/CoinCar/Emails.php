<?php

namespace App\Models\CoinCar;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use SendGrid;
use SendGrid\Mail\Mail as SendGridMail;

class Emails extends Model
{
    use HasFactory;
    protected $connection = 'coincars';

    protected $fillable = [
        'purpose_name',
        'bcc',
        'subject',
        'content',
        'status',
    ];

    public function sendInBlue($mailArray)
    {
        try {
            $emailContent = $mailArray['emailContent'];
            $emailSubject = $mailArray['emailSubject'];
            $userEmailAddress = $mailArray['userEmailAddress'];
            $userName = $mailArray['userName'];
            $bccArray = $mailArray['bccArray'] ?? null;
            Mail::mailer('autocoin')->send('generic_email_template', $emailContent, function ($message) use ($emailSubject, $userEmailAddress, $userName, $bccArray) {
                $message->to([$userEmailAddress => $userName])
                    ->subject($emailSubject);
                if (!is_null($bccArray) && !empty($bccArray)) {
                    $message->bcc($bccArray);
                }
                $message->from('no-reply@autocoincars.com', 'Auto Coin Cars');
            });
            return true;
        } catch (Exception $e) {
            return $this->googleMail($mailArray);
        }
    }

    public function sendGrid($mailArray)
    {
        try {
            $emailBodyContent = $mailArray['emailBodyContent'];
            $bccArray = $mailArray['bccArray'] ?? null;
            $emailSubject = $mailArray['emailSubject'];
            $userEmailAddress = $mailArray['userEmailAddress'];
            $userName = $mailArray['userName'];
            $email = new SendGridMail();
            $email->setFrom("no-reply@autocoincars.com", "Auto Coin Cars");
            $email->setSubject($emailSubject);
            $email->addTo($userEmailAddress, $userName);
            if (!is_null($bccArray) && !empty($bccArray) && array_filter($bccArray)) {
                foreach($bccArray as $bcc){
                    $email->addBcc($bcc);
                }
            }
            $email->addContent('text/html', $emailBodyContent);
            $sendgrid = new SendGrid(env('SENDGRID_API_KEY'));
            $response = $sendgrid->send($email);
            return true;
        } catch (Exception $e) {
            return $this->googleMail($mailArray);
        }
    }

    public function googleMail($mailArray)
    {
        try {
            $emailContent = $mailArray['emailContent'];
            $emailSubject = $mailArray['emailSubject'];
            $userEmailAddress = $mailArray['userEmailAddress'];
            $userName = $mailArray['userName'];
            $bccArray = $mailArray['bccArray'] ?? null;
            Mail::mailer('autocoinGoogle')
            ->send('generic_email_template', $emailContent, function($message) use 
            ($emailSubject, $userEmailAddress, $userName, $bccArray ) {
                $message->to([$userEmailAddress => $userName])
                    ->subject($emailSubject);
                if (!is_null($bccArray) && !empty($bccArray)) {
                    $message->bcc($bccArray);
                }
                $message->from('no-reply@autocoincars.com', 'Auto Coin Cars');
            });
            return true;
        } catch (Exception $e) {

            return $e;
            // return $this->error($e);
        }
    }
}
