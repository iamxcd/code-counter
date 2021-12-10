<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Storage;
use LaravelZero\Framework\Commands\Command;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class RunCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'run';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = '启动程序';

    private $config;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // 导入配置
        if (file_exists(getcwd() . '/config.php')) {
            $this->config = require getcwd() . '/config.php';
        } else {
            dd("配置文件 config.php 不存在");
        }

        file_put_contents($this->config['outfile'], '');

        $this->getDirOrFile($this->config['path']);
    }

    public function getDirOrFile($path)
    {
        $res = scandir($path);
        foreach ($res as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            $tmp_path = $path . '/' . $item;
            if (is_dir($tmp_path)) {
                if (in_array($item, $this->config['except'])) {
                    continue;
                }
                $this->getDirOrFile($tmp_path);
            } else {
                $this->readFile($tmp_path);
            }
        }
    }

    public function readFile($path)
    {
        $info = pathinfo($path);
        if (!in_array($info['extension'] ?? '', $this->config['suffix'])) {
            return;
        }
        $content = file_get_contents($path);
        file_put_contents("code.txt", $content, FILE_APPEND);
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
