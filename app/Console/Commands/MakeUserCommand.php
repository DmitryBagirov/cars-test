<?php

namespace App\Console\Commands;

use App\Services\UserService;
use Illuminate\Console\Command;

class MakeUserCommand extends Command
{
    protected $signature = 'users:make {email} {password}';
    protected $description = 'Generate cars';

    public function __construct(private readonly UserService $userService)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $email = $this->argument('email');
        $password = $this->argument('password');
        $errors = $this->validate($email, $password);

        if ($errors) {
            $this->printErrorMessages($errors);

            return Command::FAILURE;
        }

        $this->userService->create(
            email: $email,
            password: $password,
        );

        return Command::SUCCESS;
    }

    private function validate(string $email, string $password): array
    {
        return validator(
            [
                'email' => $email,
                'password' => $password,
            ], [
                'email' => 'email|unique:users',
                'password' => 'string|min:5'
            ]
        )->errors()->all();
    }

    private function printErrorMessages(array $errorMessages): void
    {
        $msg = PHP_EOL;

        foreach ($errorMessages as $error) {
            $msg .= "\t* $error" . PHP_EOL;
        }

        $this->error("Validation failed with errors: $msg");
    }
}
