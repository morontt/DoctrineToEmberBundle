<?php

namespace Mtt\Bundle\DoctrineToEmberBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('mtt:generate:models')
            ->setDescription('Conversion doctrine models to EmberData models.')
            ->addOption('em', null, InputOption::VALUE_OPTIONAL, 'The entity manager to use for this command');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->getContainer()->has('doctrine')) {
            $output->writeln('service doctrine undefined');
            return null;
        }

        $em = $this->getContainer()
            ->get('doctrine')
            ->getManager($input->getOption('em'));

        $metadata = $em->getMetadataFactory()->getAllMetadata();

        if (!empty($metadata)) {
            $classes = $this->getContainer()
                ->get('mtt_doctrine_to_ember.converter')
                ->processingMetadata($metadata);

            $this->getContainer()
                ->get('mtt_doctrine_to_ember.generator')
                ->generate($classes, $this->getSkeletonDirs());

            $output->writeln(sprintf('<info>Generated <comment>%d</comment> models</info>', count($classes)));
        } else {
            $output->writeln('No Metadata Classes to process.');
            return null;
        }

        return null;
    }

    /**
     * @return array
     */
    protected function getSkeletonDirs()
    {
        $skeletonDirs = array();

        if (is_dir($dir = $this->getContainer()->get('kernel')->getRootdir() . '/Resources/MttDoctrineToEmberBundle/skeleton')) {
            $skeletonDirs[] = $dir;
        }

        $skeletonDirs[] = realpath(__DIR__ . '/../Resources/skeleton');

        return $skeletonDirs;
    }
}
