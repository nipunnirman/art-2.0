<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Through My Pencil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --text-dark: #2d3748;
            --bg-light: #f7fafc;
            --gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            color: var(--text-dark);
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .header .subtitle {
            color: #666;
            font-size: 1.1rem;
        }

        .header .contact-info {
            margin-top: 15px;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .contact-info span {
            color: var(--primary-color);
            font-weight: 600;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card .icon {
            width: 60px;
            height: 60px;
            background: var(--gradient);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .stat-card .icon i {
            font-size: 1.8rem;
            color: white;
        }

        .stat-card .number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .stat-card .label {
            color: #666;
            font-size: 1rem;
        }

        .users-table-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .table-header h2 {
            color: var(--text-dark);
            font-size: 1.8rem;
        }

        .search-box {
            display: flex;
            gap: 10px;
        }

        .search-box input {
            padding: 12px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 25px;
            font-size: 1rem;
            width: 300px;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .refresh-btn {
            padding: 12px 25px;
            background: var(--gradient);
            color: white;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .refresh-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .users-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .users-table thead th {
            background: var(--bg-light);
            padding: 15px;
            text-align: left;
            color: var(--text-dark);
            font-weight: 600;
            border-bottom: 2px solid #e0e0e0;
        }

        .users-table tbody tr {
            background: white;
            transition: all 0.3s ease;
        }

        .users-table tbody tr:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .users-table tbody td {
            padding: 20px 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        .users-table tbody tr td:first-child {
            border-radius: 10px 0 0 10px;
        }

        .users-table tbody tr td:last-child {
            border-radius: 0 10px 10px 0;
        }

        .email-link {
            color: var(--primary-color);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .email-link:hover {
            text-decoration: underline;
        }

        .date-badge {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: var(--text-dark);
            font-size: 1.2rem;
        }

        .loading i {
            font-size: 3rem;
            color: var(--primary-color);
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .no-data i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 20px;
        }

        .export-btn {
            padding: 12px 25px;
            background: white;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .export-btn:hover {
            background: var(--primary-color);
            color: white;
        }

        .back-btn {
            display: inline-block;
            padding: 12px 25px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateX(-5px);
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 1.8rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .search-box {
                flex-direction: column;
                width: 100%;
            }

            .search-box input {
                width: 100%;
            }

            .users-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <a href="index.html" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Website
        </a>

        <div class="header">
            <h1>🎨 Admin Dashboard</h1>
            <p class="subtitle">Through My Pencil - User Management</p>
            <div class="contact-info">
                <div><i class="fas fa-envelope"></i> <span>nipunnirman999@gmail.com</span></div>
                <div><i class="fab fa-whatsapp"></i> <span>+94710545455</span></div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="number" id="totalUsers">-</div>
                <div class="label">Total Registered Users</div>
            </div>

            <div class="stat-card">
                <div class="icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="number" id="todayUsers">-</div>
                <div class="label">New Users Today</div>
            </div>

            <div class="stat-card">
                <div class="icon">
                    <i class="fas fa-calendar-week"></i>
                </div>
                <div class="number" id="weekUsers">-</div>
                <div class="label">New Users This Week</div>
            </div>

            <div class="stat-card">
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="number" id="monthUsers">-</div>
                <div class="label">New Users This Month</div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="users-table-container">
            <div class="table-header">
                <h2>Registered Users</h2>
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="🔍 Search by name or email...">
                    <button class="export-btn" onclick="exportToCSV()">
                        <i class="fas fa-download"></i> Export CSV
                    </button>
                    <button class="refresh-btn" onclick="loadData()">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>
            </div>

            <div id="tableContent">
                <div class="loading">
                    <i class="fas fa-spinner"></i>
                    <p>Loading users...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        let allUsers = [];

        // Load statistics
        async function loadStats() {
            try {
                const response = await fetch('api.php?endpoint=stats');
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('totalUsers').textContent = data.stats.total || 0;
                    document.getElementById('todayUsers').textContent = data.stats.today || 0;
                    document.getElementById('weekUsers').textContent = data.stats.this_week || 0;
                    document.getElementById('monthUsers').textContent = data.stats.this_month || 0;
                }
            } catch (error) {
                console.error('Error loading stats:', error);
            }
        }

        // Load users
        async function loadUsers() {
            try {
                const response = await fetch('api.php?endpoint=users');
                const data = await response.json();
                
                if (data.success && data.users) {
                    allUsers = data.users;
                    displayUsers(allUsers);
                } else {
                    displayNoData();
                }
            } catch (error) {
                console.error('Error loading users:', error);
                displayError();
            }
        }

        // Display users in table
        function displayUsers(users) {
            const tableContent = document.getElementById('tableContent');
            
            if (users.length === 0) {
                displayNoData();
                return;
            }

            let html = `
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><i class="fas fa-user"></i> Name</th>
                            <th><i class="fas fa-envelope"></i> Email</th>
                            <th><i class="fas fa-phone"></i> Phone</th>
                            <th><i class="fas fa-calendar"></i> Registration Date</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            users.forEach((user, index) => {
                const date = new Date(user.created_at);
                const formattedDate = date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });
                const formattedTime = date.toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                html += `
                    <tr>
                        <td><strong>${index + 1}</strong></td>
                        <td>${user.name}</td>
                        <td><a href="mailto:${user.email}" class="email-link">${user.email}</a></td>
                        <td>${user.phone || 'N/A'}</td>
                        <td>
                            <span class="date-badge">${formattedDate}</span>
                            <br><small style="color: #666;">${formattedTime}</small>
                        </td>
                    </tr>
                `;
            });

            html += `
                    </tbody>
                </table>
            `;

            tableContent.innerHTML = html;
        }

        // Display no data message
        function displayNoData() {
            document.getElementById('tableContent').innerHTML = `
                <div class="no-data">
                    <i class="fas fa-users-slash"></i>
                    <h3>No Users Yet</h3>
                    <p>When users register on your website, they will appear here.</p>
                </div>
            `;
        }

        // Display error message
        function displayError() {
            document.getElementById('tableContent').innerHTML = `
                <div class="no-data">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h3>Error Loading Data</h3>
                    <p>There was an error connecting to the database.</p>
                    <button class="refresh-btn" onclick="loadData()" style="margin-top: 20px;">
                        <i class="fas fa-retry"></i> Try Again
                    </button>
                </div>
            `;
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const filteredUsers = allUsers.filter(user => 
                user.name.toLowerCase().includes(searchTerm) ||
                user.email.toLowerCase().includes(searchTerm) ||
                (user.phone && user.phone.includes(searchTerm))
            );
            displayUsers(filteredUsers);
        });

        // Export to CSV
        function exportToCSV() {
            if (allUsers.length === 0) {
                alert('No data to export');
                return;
            }

            let csv = 'Name,Email,Phone,Registration Date\n';
            allUsers.forEach(user => {
                const date = new Date(user.created_at).toLocaleString();
                csv += `"${user.name}","${user.email}","${user.phone || 'N/A'}","${date}"\n`;
            });

            const blob = new Blob([csv], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `users_${new Date().toISOString().split('T')[0]}.csv`;
            a.click();
        }

        // Load all data
        function loadData() {
            loadStats();
            loadUsers();
        }

        // Initial load
        loadData();

        // Auto-refresh every 30 seconds
        setInterval(loadData, 30000);
    </script>
</body>
</html>