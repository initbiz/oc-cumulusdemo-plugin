<?php namespace Initbiz\CumulusDemo\Console;

use Illuminate\Console\Command;
use Initbiz\CumulusCore\Models\AutoAssign;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Seed extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'cumulus:seed';

    /**
     * @var string The console command description.
     */
    protected $description = 'Seed initial data for example Cumulus app';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $this->seedExamplePlans();
        $this->seedExampleClusters();
        $this->seedExampleUser();
        $this->seedAutoAssignSettings();
        $this->seedUserSettings();
        $this->output->writeln('Done!');
    }

    /**
     * Seeds two example plans: free and full
     * the first will have access only to initbiz.cumulusdemo.free_feature
     * the second will have access to initbiz.cumulusdemo.free_feature and initbiz.cumulusdemo.paid_feature
     * @return void
     */
    public function seedExamplePlans()
    {
    }

    /**
     * Seeds two example clusters: ACME Corp. and Foo bar
     * the first will have Free plan
     * the second will have Full plan
     * @return void
     */
    public function seedExampleClusters()
    {
    }

    /**
     * Seeds example demo user with demo / demo credentials
     * @return void
     */
    public function seedExampleUser()
    {
    }

    /**
     * Seeds Cumulus AutoAssign configuration
     * @return void
     */
    public function seedAutoAssignSettings()
    {
        $autoAssignModel = AutoAssign::instance();
        if (!isset($autoAssignModel)) {
        } else {
        }
    }

    /**
    * Seeds RainLab.User configuration (see documentation)
    * @return void
    */
    public function seedUserSettings()
    {
    }
}
