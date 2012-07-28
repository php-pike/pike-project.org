<?php

use Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console;

class Application_Console_Command_AddUser extends Console\Command\Command
{

    protected function configure()
    {
        $this
            ->setName('pike:add-user')
            ->setDescription('Add user for the website')
            ->setDefinition(array(
                new InputArgument('username', InputArgument::REQUIRED, 'The user\'s username'),
                new InputArgument('password', InputArgument::REQUIRED, 'The user\'s password'),
            ))
            ->setHelp(<<<EOT
Add's a user to the pike-project website which can access the website's admin panel.
EOT
        );
    }

    protected function execute(Console\Input\InputInterface $input,
        Console\Output\OutputInterface $output)
    {
        $em = Zend_Registry::get('doctrine')->getEntityManager();

        if (strlen($input->getArgument('username')) < 3) {
            $output->writeln('<error>The username should at least be 3 characters long</error>');
            return;
        }

        if (strlen($input->getArgument('password')) < 5) {
            $output->writeln('<error>The password must be at least 5 characters long</error>');
            return;
        }

        $user = $em->getRepository('Application\Entity\User')
            ->findOneByUsername($input->getArgument('username'));

        if (null !== $user) {
            $output->writeLn('<error>The user "' . $input->getArgument('username') . '" already exists.</error>');
            return;
        }

        $user = new Application\Entity\User();
        $user->username = $input->getArgument('username');
        $user->password = sha1($input->getArgument('password'));


        $em->persist($user);

        $em->flush();

        $output->writeln('<info>Ok, user created.</info>');
    }

}