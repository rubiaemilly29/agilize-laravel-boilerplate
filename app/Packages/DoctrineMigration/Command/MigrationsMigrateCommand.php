<?php

namespace App\Packages\DoctrineMigration\Command;

use Doctrine\Migrations\Tools\Console\Command\MigrateCommand;

class MigrationsMigrateCommand extends AbstractMigrationsBaseCommand
{
    protected $signature = 'doctrine:migrations:migrate';

    protected function getDoctrineMigrationConsoleEquivalentCommand()
    {
        return MigrateCommand::getDefaultName() . ' --no-interaction';
    }
}