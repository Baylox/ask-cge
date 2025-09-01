<?php

namespace App\Command;


use App\Entity\Account;
use App\Repository\AccountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Constraints\PasswordStrength;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


#[AsCommand(
    name: 'account-reset-password',
    description: 'Add a short description for your command',
)]
class AccountResetPasswordCommand extends Command
{
    public function __construct(
        private AccountRepository $accountRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface $entityManager,
        private ValidatorInterface $validator
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('username', InputArgument::OPTIONAL, 'Username for user to reset password')
            ->addOption('temp','t', null, InputOption::VALUE_NONE, 'Temporary password')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $username = $input->getArgument('username');

        if (!$username) {
            $question = new Question('Indiquer l\'email du compte');
            $question->setAutocompleterCallback(
                fn(string $userInput): array => $this->accountRepository->autocompleteUsernames($userInput)
            );
            $username = $io->askQuestion($question);
        }


        $account = $this->accountRepository->findOneBy(['email' => $username]);
        if (!$account) {
            $io->error('Aucun compte trouvé avec cet email.');

            return Command::FAILURE;
        }

        $password = $io->askHidden('Mot de passe'); // Permet de ne pas afficher ce qui est tapé à l'écran

        $sw = new Stopwatch();
        $sw->start('validation'); // lance le chrono

        $violations = $this->validator->validate($password, [
            new PasswordStrength(),
            new NotCompromisedPassword()
        ]);
        $event = $sw->stop('validation'); // Stop le chrono
        if ($output->isVerbose()) {
            $io->info('Validation time: ' . $event->getDuration() . ' ms.'); // Affiche le chrono en ms
        }

        if (0 < $violations->count()) {
            foreach ($violations as $violation)
                $io->error($violation->getMessage());

            return Command::FAILURE;
        }


        $account->setPassword($this->passwordHasher->hashPassword($account, $password));
        if ($input->getOption('temp')) {
            // mark user to change password
        }

        $this->entityManager->flush();

        $io->success(sprintf(
            "Le mot de passe du compte %s a été réinitialisé avec succès.",
            $account->getEmail()
        ));

        return Command::SUCCESS;
    }
}
