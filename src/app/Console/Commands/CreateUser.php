<?php

namespace LaraWhale\Cms\Console\Commands;

use Illuminate\Support\Str;
use LaraWhale\Cms\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a CMS user';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->ask('What is the name of the user?');

        $email = $this->ask('What is the email of the user?');

        $password = $this->secret(
            'What is the password of the user? (leave blank for random password)',
            false,
        );

        if ($password === false) {
            $password = Str::random(16);

            $this->info('Generated: ' . $password);
        }

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        $this->info(
            'User has been created and can login at: ' . route('cms.login'),
        );
    }
}
