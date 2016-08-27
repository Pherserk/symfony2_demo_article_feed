<?php

namespace AppBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class NotifyQuotesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('notify:quotes')
            ->setDescription('Sends notifications on quotes.')
            ->setHelp("This command sends email alerts to user having quotes on their articles")
            ->addOption(
                'hours',
                null,
                InputOption::VALUE_REQUIRED,
                'Hours to look back',
                24
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $hours = $input->getOption('hours');
        $from = new \DateTime(sprintf('-%d hours', $hours));
        $to = new \DateTime('now');

        $output->writeln(sprintf('Looking for quotes made before: %s', $from->format('m/d/Y H:i:s')));

        $quotesRepo = $container
            ->get('doctrine.orm.default_entity_manager')
            ->getRepository('AppBundle:Quote');

        $quotes = $quotesRepo->findByCreationBeetween($from, $to);

        foreach ($quotes as $quote) {
            if ($quote->getAuthor() !== $quote->getArticle()->getUser()) {

                $output->writeln(sprintf('Sending an email to: %s', $quote->getArticle()->getUser()->getEmail()));

                $message = \Swift_Message::newInstance()
                    ->setSubject(sprintf('Quote from: %s', $quote->getAuthor()->getName()))
                    ->setFrom($container->getParameter('notifications_email'))
                    ->setTo($quote->getArticle()->getUser()->getEmail())
                    ->setBody($quote->getText(), 'text/html');

                $container->get('mailer')->send($message);
            }
        }

        $output->writeln('Done');
    }
}
