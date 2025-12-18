<?php
require_once 'config/database.php';
require_once 'classes/Database.php';
require_once 'classes/Auth.php';

$auth = new Auth();
$auth->requireLogin();

$db = new Database();

// Handle password change
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    
    if ($action === 'change_password') {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];
        
        if ($newPassword !== $confirmPassword) {
            $error = 'New passwords do not match';
        } elseif ($auth->changePassword($_SESSION['user_id'], $currentPassword, $newPassword)) {
            $success = 'Password changed successfully';
        } else {
            $error = 'Current password is incorrect';
        }
    }
}

$user = $auth->getCurrentUser();

$pageTitle = 'Settings';
include 'includes/header.php';
?>

<div class="row mb-4">
    <div class="col-md-6">
        <h1 class="h3 mb-0">
            <i class="fas fa-cog me-2"></i>
            Settings
        </h1>
    </div>
</div>

<?php if (isset($success)): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-key me-2"></i>
                    Change Password
                </h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="action" value="change_password">
                    
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="new_password" class="form-control" required minlength="6">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="confirm_password" class="form-control" required minlength="6">
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Change Password
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2"></i>
                    Account Information
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                </div>
                
                <?php if ($user['first_name']): ?>
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>" readonly>
                    </div>
                <?php endif; ?>
                
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($_SESSION['role_display'] ?? $_SESSION['role']); ?>" readonly>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-palette me-2"></i>
                    Preferences
                </h5>
            </div>
            <div class="card-body">
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="darkMode">
                    <label class="form-check-label" for="darkMode">
                        Dark Mode
                    </label>
                </div>
                
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="notifications" checked>
                    <label class="form-check-label" for="notifications">
                        Email Notifications
                    </label>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Language</label>
                    <select class="form-select">
                        <option value="en" selected>English</option>
                        <option value="hi">Hindi</option>
                    </select>
                </div>
                
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Save Preferences
                </button>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    System Information
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <strong>Version:</strong> 1.0.0
                </div>
                <div class="mb-2">
                    <strong>Last Login:</strong> <?php echo date('M d, Y h:i A'); ?>
                </div>
                <div class="mb-2">
                    <strong>Session Expires:</strong> <?php echo date('M d, Y h:i A', time() + 3600); ?>
                </div>
                <div class="mb-2">
                    <strong>Server Time:</strong> <?php echo date('M d, Y h:i A'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>