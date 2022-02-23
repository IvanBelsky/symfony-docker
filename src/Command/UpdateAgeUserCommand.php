<?php

namespace App\Command;


use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateAgeUserCommand extends Command
{
    protected static $defaultName = 'app:update-user-age';

    private $userRepository;

    private $entityManager;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $name = null;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setDescription('Updating all users set new age');
        $this->addOption('count', 'c', InputArgument::OPTIONAL, 'Count users for update');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(['Command start']);

        $count = $input->getOption('count');

        $users = $this->userRepository->findBy([], ['id' => 'ASC'], $count);
        foreach ($users as $user) {
            $output->writeln(['userID: ' . $user->getId()]);
            $output->writeln(['Old value: ' . $user->getAge()]);
            $user->setAge(rand(10, 30));
            $output->writeln(['New value: ' . $user->getAge()]);
            $output->writeln(['----------------------------']);
            $this->entityManager->persist($user);
        }

        $this->entityManager->flush();
        $this->entityManager->clear();

        $output->writeln(['Command finished']);

        return 0;
    }
}
