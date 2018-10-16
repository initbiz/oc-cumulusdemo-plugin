<?php namespace Initbiz\CumulusDemo\Console;

use Illuminate\Console\Command;
use RainLab\User\Models\Settings as UserSettings;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Initbiz\CumulusCore\Models\AutoAssignSettings;
use Initbiz\CumulusCore\Repositories\PlanRepository;
use Initbiz\CumulusCore\Repositories\UserRepository;
use Initbiz\CumulusCore\Repositories\ClusterRepository;

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
     * @var PlanRepository
     */
    protected $planRepository;

    /**
     * @var ClusterRepository
     */
    protected $clusterRepository;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $this->prepareEnv();
        $this->seedExamplePlans();
        $this->seedExampleClusters();
        $this->seedExampleUser();
        $this->seedAutoAssignSettings();
        $this->seedUserSettings();
        $this->output->writeln('Done!');
    }

    /**
     * Prepare eunvironment before running method
     * @return void
     */
    public function prepareEnv()
    {
        $this->planRepository = new PlanRepository();
        $this->clusterRepository = new ClusterRepository();
        $this->userRepository = new UserRepository();
    }

    /**
     * Seeds two example plans: free and full
     * the first will have access only to initbiz.cumulusdemo.free_feature
     * the second will have access to initbiz.cumulusdemo.free_feature and initbiz.cumulusdemo.paid_feature
     * @return void
     */
    public function seedExamplePlans()
    {
        $data = [
            'name' => 'Free',
            'features' => 'initbiz.cumulusdemo.free_feature'
        ];
        $this->planRepository->create($data);

        $data = [
            'name' => 'Full',
            'features' => [
                'initbiz.cumulusdemo.free_feature',
                'initbiz.cumulusdemo.paid_feature'
            ]
        ];
        $this->planRepository->create($data);
    }

    /**
     * Seeds two example clusters: ACME Corp. and Foo bar
     * the first will have Free plan
     * the second will have Full plan
     * @return void
     */
    public function seedExampleClusters()
    {
        //ACME Corp.
        $data = [
            'name' => 'ACME Corp.'
        ];

        $this->clusterRepository->create($data);
        $this->clusterRepository->addClusterToPlan('acme-corp', 'free');

        //Foo Bar
        $data = [
            'name' => 'Foo Bar',
        ];

        $this->clusterRepository->create($data);
        $this->clusterRepository->addClusterToPlan('foo-bar', 'full');
    }

    /**
     * Seeds example demo user with demo@example.com / demo credentials
     * @return void
     */
    public function seedExampleUser()
    {
        $data = [
            'name' => 'demo',
            'email' => 'demo@example.com',
            'is_activated' => "1",
            'password' => 'demo',
            'password_confirmation' => 'demo',
            'username' => 'demo@example.com',
        ];

        $user = $this->userRepository->create($data);
        $this->userRepository->activateUser($user->id);
        $this->userRepository->addUserToGroup($user->id, 'registered');
        $this->clusterRepository->addUserToCluster($user->id, 'acme-corp');
        $this->clusterRepository->addUserToCluster($user->id, 'foo-bar');
    }

    /**
     * Seeds Cumulus AutoAssign configuration
     * @return void
     */
    public function seedAutoAssignSettings()
    {
        $data = [
            "enable_auto_assign_user" => "1",
            "auto_assign_user" => "new_cluster",
            "auto_assign_user_get_cluster" => "cluster",
            "auto_assign_user_new_cluster" => "clustername",
            "enable_auto_assign_user_to_group" => "1",
            "group_to_auto_assign_user" => "registered",
            "enable_auto_assign_cluster" => "1",
            "auto_assign_cluster" => "concrete_plan",
            "auto_assign_cluster_get_plan" => "plan",
            "auto_assign_cluster_concrete_plan" => "free"
        ];
        AutoAssignSettings::set($data);
    }

    /**
    * Seeds RainLab.User configuration (see documentation)
    * @return void
    */
    public function seedUserSettings()
    {
        $data = [
            "require_activation" => "1",
            "activate_mode" => "auto",
            "use_throttle" => "1",
            "block_persistence" => "0",
            "allow_registration" => "1",
            "login_attribute" => "email"
        ];
        UserSettings::set($data);
    }
}
