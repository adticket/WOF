<?php
namespace AppBundle\Command;

use AppBundle\Entity\Meeting;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class deleteOldMeetingsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('dome:delete-old-meetings')

            // the short description shown while running "php bin/console list"
            ->setDescription('Delete the old meetings!')

            // the full command description shown when running the command with "--help"
            ->setHelp('Delete the old meetings! All meetings that happend since yesterday will be deleted!')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs a message followed by a "\n"
        $output->writeln('Command "delete-old-meetings" started!');

        $doctrine = $this->getContainer()->get('doctrine');
        $em = $doctrine->getManager();

        $repository = $em->getRepository('AppBundle:Meeting');
        $meetings = $repository->findAll();

        //for console output information
        $counter = 0;

        /** @var Meeting $meeting */
        foreach ($meetings as $meeting)
        {
            //if date is yesterday
            if ($meeting->getVisitAt()->format('Y-m-d') < date('Y-m-d'))
            {
                $output->writeln('Meetingdate: '.$meeting->getVisitAt()->format('Y-m-d'));
                $em->remove($meeting);
                $counter++;
            }
        }

        $em->flush();
        $output->writeln('Deleted old Meetings: '.$counter);

    }
}