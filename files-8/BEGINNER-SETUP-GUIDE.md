# 🚀 Complete Beginner's Setup Guide - Step by Step

## 📋 Overview

You'll learn:
1. ✅ How to set up database (SUPER EASY!)
2. ✅ How to run website locally
3. ✅ How to access admin dashboard
4. ✅ How to host on GitHub Pages (FREE!)

**Time needed:** 30 minutes max!

---

## PART 1: Setup Database (10 minutes)

### Step 1: Download XAMPP (Free Software)

1. **Go to:** https://www.apachefriends.org/
2. **Download XAMPP** for your operating system
3. **Install XAMPP** (just keep clicking "Next")
4. **Installation folder:** Usually `C:\xampp` (Windows) or `/Applications/XAMPP` (Mac)

### Step 2: Start XAMPP

1. **Open XAMPP Control Panel**
   - Windows: Search "XAMPP Control Panel" in Start Menu
   - Mac: Open XAMPP application

2. **Start these 2 services:**
   ```
   Click "Start" next to:
   ✅ Apache
   ✅ MySQL
   
   Both should turn GREEN
   ```

3. **If ports are busy (error):**
   ```
   Apache uses port 80
   MySQL uses port 3306
   
   If error: Change Apache port to 8080
   - Click "Config" → "httpd.conf"
   - Change "Listen 80" to "Listen 8080"
   - Save and restart
   ```

### Step 3: Create Database (EASIEST WAY!)

1. **Open phpMyAdmin:**
   ```
   Open browser
   Go to: http://localhost/phpmyadmin
   
   (If you changed port: http://localhost:8080/phpmyadmin)
   ```

2. **Create Database:**
   ```
   ┌─────────────────────────────────────┐
   │ phpMyAdmin Dashboard                │
   ├─────────────────────────────────────┤
   │ Click "New" (left sidebar)          │
   │                                      │
   │ Database name: through_my_pencil    │
   │                                      │
   │ Click "Create"                       │
   └─────────────────────────────────────┘
   ```

3. **Import Database File:**
   ```
   Click on "through_my_pencil" database (left side)
   
   ┌─────────────────────────────────────┐
   │ Click "Import" tab (top menu)       │
   │                                      │
   │ Click "Choose File"                  │
   │                                      │
   │ Select: database.sql                 │
   │ (from your downloads)                │
   │                                      │
   │ Scroll down → Click "Go"             │
   └─────────────────────────────────────┘
   
   ✅ Success message appears!
   ✅ You'll see tables: users, orders, gallery_items, etc.
   ```

**DONE! Database is ready! 🎉**

---

## PART 2: Run Website Locally (5 minutes)

### Step 1: Copy Files to XAMPP

1. **Find XAMPP folder:**
   ```
   Windows: C:\xampp\htdocs
   Mac: /Applications/XAMPP/htdocs
   ```

2. **Create project folder:**
   ```
   Inside htdocs, create new folder: "through-my-pencil"
   
   Path should be:
   C:\xampp\htdocs\through-my-pencil
   ```

3. **Copy ALL your website files here:**
   ```
   Copy these files to through-my-pencil folder:
   
   through-my-pencil/
   ├── index.html
   ├── gallery.html
   ├── gift-items.html
   ├── giftbox.html
   ├── custom-order.html
   ├── price-calculator.html
   ├── admin-dashboard.php
   ├── api.php
   ├── script.js
   ├── styles.css
   └── database.sql
   ```

### Step 2: Open Website

1. **Open browser**
2. **Go to:** `http://localhost/through-my-pencil/index.html`
3. **Your website opens!** 🎉

**Common URLs:**
```
Homepage:        http://localhost/through-my-pencil/index.html
Gallery:         http://localhost/through-my-pencil/gallery.html
Gift Items:      http://localhost/through-my-pencil/gift-items.html
Admin Dashboard: http://localhost/through-my-pencil/admin-dashboard.php
```

---

## PART 3: Access Admin Dashboard (2 minutes)

### Easy Way:

1. **Open browser**
2. **Type:** `http://localhost/through-my-pencil/admin-dashboard.php`
3. **Press Enter**
4. **Admin Dashboard opens!** 🎉

### What You'll See:

```
┌──────────────────────────────────────────────┐
│  🎨 Admin Dashboard                          │
│  Through My Pencil - User Management         │
├──────────────────────────────────────────────┤
│                                               │
│  📊 Statistics:                              │
│  ┌────────┐ ┌────────┐ ┌────────┐ ┌────────┐│
│  │ Total  │ │ Today  │ │ Week   │ │ Month  ││
│  │   0    │ │   0    │ │   0    │ │   0    ││
│  └────────┘ └────────┘ └────────┘ └────────┘│
│                                               │
│  👥 Registered Users:                        │
│  (No users yet)                               │
│                                               │
└──────────────────────────────────────────────┘
```

