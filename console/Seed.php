<?php namespace Initbiz\CumulusDemo\Console;

use Carbon\Carbon;
use RainLab\User\Models\User;
use Illuminate\Console\Command;
use RainLab\User\Models\UserGroup;
use Initbiz\CumulusCore\Models\Plan;
use Initbiz\CumulusCore\Models\Cluster;
use RainLab\Notify\Models\NotificationRule;
use Initbiz\CumulusCore\Classes\FeatureManager;
use Symfony\Component\Console\Input\InputOption;
use RainLab\User\Models\Settings as UserSettings;
use Initbiz\CumulusCore\Models\AutoAssignSettings;
use Symfony\Component\Console\Input\InputArgument;
use Initbiz\CumulusSubscriptions\Models\Subscription;

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
        $this->prepareEnv();
        $this->seedExamplePlans();
        $this->seedExampleClusters();
        $this->seedExampleSubscriptions();
        $this->seedExampleUser();
        $this->rainlabNotify();
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
        $this->planRepository = new Plan();
        $this->clusterRepository = new Cluster();
    }

    /**
     * Seeds two example plans: free and full
     * the first will have access only to initbiz.cumulusdemo.free_feature
     * the second will have access to initbiz.cumulusdemo.free_feature and initbiz.cumulusdemo.paid_feature
     * @return void
     */
    public function seedExamplePlans()
    {
        $featureManager = FeatureManager::instance();
        $featureManager->clearCache();

        $this->output->writeln('<info>- cumulus</info>');

        // Basic plan create
        $basicPlan = Plan::where('slug', 'basic')->first();


        if (!$basicPlan) {
            $basicPlan = new Plan();
            $basicPlan->name = 'Basic';
            $basicPlan->slug = 'basic';
            $basicPlan->is_expiring = false;
            $basicPlan->is_paid = false;
            $basicPlan->is_registration_allowed = true;
        }

        $basicPlan->features = [
            'initbiz.cumulusdemo.basic.dashboard',
            'initbiz.cumulusdemo.basic.todo',
            'initbiz.cumulussubscriptions.manage_subscription',
            'initbiz.cumulusplus.cluster_settings',
        ];
        $basicPlan->save();

        //Plus plan create 
        $plusPlan = Plan::where('slug', 'plus')->first();

        if (!$plusPlan) {
            $plusPlan = new Plan();
            $plusPlan->name = 'Plus';
            $plusPlan->slug = 'plus';
            $plusPlan->is_expiring = true;
            $plusPlan->is_paid = true;
            $plusPlan->is_registration_allowed = false;
        }

        $plusPlan->features = [
            'initbiz.cumulusdemo.advanced.dashboard',
            'initbiz.cumulusdemo.basic.dashboard',
            'initbiz.cumulusdemo.basic.gallery',
            'initbiz.cumulussubscriptions.manage_subscription',
            'initbiz.cumulusplus.cluster_settings',
            'initbiz.cumulusdemo.basic.todo'
        ];
        $plusPlan->save();

        //Plus pro create 
        $proPlan = Plan::where('slug', 'pro')->first();

        if (!$proPlan) {
            $proPlan = new Plan();
            $proPlan->name = 'Pro';
            $proPlan->slug = 'pro';
            $proPlan->is_expiring = true;
            $proPlan->is_paid = true;
            $proPlan->is_registration_allowed = false;
        }

        $proPlan->features = [
            'initbiz.cumulusdemo.advanced.dashboard',
            'initbiz.cumulusdemo.advanced.todo',
            'initbiz.cumulusdemo.advanced.gallery',
            'initbiz.cumulusdemo.basic.dashboard',
            'initbiz.cumulussubscriptions.manage_subscription',
            'initbiz.cumulusplus.cluster_settings',
        ];
        $proPlan->save();
    }

    /**
     * Seeds two example clusters: ACME Corp. and Foo bar
     * the first will have Free plan
     * the second will have Full plan
     * @return void
     */
    public function seedExampleClusters()
    {
        $basicPlan = Plan::where('slug', 'basic')->first();
        $smallcompany = Cluster::where('slug', 'small_company')->first();
        if (!$smallcompany){
            $smallcompany = new Cluster();
            $smallcompany->name = 'Small Company';
            $smallcompany->slug = 'small_company';
            $smallcompany->plan = $basicPlan->id;
            $smallcompany->save();
        }

        $plusPlan = Plan::where('slug', 'plus')->first();
        $mediumcompany = Cluster::where('slug', 'medium_company')->first();
        if (!$mediumcompany){
            $mediumcompany = new Cluster();
            $mediumcompany->name = 'Medium Company';
            $mediumcompany->slug = 'medium_company';
            $mediumcompany->plan = $plusPlan->id;
            $mediumcompany->save();
        }

        $proPlan = Plan::where('slug', 'pro')->first();
        $bigcompany = Cluster::where('slug', 'big_company')->first();
        if (!$bigcompany){
            $bigcompany = new Cluster();
            $bigcompany->name = 'Big Company';
            $bigcompany->slug = 'big_company';
            $bigcompany->plan = $proPlan->id;
            $bigcompany->save();
        }
    }
    
    public function seedExampleSubscriptions()
    {
        $smallcompany = Cluster::where('slug', 'small_company')->first();
        $subsryption = $smallcompany->subscription;
        if(!$subsryption)
        {
            $subsryption = new Subscription();
            $subsryption->is_active = true;
            $subsryption->cluster_slug = $smallcompany->slug;
            $subsryption->plan = Plan::where('slug', 'plus')->first();
            $subsryption->starts_at = Carbon::now();
            $subsryption->save();
        }
        
        $mediumcompany = Cluster::where('slug', 'medium_company')->first();
        $subsryption = $mediumcompany->subscription;
        if(!$subsryption)
        {
            $subsryption = new Subscription();
            $subsryption->is_active = true;
            $subsryption->cluster_slug = $mediumcompany->slug;
            $subsryption->plan = Plan::where('slug', 'pro')->first();
            $subsryption->starts_at = Carbon::now();
            $subsryption->save();
        }
        
        $bigcompany = Cluster::where('slug', 'big_company')->first();
        $subsryption =$bigcompany->subscription;
        if(!$subsryption)
        {
            $subsryption = new Subscription();
            $subsryption->is_active = true;
            $subsryption->cluster_slug = $bigcompany->slug;
            $subsryption->plan = Plan::where('slug', 'basic')->first();
            $subsryption->starts_at = Carbon::now();
            $subsryption->save();
        }
    }

    public function rainlabNotify()
    {
        $this->output->writeln('<info>- notify</info>');

        //Disabling notifiing new users
        $rule = NotificationRule::where('code', 'welcome_email')->first();

        if ($rule) {
            $rule->is_enabled = false;
            $rule->save();
        }
    }

    /**
     * Seeds example demo user with demo@example.com / demo credentials
     * @return void
     */
    public function seedExampleUser()
    {
        $user = User::where('email', 'demo@initbiz.com')->first();
        if(!$user){
            $user = new User();
            $user->name = 'demo';
            $user->name = 'demo';
            $user->email = 'demo@initbiz.com';
            $user->is_activated = "1";
            $user->password = 'demo@initbiz.com';
            $user->password_confirmation = 'demo@initbiz.com';
            $user->username = 'demo@initbiz.com';
            $user->save();

            $group = UserGroup::where('code', 'registered')->first();
            $user->groups()->add($group, $user->id);

            $smallcompany = Cluster::where('slug', 'small_company')->first();
            $user->clusters()->syncWithoutDetaching($smallcompany, $user->id);
            $mediumcompany = Cluster::where('slug', 'medium_company')->first();
            $user->clusters()->syncWithoutDetaching($mediumcompany, $user->id);
            $bigcompany = Cluster::where('slug', 'big_company')->first();
            $user->clusters()->syncWithoutDetaching($bigcompany, $user->id);
        }
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
            "auto_assign_cluster_concrete_plan" => "basic"
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
            "login_attribute" => "email",
            "remember_login"        => "always",
        ];
        UserSettings::set($data);
    }
}
