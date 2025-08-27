<?php

namespace App\Command;

use App\Entity\Account;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AccountRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:account-reset-password',
    description: 'Add a short description for your command',
)]
class AccountResetPasswordCommand extends Command
{
    public function __construct(private AccountRepository $accountRepository,
    private UserPasswordHasherInterface $passwordHasher,
    private EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $question = new Question('Indiquer l\'email?');
        $question->setAutocompleterCallback(
            fn(string $userInput): array => $this->accountRepository->autocompleteUsernames($userInput)
        );

        $username = $io->askQuestion($question);

        $account = $this->accountRepository->findOneBy(['email' => $username]);
        if (!$account) {
            $io->error('Aucun compte trouvé avec cet email.');

            return Command::FAILURE;
        }

        // TODO: Implement password reset logic
        $password = $io->askHidden('Quel est votre nouveau mot de passe ?'); // Permet de ne pas afficher ce qui est tapé à l'écran

        $account->setPassword($this->passwordHasher->hashPassword($account, $password));
        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
