<?php
//
//use Exception;
//use RuntimeException;

class BackgroundProcess
{
    const OS_WINDOWS = 1;
    const OS_NIX = 2;
    const OS_OTHER = 3;

    private $command;
    private $pid;
    protected $serverOS;

    public function __construct($command = null)
    {
        $this->command = $command;
        $this->serverOS = $this->getOS();
    }

    public function run($outputFile = '/dev/null', $append = false)
    {
        if ($this->command === null) {
            return;
        }
        switch ($this->getOS()) {
            case self::OS_WINDOWS:
                shell_exec(sprintf('%s &', $this->command, 'NUL'));
                break;
            case self::OS_NIX:
                $this->pid = (int)shell_exec(sprintf('%s %s %s 2>&1 & echo $!', $this->command, ($append) ? '>>' : '>', $outputFile));
                break;
            default:
                throw new RuntimeException(sprintf(
                    'Could not execute command "%s" because operating system "%s" is not supported by ' .
                    'Cocur\BackgroundProcess.',
                    $this->command,
                    PHP_OS
                ));
        }
    }

    public function isRunning()
    {
        $this->checkSupportingOS('shubzz\BackgroundProcess can only check if a process is running on *nix-based ' .
            'systems, such as Unix, Linux or Mac OS X. You are running "%s".');
        try {
            $result = shell_exec(sprintf('ps %d 2>&1', $this->pid));
            if (count(preg_split("/\n/", $result)) > 2 && !preg_match('/ERROR: Process ID out of range/', $result)) {
                return true;
            }
        } catch (Exception $e) {
        }
        return false;
    }

    public function stop()
    {
        $this->checkSupportingOS('shubzz\BackgroundProcess can only stop a process on *nix-based systems, such as ' .
            'Unix, Linux or Mac OS X. You are running "%s".');
        try {
            $result = shell_exec(sprintf('kill %d 2>&1', $this->pid));
            if (!preg_match('/No such process/', $result)) {
                return true;
            }
        } catch (Exception $e) {
        }

        return false;
    }

    public function getPid()
    {
        $this->checkSupportingOS('shubzz\BackgroundProcess can only return the PID of a process on *nix-based systems, ' .
            'such as Unix, Linux or Mac OS X. You are running "%s".');

        return $this->pid;
    }

    protected function setPid($pid)
    {
        $this->pid = $pid;
    }

    protected function getOS()
    {
        $os = strtoupper(PHP_OS);

        if (substr($os, 0, 3) === 'WIN') {
            return self::OS_WINDOWS;
        } else if ($os === 'LINUX' || $os === 'FREEBSD' || $os === 'DARWIN') {
            return self::OS_NIX;
        }

        return self::OS_OTHER;
    }

    protected function checkSupportingOS($message)
    {
        if ($this->getOS() !== self::OS_NIX) {
            throw new RuntimeException(sprintf($message, PHP_OS));
        }
    }

    static public function createFromPID($pid)
    {
        $process = new self();
        $process->setPid($pid);
        return $process;
    }

}