### Test It!

1. **Register a test user:**
   ```
   Go to: http://localhost/through-my-pencil/index.html
   Click "Login" → "Register"
   Fill form:
     Name: Test User
     Email: test@test.com
     Phone: +94712345678
     Password: test123
   Submit
   ```

2. **Refresh admin dashboard**
3. **See the user appear!** ✅

---

## PART 4: Host on GitHub (FREE!) (10 minutes)

### Important Note:
**GitHub Pages is FREE but has limitations:**
- ✅ Can host HTML, CSS, JavaScript
- ❌ Cannot run PHP (admin dashboard, database)
- ❌ Cannot send emails

**Solutions:**
1. **Frontend only on GitHub** (for showcase)
2. **Backend on free hosting** (for full functionality)

### Option A: GitHub Pages (Frontend Only)

#### Step 1: Create GitHub Account
```
1. Go to: https://github.com
2. Click "Sign up"
3. Create account (free)
```

#### Step 2: Create Repository

1. **Click "+" → "New repository"**
2. **Fill details:**
   ```
   Repository name: through-my-pencil
   Description: My Art Business Website
   ✅ Public
   ✅ Add README
   Click "Create repository"
   ```

#### Step 3: Upload Files

**Easy Way (GitHub Website):**
```
1. Click "Add file" → "Upload files"
2. Drag and drop these files:
   - index.html
   - gallery.html
   - gift-items.html
   - giftbox.html
   - custom-order.html
   - price-calculator.html
   - styles.css
   - script.js
   
   ⚠️ DON'T upload:
   - api.php (won't work on GitHub)
   - admin-dashboard.php (won't work on GitHub)
   - database.sql (won't work on GitHub)
   
3. Click "Commit changes"
```

**Advanced Way (Git Commands):**
```bash
# Open terminal/command prompt
cd path/to/your/files

# Initialize Git
git init

# Add files
git add index.html gallery.html gift-items.html giftbox.html
git add custom-order.html price-calculator.html
git add styles.css script.js

# Commit
git commit -m "Initial commit"

# Connect to GitHub
git remote add origin https://github.com/YOUR-USERNAME/through-my-pencil.git

# Push
git branch -M main
git push -u origin main
```

#### Step 4: Enable GitHub Pages

```
1. In your repository, click "Settings"
2. Scroll to "Pages" (left sidebar)
3. Under "Source":
   - Branch: main
   - Folder: / (root)
4. Click "Save"
5. Wait 2 minutes
6. Your site is live at:
   https://YOUR-USERNAME.github.io/through-my-pencil/
```

**What Works on GitHub Pages:**
- ✅ All pages load
- ✅ Design looks great
- ✅ Cart works (local storage)
- ❌ Registration doesn't save
- ❌ Admin dashboard doesn't work
- ❌ Emails don't send

---

### Option B: Free Hosting with PHP (RECOMMENDED!)

**For FULL functionality (database, emails, admin):**

#### Best Free Options:

**1. InfinityFree (Recommended)**
```
Website: infinityfree.net

Features:
✅ Free forever
✅ PHP + MySQL
✅ No ads
✅ Unlimited bandwidth

Steps:
1. Sign up at infinityfree.net
2. Create account
3. Create website
4. Upload files via File Manager or FTP
5. Create MySQL database
6. Import database.sql
7. Update api.php with database details
```

**2. 000webhost**
```
Website: 000webhost.com

Features:
✅ Free
✅ PHP + MySQL
✅ 300MB storage

Steps:
1. Sign up
2. Create website
3. Upload files
4. Create database
5. Import SQL
```

**3. Awardspace**
```
Website: awardspace.com

Features:
✅ Free
✅ PHP + MySQL
✅ 1GB storage
```

#### Detailed Setup (InfinityFree):

**Step 1: Sign Up**
```
1. Go to: infinityfree.net
2. Click "Sign Up Now"
3. Enter email
4. Verify email
5. Create password
```

**Step 2: Create Website**
```
1. Click "Create Account"
2. Choose subdomain:
   yourname.infinityfreeapp.com
   (or use your own domain)
3. Click "Create Account"
4. Wait 2 minutes for activation
```

**Step 3: Upload Files**
```
1. Go to Control Panel
2. Click "File Manager"
3. Open "htdocs" folder
4. Upload all files:
   - index.html
   - gallery.html
   - gift-items.html
   - giftbox.html
   - custom-order.html
   - price-calculator.html
   - admin-dashboard.php
   - api.php
   - script.js
   - styles.css
```

