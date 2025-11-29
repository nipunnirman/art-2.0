<?php
/**
 * Through My Pencil - Backend API with Email Notifications
 * Contact: nipunnirman999@gmail.com
 * WhatsApp: +94710545455
 */

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Business Configuration
define('ADMIN_EMAIL', 'nipunnirman999@gmail.com');
define('BUSINESS_NAME', 'Through My Pencil');
define('WHATSAPP_NUMBER', '+94710545455');

// Database Configuration
class Database {
    private $host = 'localhost';
    private $db_name = 'through_my_pencil';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            error_log("Connection error: " . $e->getMessage());
        }
        return $this->conn;
    }
}

// Email Helper
class EmailHelper {
    public static function sendToAdmin($subject, $message) {
        $headers = "From: noreply@throughmypencil.com\r\n";
        $headers .= "Reply-To: " . ADMIN_EMAIL . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        
        return mail(ADMIN_EMAIL, $subject, $message, $headers);
    }
    
    public static function formatRegistrationEmail($name, $email, $phone) {
        return "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; background: #f9f9f9; }
                    .header { 
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                        color: white; 
                        padding: 30px; 
                        text-align: center; 
                        border-radius: 10px 10px 0 0; 
                    }
                    .content { background: white; padding: 30px; }
                    .info-row { 
                        margin: 15px 0; 
                        padding: 15px; 
                        background: #f0f0f0; 
                        border-left: 4px solid #667eea;
                        border-radius: 5px;
                    }
                    .label { font-weight: bold; color: #667eea; display: inline-block; min-width: 100px; }
                    .value { color: #333; }
                    .footer { 
                        text-align: center; 
                        margin-top: 30px; 
                        padding: 20px; 
                        background: #f9f9f9; 
                        border-radius: 0 0 10px 10px;
                    }
                    .button {
                        display: inline-block;
                        padding: 12px 30px;
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        color: white;
                        text-decoration: none;
                        border-radius: 25px;
                        margin-top: 20px;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>🎨 New User Registration!</h1>
                        <p style='margin: 10px 0 0 0; opacity: 0.9;'>" . BUSINESS_NAME . "</p>
                    </div>
                    <div class='content'>
                        <p style='font-size: 1.1em; color: #667eea; font-weight: bold;'>
                            Great news! A new user has registered on your website.
                        </p>
                        
                        <div class='info-row'>
                            <span class='label'>👤 Name:</span>
                            <span class='value'>$name</span>
                        </div>
                        <div class='info-row'>
                            <span class='label'>📧 Email:</span>
                            <span class='value'>$email</span>
                        </div>
                        <div class='info-row'>
                            <span class='label'>📱 Phone:</span>
                            <span class='value'>$phone</span>
                        </div>
                        <div class='info-row'>
                            <span class='label'>🕐 Time:</span>
                            <span class='value'>" . date('F j, Y, g:i a') . "</span>
                        </div>
                        
                        <div style='margin-top: 30px; padding: 20px; background: #fff3cd; border-left: 4px solid #ffc107; border-radius: 5px;'>
                            <strong>💡 Tip:</strong> You can view all registered users and their details in your admin dashboard.
                        </div>
                    </div>
                    <div class='footer'>
                        <a href='http://yourwebsite.com/admin-dashboard.php' class='button'>
                            📊 View Admin Dashboard
                        </a>
                        <p style='margin-top: 20px; color: #666; font-size: 0.9em;'>
                            " . BUSINESS_NAME . " • " . ADMIN_EMAIL . "
                        </p>
                    </div>
                </div>
            </body>
            </html>
        ";
    }
}

// User Class
class User {
    private $conn;
    private $table = 'users';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($name, $email, $phone, $password) {
        try {
            // Check if email exists
            $query = "SELECT user_id FROM " . $this->table . " WHERE email = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$email]);
            
            if ($stmt->fetch()) {
                return ['success' => false, 'message' => 'Email already registered'];
            }

            // Insert new user
            $query = "INSERT INTO " . $this->table . " (name, email, phone, password, created_at) VALUES (?, ?, ?, ?, NOW())";
            $stmt = $this->conn->prepare($query);
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            if ($stmt->execute([$name, $email, $phone, $hashedPassword])) {
                // Send email notification to admin
                $emailSubject = "🎨 New Registration - " . BUSINESS_NAME;
                $emailMessage = EmailHelper::formatRegistrationEmail($name, $email, $phone);
                EmailHelper::sendToAdmin($emailSubject, $emailMessage);
                
                return ['success' => true, 'message' => 'Registration successful'];
            }
            
            return ['success' => false, 'message' => 'Registration failed'];
        } catch(PDOException $e) {
            error_log("Registration error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Database error'];
        }
    }

    public function login($email, $password) {
        try {
            $query = "SELECT user_id, name, email, password FROM " . $this->table . " WHERE email = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$email]);
            
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if (password_verify($password, $row['password'])) {
                    return [
                        'success' => true,
                        'user' => [
                            'user_id' => $row['user_id'],
                            'name' => $row['name'],
                            'email' => $row['email']
                        ]
                    ];
                }
            }
            
            return ['success' => false, 'message' => 'Invalid email or password'];
        } catch(PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Database error'];
        }
    }
    
    public function getAllUsers() {
        try {
            $query = "SELECT user_id, name, email, phone, created_at FROM " . $this->table . " ORDER BY created_at DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return [
                'success' => true,
                'users' => $stmt->fetchAll(PDO::FETCH_ASSOC)
            ];
        } catch(PDOException $e) {
            error_log("Get users error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Database error'];
        }
    }
    
    public function getUserStats() {
        try {
            // Total users
            $query = "SELECT COUNT(*) as total FROM " . $this->table;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Users today
            $query = "SELECT COUNT(*) as today FROM " . $this->table . " WHERE DATE(created_at) = CURDATE()";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $today = $stmt->fetch(PDO::FETCH_ASSOC)['today'];
            
            // Users this week
            $query = "SELECT COUNT(*) as week FROM " . $this->table . " WHERE YEARWEEK(created_at) = YEARWEEK(NOW())";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $week = $stmt->fetch(PDO::FETCH_ASSOC)['week'];
            
            // Users this month
            $query = "SELECT COUNT(*) as month FROM " . $this->table . " WHERE MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $month = $stmt->fetch(PDO::FETCH_ASSOC)['month'];
            
            return [
                'success' => true,
                'stats' => [
                    'total' => $total,
                    'today' => $today,
                    'this_week' => $week,
                    'this_month' => $month
                ]
            ];
        } catch(PDOException $e) {
            error_log("Get stats error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Database error'];
        }
    }
}

// Order Class
class Order {
    private $conn;
    private $table = 'orders';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($userId, $items, $total) {
        try {
            $query = "INSERT INTO " . $this->table . " (user_id, items, total_amount, status, created_at) VALUES (?, ?, ?, 'pending', NOW())";
            $stmt = $this->conn->prepare($query);
            
            if ($stmt->execute([$userId, json_encode($items), $total])) {
                return ['success' => true, 'message' => 'Order created'];
            }
            
            return ['success' => false, 'message' => 'Order failed'];
        } catch(PDOException $e) {
            error_log("Order error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Database error'];
        }
    }
}

// Contact Form Handler
class Contact {
    public static function send($name, $email, $message) {
        $subject = "📧 New Contact Form Submission - " . BUSINESS_NAME;
        $emailMessage = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; background: #f9f9f9; }
                    .header { 
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                        color: white; 
                        padding: 30px; 
                        text-align: center; 
                        border-radius: 10px 10px 0 0; 
                    }
                    .content { background: white; padding: 30px; }
                    .info-row { margin: 15px 0; padding: 15px; background: #f0f0f0; border-left: 4px solid #667eea; border-radius: 5px; }
                    .label { font-weight: bold; color: #667eea; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>📧 New Contact Message</h1>
                    </div>
                    <div class='content'>
                        <div class='info-row'>
                            <span class='label'>From:</span> $name
                        </div>
                        <div class='info-row'>
                            <span class='label'>Email:</span> $email
                        </div>
                        <div class='info-row'>
                            <span class='label'>Message:</span><br><br>
                            " . nl2br(htmlspecialchars($message)) . "
                        </div>
                        <div class='info-row'>
                            <span class='label'>Time:</span> " . date('F j, Y, g:i a') . "
                        </div>
                    </div>
                </div>
            </body>
            </html>
        ";
        
        return EmailHelper::sendToAdmin($subject, $emailMessage);
    }
}

// Router
$database = new Database();
$db = $database->getConnection();

if (!$db) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}

$endpoint = $_GET['endpoint'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];

// Get request data
$data = json_decode(file_get_contents('php://input'), true);

switch($endpoint) {
    case 'register':
        if ($method === 'POST') {
            $user = new User($db);
            $result = $user->register(
                $data['name'] ?? '',
                $data['email'] ?? '',
                $data['phone'] ?? '',
                $data['password'] ?? ''
            );
            echo json_encode($result);
        }
        break;

    case 'login':
        if ($method === 'POST') {
            $user = new User($db);
            $result = $user->login(
                $data['email'] ?? '',
                $data['password'] ?? ''
            );
            echo json_encode($result);
        }
        break;

    case 'users':
        if ($method === 'GET') {
            $user = new User($db);
            $result = $user->getAllUsers();
            echo json_encode($result);
        }
        break;
    
    case 'stats':
        if ($method === 'GET') {
            $user = new User($db);
            $result = $user->getUserStats();
            echo json_encode($result);
        }
        break;

    case 'order':
        if ($method === 'POST') {
            $order = new Order($db);
            $result = $order->create(
                $data['user_id'] ?? 0,
                $data['items'] ?? [],
                $data['total'] ?? 0
            );
            echo json_encode($result);
        }
        break;
    
    case 'contact':
        if ($method === 'POST') {
            $success = Contact::send(
                $data['name'] ?? '',
                $data['email'] ?? '',
                $data['message'] ?? ''
            );
            echo json_encode(['success' => $success]);
        }
        break;

    default:
        echo json_encode([
            'success' => false,
            'message' => 'Invalid endpoint',
            'available_endpoints' => [
                'register' => 'POST - Register new user',
                'login' => 'POST - User login',
                'users' => 'GET - Get all users (admin)',
                'stats' => 'GET - Get user statistics (admin)',
                'order' => 'POST - Create order',
                'contact' => 'POST - Contact form submission'
            ]
        ]);
        break;
}
?>