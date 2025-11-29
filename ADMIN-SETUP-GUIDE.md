# 🎯 Admin Dashboard & Email Setup Guide

## ✅ What's New

### 1. 📧 Automatic Email Notifications
When a user registers, you (nipunnirman999@gmail.com) receive:
- ✅ Beautifully formatted HTML email
- ✅ User's name, email, phone
- ✅ Registration date and time
- ✅ Link to admin dashboard

### 2. 📊 Admin Dashboard
Access at: `admin-dashboard.php`
- ✅ Total registered users
- ✅ New users today
- ✅ New users this week
- ✅ New users this month
- ✅ Complete user list with emails
- ✅ Search functionality
- ✅ Export to CSV
- ✅ Auto-refresh every 30 seconds

### 3. 📱 Updated WhatsApp Number
- ✅ Changed to: +94710545455
- ✅ All checkout buttons use this number

---

## 🚀 Quick Setup (5 minutes)

### Step 1: Configure Email Sending

Your server needs to be able to send emails. Here are options:

#### Option A: Use XAMPP (Local Testing)
```bash
# Install XAMPP
# Edit php.ini file
# Find these lines and update:

[mail function]
SMTP = smtp.gmail.com
smtp_port = 587
sendmail_from = nipunnirman999@gmail.com
sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t"

# Edit sendmail.ini file
[sendmail]
smtp_server=smtp.gmail.com
smtp_port=587
auth_username=nipunnirman999@gmail.com
auth_password=YOUR_APP_PASSWORD
force_sender=nipunnirman999@gmail.com
```

#### Option B: Use PHPMailer (Recommended for Production)

Create `email_config.php`:
```php
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendEmail($to, $subject, $message) {
    $mail = new PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'nipunnirman999@gmail.com';
        $mail->Password = 'YOUR_APP_PASSWORD'; // Get from Google
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        $mail->setFrom('nipunnirman999@gmail.com', 'Through My Pencil');
        $mail->addAddress($to);
        
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email error: {$mail->ErrorInfo}");
        return false;
    }
}
?>
```

#### How to Get Gmail App Password:
1. Go to Google Account: https://myaccount.google.com/
2. Security → 2-Step Verification (enable it)
3. Security → App Passwords
4. Select "Mail" and "Other (Custom name)"
5. Name it "Through My Pencil"
6. Copy the 16-character password
7. Use this password in your email config

---

### Step 2: Import Database

```bash
# Open phpMyAdmin
# Create database: through_my_pencil
# Import database.sql file
```

The database includes:
- `users` table - stores registered users
- `orders` table - stores customer orders
- `gallery_items` table - artwork catalog
- `custom_orders` table - custom order requests

---

### Step 3: Test Everything

#### Test 1: User Registration → Email Notification
```
1. Open index.html
2. Click "Login" → "Register"
3. Fill form:
   Name: Test User
   Email: test@example.com
   Phone: +94712345678
   Password: test123
4. Submit

Expected:
✅ "Registration successful!" message
✅ Email sent to nipunnirman999@gmail.com
✅ User appears in admin dashboard
```

#### Test 2: Admin Dashboard
```
1. Open admin-dashboard.php
2. Should see:
   ✅ Statistics cards with numbers
   ✅ User list table
   ✅ Search box
   ✅ Export button

3. Try search:
   → Type user name or email
   → Table filters in real-time

4. Try export:
   → Click "Export CSV"
   → Downloads users_YYYY-MM-DD.csv
```

#### Test 3: WhatsApp Checkout
```
1. Login to website
2. Add items to cart
3. Click cart icon
4. Click "Proceed to Checkout"
5. WhatsApp opens with:
   → Your number: +94710545455
   → Order details
   → Customer info
   → Total price
```

---

## 📁 Files Updated/Created

### New Files:
✅ **admin-dashboard.php** - Admin panel for viewing users
✅ **api.php** - Updated with email notifications

### Updated Files:
✅ **script.js** - WhatsApp number updated, registration sends to API

### Configuration:
```
Admin Email: nipunnirman999@gmail.com
WhatsApp: +94710545455
Business: Through My Pencil
```

---

## 📧 Email Templates

### Registration Email (Sent to Admin):
```
Subject: 🎨 New Registration - Through My Pencil

Content:
- User name
- User email
- User phone
- Registration date/time
- Link to admin dashboard
```

### Contact Form Email (Sent to Admin):
```
Subject: 📧 New Contact Form Submission - Through My Pencil

Content:
- Sender name
- Sender email
- Message content
- Submission time
```

---

## 🎨 Admin Dashboard Features

### Statistics Cards:
```
┌─────────────────────┐
│  👥 Total Users     │
│      150            │
│  All registered     │
└─────────────────────┘

┌─────────────────────┐
│  ➕ Today           │
│       5             │
│  New users today    │
└─────────────────────┘

┌─────────────────────┐
│  📅 This Week       │
│      23             │
│  New this week      │
└─────────────────────┘

┌─────────────────────┐
│  📆 This Month      │
│      87             │
│  New this month     │
└─────────────────────┘
```

