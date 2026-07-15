<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PageVisit extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = 'visited_at';

    protected $fillable = [
        'page_type',
        'page_id',
        'url',
        'title',
        'ip_address',
        'user_agent',
        'visited_at',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
    ];

    // ── Scopes ──

    public function scopeToday($query)
    {
        return $query->whereDate('visited_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('visited_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('visited_at', now()->month)
                     ->whereYear('visited_at', now()->year);
    }

    public function scopeByPageType($query, string $type)
    {
        return $query->where('page_type', $type);
    }

    // ── Helpers ──

    /**
     * Get daily visit counts for the last N days.
     */
    public static function dailyVisits(int $days = 7): array
    {
        $results = self::where('visited_at', '>=', now()->subDays($days - 1)->startOfDay())
            ->select(DB::raw('DATE(visited_at) as date'), DB::raw('COUNT(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Fill missing days with 0
        $data = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $data[$date] = (int) ($results[$date] ?? 0);
        }

        return $data;
    }

    /**
     * Get most visited pages for a period.
     */
    public static function mostVisitedPages(int $limit = 5, ?string $since = null): array
    {
        $query = self::select('page_type', 'page_id', 'title', 'url', DB::raw('COUNT(*) as count'))
            ->groupBy('page_type', 'page_id', 'title', 'url')
            ->orderBy('count', 'desc');

        if ($since) {
            $query->where('visited_at', '>=', $since);
        }

        return $query->limit($limit)->get()->toArray();
    }

    /**
     * Get visit breakdown by page type.
     */
    public static function visitsByType(?string $since = null): array
    {
        $query = self::select('page_type', DB::raw('COUNT(*) as count'))
            ->groupBy('page_type')
            ->orderBy('count', 'desc');

        if ($since) {
            $query->where('visited_at', '>=', $since);
        }

        return $query->pluck('count', 'page_type')->toArray();
    }

    /**
     * Get unique visitors (by IP) count for a period.
     */
    public static function uniqueVisitors(?string $since = null): int
    {
        $query = self::select(DB::raw('COUNT(DISTINCT ip_address) as count'));

        if ($since) {
            $query->where('visited_at', '>=', $since);
        }

        return (int) $query->value('count');
    }

    /**
     * Get hourly visit distribution for today.
     */
    public static function hourlyVisitsToday(): array
    {
        $driver = DB::connection()->getDriverName();
        $hourExpr = $driver === 'sqlite'
            ? "CAST(strftime('%H', visited_at) AS INTEGER)"
            : 'HOUR(visited_at)';

        $results = self::whereDate('visited_at', today())
            ->select(DB::raw("{$hourExpr} as hour"), DB::raw('COUNT(*) as count'))
            ->groupBy('hour')
            ->orderBy('hour')
            ->pluck('count', 'hour')
            ->toArray();

        $data = [];
        for ($h = 0; $h < 24; $h++) {
            $data[] = (int) ($results[$h] ?? 0);
        }

        return $data;
    }

    /**
     * Check if the same IP has visited this page type+id today.
     * Used to avoid inflating views_count on refresh/navigation.
     */
    public static function hasVisitedToday(string $pageType, $pageId, string $ip): bool
    {
        if (empty($ip) || $ip === '127.0.0.1' || $ip === '::1') {
            return false; // Don't deduplicate local requests
        }

        return self::where('page_type', $pageType)
            ->where('page_id', $pageId)
            ->where('ip_address', $ip)
            ->whereDate('visited_at', today())
            ->exists();
    }
}
