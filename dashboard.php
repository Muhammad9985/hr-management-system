<?php
require_once 'config/database.php';
require_once 'classes/Database.php';
require_once 'classes/Auth.php';
require_once 'classes/Employee.php';
require_once 'classes/Onboarding.php';
require_once 'classes/Payroll.php';
require_once 'classes/Attendance.php';

$auth = new Auth();
$auth->requireLogin();

$employee = new Employee();
$onboarding = new Onboarding();
$payroll = new Payroll();
$attendance = new Attendance();

// Get dashboard statistics
$employeeStats = $employee->getStats();
$onboardingStats = $onboarding->getStats();
$upcomingBirthdays = $employee->getUpcomingBirthdays();
$departmentStats = $employee->getDepartmentStats();

$pageTitle = 'Dashboard - HR Management System';
include __DIR__ . '/includes/header.php';
?>

<div class="row mb-4">
    <div class="col-md-6">
        <h1 class="h3 mb-0">
            <i class="fas fa-tachometer-alt me-2"></i>
            Dashboard
        </h1>
        <p class="text-muted">Welcome back, <?php echo $_SESSION['full_name'] ?? $_SESSION['username']; ?>!</p>
    </div>
    <div class="col-md-6 text-end">
        <?php if ($auth->hasPermission('users.view')): ?>
            <a href="modules/admin/" class="btn btn-primary btn-sm me-2">
                <i class="fas fa-users-cog me-2"></i>Manage Users
            </a>
        <?php endif; ?>
        <?php if ($auth->hasPermission('employees.view')): ?>
            <a href="modules/employees/directory.php" class="btn btn-info btn-sm me-2">
                <i class="fas fa-address-book me-2"></i>Directory
            </a>
        <?php endif; ?>
        <?php if ($auth->hasPermission('reports.view')): ?>
            <a href="modules/reports/" class="btn btn-success btn-sm">
                <i class="fas fa-chart-bar me-2"></i>Reports
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-white-50">Total Employees</h6>
                        <h2 class="mb-0"><?php echo $employeeStats['total']; ?></h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stats-card h-100" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-white-50">Active Employees</h6>
                        <h2 class="mb-0"><?php echo $employeeStats['active']; ?></h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-check fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stats-card h-100" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-white-50">On Probation</h6>
                        <h2 class="mb-0"><?php echo $employeeStats['probation']; ?></h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-clock fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stats-card h-100" style="background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-white-50">Active Onboarding</h6>
                        <h2 class="mb-0"><?php echo $onboardingStats['active_processes']; ?></h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-plus fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Department Distribution Chart -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-pie me-2"></i>
                    Department Distribution
                </h5>
            </div>
            <div class="card-body">
                <canvas id="departmentChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Onboarding Progress -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-tasks me-2"></i>
                    Onboarding Overview
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <h3 class="text-primary"><?php echo $onboardingStats['total_processes']; ?></h3>
                        <small class="text-muted">Total Processes</small>
                    </div>
                    <div class="col-4">
                        <h3 class="text-success"><?php echo $onboardingStats['completed_processes']; ?></h3>
                        <small class="text-muted">Completed</small>
                    </div>
                    <div class="col-4">
                        <h3 class="text-danger"><?php echo $onboardingStats['overdue_tasks']; ?></h3>
                        <small class="text-muted">Overdue Tasks</small>
                    </div>
                </div>
                
                <div class="mt-4">
                    <canvas id="onboardingChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Activities -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-clock me-2"></i>
                    Recent Activities
                </h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">New Employee Onboarding Started</h6>
                            <p class="text-muted mb-1">John Doe's onboarding process has been initiated</p>
                            <small class="text-muted">2 hours ago</small>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Payroll Processed</h6>
                            <p class="text-muted mb-1">Monthly payroll for March 2024 has been processed</p>
                            <small class="text-muted">1 day ago</small>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker bg-warning"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Document Verification Pending</h6>
                            <p class="text-muted mb-1">5 employee documents are pending verification</p>
                            <small class="text-muted">2 days ago</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Birthdays -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-birthday-cake me-2"></i>
                    Upcoming Birthdays
                </h5>
            </div>
            <div class="card-body">
                <?php if (empty($upcomingBirthdays)): ?>
                    <p class="text-muted text-center">No upcoming birthdays</p>
                <?php else: ?>
                    <?php foreach ($upcomingBirthdays as $birthday): ?>
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar bg-primary text-white rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <?php echo strtoupper(substr($birthday['first_name'], 0, 1)); ?>
                            </div>
                            <div>
                                <h6 class="mb-0"><?php echo $birthday['first_name'] . ' ' . $birthday['last_name']; ?></h6>
                                <small class="text-muted"><?php echo date('M d', strtotime($birthday['date_of_birth'])); ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
$customJS = "
<script>
// Department Distribution Chart
const departmentCtx = document.getElementById('departmentChart').getContext('2d');
const departmentData = " . json_encode($departmentStats) . ";

new Chart(departmentCtx, {
    type: 'doughnut',
    data: {
        labels: departmentData.map(d => d.name),
        datasets: [{
            data: departmentData.map(d => d.employee_count),
            backgroundColor: [
                '#667eea',
                '#764ba2',
                '#f093fb',
                '#f5576c',
                '#4facfe',
                '#00f2fe'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Onboarding Progress Chart
const onboardingCtx = document.getElementById('onboardingChart').getContext('2d');
const onboardingData = " . json_encode($onboardingStats) . ";

new Chart(onboardingCtx, {
    type: 'bar',
    data: {
        labels: ['Total', 'Active', 'Completed', 'Overdue Tasks'],
        datasets: [{
            data: [
                onboardingData.total_processes,
                onboardingData.active_processes,
                onboardingData.completed_processes,
                onboardingData.overdue_tasks
            ],
            backgroundColor: ['#667eea', '#ffc107', '#28a745', '#dc3545'],
            borderRadius: 8,
            borderSkipped: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
</script>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.timeline::before {
    content: '';
    position: absolute;
    left: -30px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.avatar {
    font-size: 14px;
    font-weight: bold;
}
</style>
";

include __DIR__ . '/includes/footer.php';
?>
