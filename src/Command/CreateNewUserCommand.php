<?php

namespace App\Command;

use App\Entity\User;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;


class CreateNewUserCommand extends Command
{
    protected static $defaultName = 'app:create-new-user';
    protected static $defaultDescription = 'Create a new user';

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'User email')
            ->addArgument('password', InputArgument::REQUIRED, 'User password')
            ->addArgument('roles', InputArgument::IS_ARRAY | InputArgument::OPTIONAL, 'Roles ? (separate with spaces). Leave blank if needed')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $user = new User();

        try {
            $emailInput = $input->getArgument('email');
            $passwordInput = $input->getArgument('password');
            $rolesInput = $input->getArgument('roles');
    
            if ($emailInput) {
                $user->setEmail($emailInput);
            }
    
            if ($passwordInput) {
                $user->setPassword($passwordInput);
            }
    
            if ($rolesInput) {
                $user->setRoles($rolesInput);
            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $io->success('User created ! Success !');
            return Command::SUCCESS;

        } catch (Exception $e) {
            var_dump('Error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
