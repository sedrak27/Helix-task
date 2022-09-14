<?php

namespace App\Console\Commands;

use App\Http\Controllers\MailController;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Collection;

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
        $datas = [];
        $datas['name'] = $this->ask('Enter user full name');
        $datas['email'] = $this->ask('Enter user email');
        $datas['password'] = $this->secret('Enter user password');

        $validation = Validator::make($datas,[
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        if($validation->fails()){
            foreach ($validation->errors()->all() as $error){
                $this->error($error);
                $this->line(' ');
            }
        } else{
            $result = User::create($datas);
            if($result){
                $this->info('User created successfully');
                $this->line(' ');
            } else{
                $this->error('Something went wrong try again');
            }
        }
    }
}
