<?php
require_once __DIR__ . '/../Models/DashboardModel.php';

class DashboardController
{
    private $dashboardModel;

    public function __construct($pdo)
    {
        $this->dashboardModel = new DashboardModel($pdo);
    }

    public function stats()
    {
        $stats = $this->dashboardModel->getAllStats();
        $upcomingEvents = $this->dashboardModel->getUpcomingEvents();

        return [
            'success' => true,
            'data' => [
                'stats' => $stats,
                'upcoming_events' => $upcomingEvents
            ]
        ];
    }

    public function kainList()
    {
        $kainData = $this->dashboardModel->getAllKain();

        return [
            'success' => true,
            'data' => $kainData
        ];
    }
}
