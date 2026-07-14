<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LogController extends Controller
{
    /**
     * Display a listing of system logs.
     */
    public function index(Request $request)
    {
        $logPath = storage_path('logs/laravel.log');
        $logs = [];
        $fileSize = 0;

        if (File::exists($logPath)) {
            $fileSize = File::size($logPath);
            
            // Read only the last 2MB to prevent memory exhaustion on large files
            $content = $this->readLastBytes($logPath, 2 * 1024 * 1024);
            
            // Regex to match Laravel's standard log entry pattern:
            // [YYYY-MM-DD HH:MM:SS] env.LEVEL: Message
            $pattern = '/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\].*/';
            preg_match_all($pattern, $content, $headings);
            
            $entries = preg_split($pattern, $content);
            // The first split chunk contains whatever was before the first match (if any)
            array_shift($entries);

            if (isset($headings[0])) {
                foreach ($headings[0] as $index => $heading) {
                    preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] (\w+)\.(\w+): (.*)/', $heading, $matches);
                    
                    if (count($matches) >= 5) {
                        $date = $matches[1];
                        $env = $matches[2];
                        $level = strtoupper($matches[3]);
                        $message = $matches[4];
                    } else {
                        $date = '';
                        $env = '';
                        $level = 'UNKNOWN';
                        $message = $heading;
                    }

                    $stackTrace = isset($entries[$index]) ? trim($entries[$index]) : '';

                    $logs[] = [
                        'date' => $date,
                        'env' => $env,
                        'level' => $level,
                        'message' => $message,
                        'stack_trace' => $stackTrace,
                    ];
                }
            }
        }

        // Reverse logs to show the latest entries first
        $logs = array_reverse($logs);

        // Filter by Level
        $selectedLevel = $request->input('level');
        if ($selectedLevel) {
            $logs = array_filter($logs, fn($log) => $log['level'] === strtoupper($selectedLevel));
        }

        // Search filter
        $search = $request->input('search');
        if ($search) {
            $logs = array_filter($logs, function($log) use ($search) {
                return stripos($log['message'], $search) !== false || stripos($log['stack_trace'], $search) !== false;
            });
        }

        // Manual Pagination
        $page = (int) $request->input('page', 1);
        $perPage = 20;
        $total = count($logs);
        $offset = ($page - 1) * $perPage;
        
        $paginatedLogs = array_slice($logs, $offset, $perPage);
        $totalPages = ceil($total / $perPage);

        return view('admin.logs.index', [
            'logs' => $paginatedLogs,
            'levels' => ['DEBUG', 'INFO', 'NOTICE', 'WARNING', 'ERROR', 'CRITICAL', 'ALERT', 'EMERGENCY'],
            'selectedLevel' => $selectedLevel,
            'search' => $search,
            'page' => $page,
            'totalPages' => $totalPages,
            'total' => $total,
            'fileSize' => $fileSize,
        ]);
    }

    /**
     * Clear the log file.
     */
    public function clear()
    {
        $logPath = storage_path('logs/laravel.log');
        
        if (File::exists($logPath)) {
            File::put($logPath, '');
        }

        return redirect()->route('admin.logs.index')
            ->with('success', 'File log berhasil dikosongkan!');
    }

    /**
     * Read only the last N bytes of a file to prevent memory issues.
     */
    private function readLastBytes($path, $bytes)
    {
        if (!File::exists($path)) {
            return '';
        }

        $size = File::size($path);
        if ($size <= $bytes) {
            return File::get($path);
        }

        $fp = fopen($path, 'r');
        if (!$fp) {
            return '';
        }

        // Seek backwards from end of file
        fseek($fp, -$bytes, SEEK_END);
        $data = fread($fp, $bytes);
        fclose($fp);

        // Find the first line break so we don't return a half-cut log line
        $firstLineBreak = strpos($data, "\n");
        if ($firstLineBreak !== false) {
            return substr($data, $firstLineBreak + 1);
        }

        return $data;
    }
}
