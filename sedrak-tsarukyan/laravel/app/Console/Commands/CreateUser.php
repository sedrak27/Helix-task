<?php

namespace App\Console\Commands;

use App\Http\Controllers\MailController;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void{
        $name = $this->ask('Enter user full name');
        $email = $this->ask('Enter user email');
        $isEmail = preg_match("/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/",$email);
        $isTaken = (bool)User::query()->where('email','=', $email)->first();

        while(!$isEmail || $isTaken) {
            if($isTaken) {
                $this->error('The email has already been taken');
                unset($isTaken);
            }else if(!$isEmail) {
                $this->error('Invalid email try again, ex. name.surname@example.com');
            }

            $email = $this->ask('Enter user email');
            $isEmail = preg_match("/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/",$email);
            $isTaken = (bool)User::query()->where('email','=', $email)->first();
        }

        $password = $this->secret('Enter user password');
        $shortLength = strlen($password) < 8;
        $containLetters = preg_match('/[a-z]/i', $password);
        $containNumbers = preg_replace( '/[^0-9]/', '', $password);

        while($shortLength || !$containLetters || !$containNumbers){
            if($shortLength){
                $this->error('The password must be at least 8 characters');
            } else if(!$containNumbers){
                $this->error('Password must contain numbers');
            } else if(!$containLetters){
                $this->error('Password must contain letters');
            }
            $password = $this->secret('Enter user password');
            $shortLength = strlen($password) < 8;
            $containLetters = preg_match('/[a-z]/i', $password);
            $containNumbers = preg_replace( '/[^0-9]/', '', $password);
        }

        $bar = $this->output->createProgressBar(100);

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->verification_code = sha1(time());
        $res = $user->save();

        $bar->finish();

        if($res){
            MailController::sendEmail(name:$user->name, email:$user->email,verificationCode: $user->verification_code);
            $this->info(' User created successfully check email for verification');
        }else{
            $this->info(' Something went wrong try again');
        }
    }
}
