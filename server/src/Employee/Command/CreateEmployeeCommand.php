<?php

namespace Employee\Command;

use Employee\Service\CreateEmployeeService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateEmployeeCommand extends Command
{
    public function __construct(
        private readonly CreateEmployeeService $createEmployeeService
    ) {
        parent::__construct();
    }

    public function configure(): void
    {
        $this
            ->setName('app:employee:create')
            ->setDescription('Create new employee in the system')
            ->addArgument('name', InputArgument::REQUIRED, 'Employee name')
            ->addArgument('email', InputArgument::REQUIRED, 'Employee email')
            ->addArgument('password', InputArgument::REQUIRED, 'Employee password');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        $this->createEmployeeService->create($name, $email, $password);

        $output->writeln(sprintf('Employee [%s] has been created', $name));

        return Command::SUCCESS;
    }
}
