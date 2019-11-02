<?php namespace Initbiz\CumulusDemo\Console;

use Carbon\Carbon;
use RainLab\User\Models\User;
use Illuminate\Console\Command;
use System\Classes\PluginManager;
use RainLab\User\Models\UserGroup;
use Initbiz\CumulusCore\Models\Plan;
use RainLab\Translate\Models\Locale;
use RainLab\Translate\Models\Message;
use Initbiz\CumulusCore\Models\Cluster;
use RainLab\Notify\Models\NotificationRule;
use RainLab\Translate\Classes\ThemeScanner;
use Initbiz\CumulusCore\Classes\FeatureManager;
use Symfony\Component\Console\Input\InputOption;
use RainLab\User\Models\Settings as UserSettings;
use Initbiz\CumulusAnnouncements\Models\Announcer;
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
        $pluginManager = PluginManager::instance();
        $this->seedExamplePlans();
        $this->seedExampleClusters();
        if($pluginManager->hasPlugin('Initbiz.CumulusSubsacriptions')){
            $this->seedExampleSubscriptions();
        }
        if($pluginManager->hasPlugin('Initbiz.CumulusAnnouncements')){
            $this->seedExampleAnnouncer();
        }
        $this->seedExampleUser();
        $this->rainlabNotify();
        $this->rainlabTranslate();
        $this->seedAutoAssignSettings();
        $this->seedUserSettings();
        $this->output->writeln('Done!');
    }

    /**
     * Seeds two example plans: basic, plus and pro
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

        //Pro plan create 
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
            'initbiz.cumulusdemo.basic.todo',
            'initbiz.cumulusdemo.basic.gallery',
            'initbiz.cumulusdemo.advanced.gallery',
            'initbiz.cumulusdemo.basic.dashboard',
            'initbiz.cumulussubscriptions.manage_subscription',
            'initbiz.cumulusplus.cluster_settings',
        ];
        $proPlan->save();
    }

    /**
     * Seeds two example clusters: Small Company, Medium Company and Big Company
     * the first will have Basic plan
     * the second will have Plus plan
     * the thirds will have Pro plan 
     *
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
   
   /**
    * Undocumented function
    *
    * @return void
    */ 
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

    public function seedExampleAnnouncer()
    {
        $announcer = Announcer::where('title', 'Hello')->first();
        if(!$announcer)
        {
            $announcer = new Announcer();
            $announcer->title = 'Hello';
            $announcer->content = "Hello world. I'm your first Announcement :)";
            $announcer->published = true;
            $announcer->type = "initbiz-cumuluscore-announcertypes-userregisterannouncertype";
            $announcer->save();
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
    public function rainlabTranslate()
    {
        $this->output->writeln('<info>- translate</info>');

        //Adding Polish language
        $locale = Locale::where('code', 'pl')->first();

        if (!$locale) {
            $locale = new Locale();
            $locale->is_enabled = true;
            $locale->code = 'pl';
            $locale->name = 'Polski';
            $locale->save();
        }

        Message::truncate();
        ThemeScanner::scan();
    }

    /**
     * Seeds example demo user with demo@init.biz / demo credentials
     * @return void
     */
    public function seedExampleUser()
    {
        $user = User::where('email', 'demo@init.biz')->first();
        if(!$user){
            $user = new User();
            $user->name = 'demo';
            $user->name = 'demo';
            $user->email = 'demo@init.biz';
            $user->is_activated = "1";
            $user->password = 'demo@init.biz';
            $user->password_confirmation = 'demo@init.biz';
            $user->username = 'demo@init.biz';
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
