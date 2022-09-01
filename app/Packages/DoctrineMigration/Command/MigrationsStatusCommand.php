<?php

namespace App\Packages\DoctrineMigration\Command;

use Doctrine\Migrations\Tools\Console\Command\StatusCommand;

class MigrationsStatusCommand extends AbstractMigrationsBaseCommand
{
    protected $signature = 'doctrine:migrations:status';

    protected function getDoctrineMigrationConsoleEquivalentCommand()
    {
        return StatusCommand::getDefaultName();
    }
}