**Step 4: Create Database**
```
1. In Control Panel
2. Click "MySQL Databases"
3. Click "Create Database"
4. Remember:
   - Database name
   - Database username
   - Database password
```

**Step 5: Import Database**
```
1. Click "phpMyAdmin"
2. Select your database
3. Click "Import"
4. Choose database.sql
5. Click "Go"
```

**Step 6: Update Database Connection**
```
Edit api.php:

Find these lines:
private $host = 'localhost';
private $db_name = 'through_my_pencil';
private $username = 'root';
private $password = '';

Change to:
private $host = 'localhost';
private $db_name = 'YOUR_DATABASE_NAME';
private $username = 'YOUR_DATABASE_USERNAME';
private $password = 'YOUR_DATABASE_PASSWORD';
```

**Step 7: Test**
```
Visit: yourname.infinityfreeapp.com
✅ Website loads
✅ Register works
✅ Admin dashboard works
✅ Everything functional!
```

---

## PART 5: Email Configuration (5 minutes)

### Option 1: Use Gmail (Free)

**Step 1: Get App Password**
```
1. Go to: myaccount.google.com
2. Security → 2-Step Verification (enable it)
3. Security → App Passwords
4. Select "Mail" and "Other"
5. Name: "Through My Pencil"
6. Copy 16-character password
```

**Step 2: Update api.php**
```php
Find this section in api.php:

class EmailHelper {
    public static function sendToAdmin($subject, $message) {
        // Current basic email
    }
}

Replace with PHPMailer (better):
Install PHPMailer:
https://github.com/PHPMailer/PHPMailer

Or use Gmail SMTP in your hosting control panel
```

### Option 2: Use Hosting Email (Easiest)

```
Most free hosts provide email function
InfinityFree/000webhost have built-in mail()
Just works automatically!

No extra setup needed.
```

---

## 📋 QUICK REFERENCE CARD

### Local Development:

```
✅ Website:   http://localhost/through-my-pencil/
✅ Admin:     http://localhost/through-my-pencil/admin-dashboard.php
✅ Database:  http://localhost/phpmyadmin
```

### File Locations:

```
Website Files:   C:\xampp\htdocs\through-my-pencil\
Database:        phpMyAdmin → through_my_pencil
Logs:            C:\xampp\apache\logs\
```

### Important Info:

```
Your Email:      nipunnirman999@gmail.com
Your WhatsApp:   +94710545455
Database Name:   through_my_pencil
```

---

## 🐛 TROUBLESHOOTING

### Problem: Can't access localhost
```
Solution:
1. Check XAMPP - Apache is running (green)
2. Try: http://localhost:8080/through-my-pencil/
3. Check firewall - allow Apache
```

### Problem: Database connection error
```
Solution:
1. Check XAMPP - MySQL is running (green)
2. Check database name in api.php
3. Verify database exists in phpMyAdmin
```

### Problem: Admin dashboard blank
```
Solution:
1. Check browser console (F12)
2. Verify api.php exists
3. Check database connection
4. Look for errors in C:\xampp\apache\logs\error.log
```

### Problem: GitHub Pages not updating
```
Solution:
1. Wait 2-5 minutes
2. Clear browser cache (Ctrl + F5)
3. Check Settings → Pages for URL
```

### Problem: Email not sending
```
Solution:
1. Check spam folder
2. Verify Gmail App Password
3. Check hosting email limits
4. Test with simple PHP mail() first
```

---

## ✅ FINAL CHECKLIST

**Local Setup:**
- [ ] XAMPP installed
- [ ] Apache running (green)
- [ ] MySQL running (green)
- [ ] Database created (through_my_pencil)
- [ ] Tables imported (users, orders, etc.)
- [ ] Files in htdocs folder
- [ ] Website opens at localhost
- [ ] Admin dashboard opens
- [ ] Test registration works

**Online Hosting (Optional):**
- [ ] Free hosting account created
- [ ] Files uploaded
- [ ] Database created
- [ ] Database imported
- [ ] api.php updated with credentials
- [ ] Website accessible online
- [ ] Admin dashboard works
- [ ] Email configured

---

## 🎉 YOU'RE DONE!

Your website is now:
- ✅ Running locally
- ✅ Database connected
- ✅ Admin dashboard accessible
- ✅ Ready for GitHub (frontend)
- ✅ Ready for free hosting (full site)

**Need help?** Just ask! 🚀

---

## 📞 NEXT STEPS

1. **Test everything locally**
2. **Add your real artwork images**
3. **Customize text and prices**
4. **Choose hosting option**
5. **Go live!**

**Your art business website is ready!** 🎨✨