### User Table:
```
# | Name        | Email              | Phone          | Date
--|-------------|--------------------|-----------------|---------
1 | John Doe    | john@example.com   | +94712345678   | Nov 29
2 | Jane Smith  | jane@example.com   | +94787654321   | Nov 28
3 | Bob Wilson  | bob@example.com    | +94723456789   | Nov 27
```

### Search Feature:
- Type in search box
- Filters by name, email, or phone
- Updates in real-time

### Export Feature:
- Exports all users to CSV
- Includes: Name, Email, Phone, Registration Date
- File named: `users_2025-11-29.csv`

---

## 🔧 API Endpoints

Your website now has these endpoints:

### 1. Register User
```
POST api.php?endpoint=register
Body: {
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "+94712345678",
  "password": "securepass"
}

Response: {
  "success": true,
  "message": "Registration successful"
}

Side Effect: Email sent to nipunnirman999@gmail.com
```

### 2. Login User
```
POST api.php?endpoint=login
Body: {
  "email": "john@example.com",
  "password": "securepass"
}

Response: {
  "success": true,
  "user": {
    "user_id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  }
}
```

### 3. Get All Users (Admin)
```
GET api.php?endpoint=users

Response: {
  "success": true,
  "users": [
    {
      "user_id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "phone": "+94712345678",
      "created_at": "2025-11-29 10:30:00"
    }
  ]
}
```

### 4. Get Statistics (Admin)
```
GET api.php?endpoint=stats

Response: {
  "success": true,
  "stats": {
    "total": 150,
    "today": 5,
    "this_week": 23,
    "this_month": 87
  }
}
```

### 5. Contact Form
```
POST api.php?endpoint=contact
Body: {
  "name": "Customer Name",
  "email": "customer@example.com",
  "message": "Hello, I have a question..."
}

Response: {
  "success": true
}

Side Effect: Email sent to nipunnirman999@gmail.com
```

### 6. Create Order
```
POST api.php?endpoint=order
Body: {
  "user_id": 1,
  "items": [...],
  "total": 299.99
}

Response: {
  "success": true,
  "message": "Order created"
}
```

---

## 🔐 Security Notes

### Passwords:
- ✅ Hashed using PHP's `password_hash()` with bcrypt
- ✅ Never stored in plain text
- ✅ Verified using `password_verify()`

### Database:
- ✅ Prepared statements (PDO) prevent SQL injection
- ✅ Input sanitization
- ✅ Error logging (not displayed to users)

### Email:
- ✅ HTML entities escaped
- ✅ No user input in email headers
- ✅ Safe from injection attacks

---

## 📱 Mobile Responsive

Admin dashboard works on:
- ✅ Desktop (1400px+)
- ✅ Tablet (768px - 1400px)
- ✅ Mobile (< 768px)

Features on mobile:
- Cards stack vertically
- Table scrolls horizontally
- Search box full width
- Touch-friendly buttons

---

## 🎯 What Happens When User Registers

```
User fills registration form
         ↓
JavaScript sends to api.php
         ↓
API validates data
         ↓
Checks if email exists
         ↓
Hashes password
         ↓
Inserts into database
         ↓
Sends email to nipunnirman999@gmail.com
         ↓
Returns success to user
         ↓
User redirected to login
```

---

## 💡 Tips

### For Testing:
1. Use localhost for development
2. Check email spam folder
3. Enable error reporting in PHP
4. Check browser console for errors

### For Production:
1. Use proper SSL certificate
2. Set up proper email server
3. Use environment variables for sensitive data
4. Enable HTTPS
5. Add rate limiting
6. Add CAPTCHA to forms

### For Email Delivery:
1. Use App Password (not regular password)
2. Enable less secure apps (if needed)
3. Check spam folder
4. Verify SMTP settings
5. Test with a simple PHP mail script first

---

## 🚨 Troubleshooting

### Email Not Sending?
```
Check:
1. SMTP settings correct?
2. App password created?
3. Port 587 open?
4. PHP mail() function enabled?
5. Check server error logs
```

### Admin Dashboard Not Loading?
```
Check:
1. Database connection working?
2. api.php file exists?
3. Database tables created?
4. Browser console for errors
5. Network tab for API calls
```

### Users Not Appearing?
```
Check:
1. Registration successful?
2. Database has records?
3. API endpoint returning data?
4. JavaScript console for errors
```

---

## ✅ Final Checklist

Before going live:

- [ ] Database imported
- [ ] Email configured
- [ ] WhatsApp number correct (+94710545455)
- [ ] Admin email correct (nipunnirman999@gmail.com)
- [ ] Tested registration
- [ ] Tested login
- [ ] Tested admin dashboard
- [ ] Tested email sending
- [ ] Tested WhatsApp checkout
- [ ] Tested on mobile
- [ ] SSL certificate installed
- [ ] Backup created

---

## 🎉 You're Ready!

Your website now has:
- ✅ User registration with email notifications
- ✅ Professional admin dashboard
- ✅ Real-time statistics
- ✅ User search and export
- ✅ WhatsApp integration
- ✅ Secure password storage
- ✅ Mobile responsive design

**Access admin dashboard at:** `admin-dashboard.php`
**All emails go to:** nipunnirman999@gmail.com
**WhatsApp:** +94710545455

Need help? Contact me! 🚀