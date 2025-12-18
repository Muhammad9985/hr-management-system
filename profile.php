<?php
require_once 'config/database.php';
require_once 'classes/Database.php';
require_once 'classes/Auth.php';

$auth = new Auth();
$auth->requireLogin();

$db = new Database();
$user = $auth->getCurrentUser();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'change_password') {
        $oldPassword = $_POST['old_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        if ($newPassword !== $confirmPassword) {
            $error = 'New passwords do not match';
        } elseif (strlen($newPassword) < 4) {
            $error = 'Password must be at least 4 characters';
        } elseif ($auth->changePassword($_SESSION['user_id'], $oldPassword, $newPassword)) {
            $message = 'Password changed successfully';
        } else {
            $error = 'Current password is incorrect';
        }
    }
}

$pageTitle = 'My Profile';
include 'includes/header.php';
?>

<div class="row mb-4">
    <div class="col-md-6">
        <h1 class="h3 mb-0">
            <i class="fas fa-user me-2"></i>
            My Profile
        </h1>
    </div>
</div>

<?php if (isset($message)): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-2"></i>
        <?php echo $message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (isset($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle me-2"></i>
        <?php echo $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="avatar bg-primary text-white rounded-circle mx-auto mb-3" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                    <?php echo strtoupper(substr($user['username'], 0, 2)); ?>
                </div>
                <h4><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h4>
                <p class="text-muted"><?php echo ucfirst($user['role']); ?></p>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Account Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>Username:</strong><br>
                        <?php echo htmlspecialchars($user['username']); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Email:</strong><br>
                        <?php echo htmlspecialchars($user['email']); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Role:</strong><br>
                        <?php echo ucfirst(str_replace('_', ' ', $user['role'])); ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>Member Since:</strong><br>
                        <?php echo date('M d, Y', strtotime($user['created_at'])); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Change Password</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="action" value="change_password">
                    
                    <div class="mb-3">
                        <label for="old_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="old_password" name="old_password" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-key me-2"></i>Change Password
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>