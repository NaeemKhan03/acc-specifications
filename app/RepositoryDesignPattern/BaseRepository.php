<?php

namespace App\RepositoryDesignPattern;

use App\Models\CoinCar\Emails;
use App\Models\CoinCar\EmailLog;
use App\Models\CoinCar\ErrorLog;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use App\RepositoryDesignPattern\Interfaces\BaseInterface;

class BaseRepository implements BaseInterface
{
    
    public function error_log($e){

        $route=Route::getCurrentRoute();
        $errorLog = new ErrorLog;
        $url=$route->uri;
        $error_message= " <b>Message:</b> ". $e->getMessage().
            " <br> <b>File: </b> " . $e->getFile() .
            " <br> <b>Line: </b> " . $e->getLine() .
            " <br> <b>Error code: </b> " . $e->getCode().
            "<br> <b> URL: </b> ". $url.
            "<br> <b> Project Name: </b> ". env('Project_Name');
        $errorDetail= ErrorLog::where('error_log',$error_message)->first();
        if($errorDetail==null){    
            $counter = 1;
            $errorLog->error_log= $error_message;
            $errorLog->count=$counter;
            $errorLog->email_time=Carbon::now();
            $errorLog->save();
            $email=(new Emails())->where('purpose_name','=','error_log')->first();
            $emailBcc=$email->bcc;
            $emailAddress=explode(',', $emailBcc);
            if($emailAddress[0]!=""){
                $userEmailAddress= $emailAddress[0];
                $emailSubject=$email->subject;
                $content = $error_message;
                $mailArray = ['emailContent' => ['email' =>$content], 'bccArray' => $emailAddress, 'emailSubject' => $emailSubject, 'userEmailAddress' => $userEmailAddress, 'userName' => 'Auto Coin Cars Developer'];
                $emailSent = (new Emails())->googleMail($mailArray);
                if($emailSent==true){
                    $mailLog=new EmailLog();
                    $mailLog->email= $userEmailAddress;
                    $mailLog->sent="1";
                    $mailLog->opened="0";
                    $mailLog->content=$content;
                    $mailLog->type="other";
                    $mailLog->save();
                    return True;
                }
                else{
                    return False;
                }
            }
            else{
                $email=(new Emails())->where('purpose_name','=','error_log')->first();
                $userEmailAddress="itszeeshanhaider@gmail.com";
                $route=Route::getCurrentRoute();
                $emailSubject=$email->subject;
                $content = $content = $error_message;
                $mailArray = ['emailContent' => ['email' =>$content], 'bccArray' => $emailBcc, 'emailSubject' => $emailSubject, 'userEmailAddress' => $userEmailAddress, 'userName' => 'Auto Coin Cars Developer'];
                $emailSent = (new Emails())->googleMail($mailArray);
                if($emailSent==true){
                    $mailLog=new EmailLog();
                    $mailLog->email= $userEmailAddress;
                    $mailLog->sent="1";
                    $mailLog->opened="0";
                    $mailLog->content=$content;
                    $mailLog->type="other";
                    $mailLog->save();
                    return True;
                }
                else{
                    return False;
                }
            }
        }
        else{
            $counter = $errorDetail->count;
            if($counter>0){
                $email_time=Carbon::createFromFormat('Y-m-d H:s:i', $errorDetail->email_time);
                $currentTime = Carbon::now();
                $timeDifference = $email_time->diffInMinutes($currentTime);
                if($timeDifference>=60){
                    $errorDetail->count=$counter+1;
                    $errorDetail->email_time=carbon::now();
                    $errorDetail->save();
                    $email=(new Emails())->where('purpose_name','=','error_log')->first();            
                    $emailBcc=$email->bcc;
                    $emailAddress=explode(',', $emailBcc);
                    if($emailAddress[0]!=""){
                        $userEmailAddress= $emailAddress[0];
                        $emailSubject=$email->subject;
                        $content = $error_message;
                        $mailArray = ['emailContent' => ['email' =>$content], 'bccArray' => $emailAddress, 'emailSubject' => $emailSubject, 'userEmailAddress' => $userEmailAddress, 'userName' => 'Auto Coin Cars Developer'];
                        $emailSent = (new Emails())->googleMail($mailArray);
                        if($emailSent==true){
                            $mailLog=new EmailLog();
                            $mailLog->email= $userEmailAddress;
                            $mailLog->sent="1";
                            $mailLog->opened="0";
                            $mailLog->content=$content;
                            $mailLog->type="other";
                            $mailLog->save();
                            return True;
                        }
                        else{
                            return False;
                        }
                    }
                    else{
                        $email=(new Emails())->where('purpose_name','=','error_log')->first();
                        $userEmailAddress="itszeeshanhaider@gmail.com";
                        $emailSubject=$email->subject;
                        $content = $error_message;
                        $mailArray = ['emailContent' => ['email' =>$content], 'bccArray' => $emailBcc, 'emailSubject' => $emailSubject, 'userEmailAddress' => $userEmailAddress, 'userName' => 'Auto Coin Cars Developer'];
                        $emailSent = (new Emails())->googleMail($mailArray);
                        if($emailSent==true){
                            $mailLog=new EmailLog();
                            $mailLog->email= $userEmailAddress;
                            $mailLog->sent="1";
                            $mailLog->opened="0";
                            $mailLog->content=$content;
                            $mailLog->type="other";
                            $mailLog->save();
                            return True;
                        }
                        else{
                            return False;
                        }
                    }

                }
                else{
                    $errorDetail->count=$counter+1;
                    $errorDetail->save();
                }
            }
        }
    }
}
