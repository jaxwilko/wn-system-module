<?php namespace System\Console;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Symfony\Component\Console\Input\InputArgument;
use Cms\Classes\Theme;

class ThemeUse extends Command
{
    use ConfirmableTrait;

    /**
     * The console command name.
     * @var string
     */
    protected $name = 'theme:use';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Switch the active theme.';

    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return void
     */
    public function fire()
    {
        if (!$this->confirmToProceed('Do you really want to change the active theme?')) {
            return;
        }

        $newThemeName = $this->argument('name');
        $newTheme = Theme::load($newThemeName);

        if (!$newTheme->exists($newThemeName)) {
            return $this->error(sprintf('The theme %s does not exist.', $newThemeName));
        }

        if ($newTheme->isActiveTheme()) {
            return $this->error(sprintf('%s is already the active theme.', $newTheme->getId()));
        }

        $activeTheme = Theme::getActiveTheme();
        $from = $activeTheme ? $activeTheme->getId() : 'nothing';

        $this->info(sprintf('Switching theme from %s to %s', $from, $newTheme->getId()));

        Theme::setActiveTheme($newThemeName);
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the theme. (directory name)'],
        ];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
