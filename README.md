# Through My Pencil - Art Business Website

A beautiful, Apple-inspired glass morphism website for selling pencil art portraits with e-commerce functionality.

## 🎨 Features

### Frontend Features
- **Stunning UI/UX**: Apple-inspired glass morphism design
- **Fully Responsive**: Works perfectly on mobile, tablet, and desktop
- **Multi-Page Website**:
  - Home page with hero section, featured artwork, about section, reviews, and contact
  - Gallery page with 15+ artworks
  - Custom Order page with step-by-step process
  - Gift Box page with 8+ curated gift options
  - Price Calculator for instant pricing

### E-Commerce Features
- **Shopping Cart**: Add to cart functionality
- **Login/Register System**: User authentication
- **Price Calculator**: Interactive pricing tool
- **WhatsApp Integration**: Direct contact via WhatsApp
- **Social Media Links**: Connect on all platforms

### Technical Features
- **No Login Required for Browsing**: Users can explore without registration
- **Floating Chat Button**: Ready for RAG chatbot integration
- **Glass Morphism Effects**: Modern, elegant design
- **Smooth Animations**: Professional transitions and effects
- **Mobile Navigation**: Hamburger menu for small screens

## 📁 Project Structure

```
through-my-pencil/
├── index.html              # Home page
├── gallery.html            # Gallery with 15 artworks
├── custom-order.html       # Custom order page
├── giftbox.html           # Gift box options
├── price-calculator.html  # Interactive price calculator
├── styles.css             # Main stylesheet
├── script.js              # JavaScript functionality
├── database.sql           # MySQL database schema
├── api.php               # PHP backend API
└── README.md             # This file
```

## 🚀 Installation & Setup

### Prerequisites
- Web server (Apache/Nginx)
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Modern web browser

### Step 1: Database Setup

1. Create a MySQL database:
```sql
CREATE DATABASE through_my_pencil;
```

2. Import the database schema:
```bash
mysql -u your_username -p through_my_pencil < database.sql
```

3. Update database credentials in `api.php`:
```php
private $host = 'localhost';
private $db_name = 'through_my_pencil';
private $username = 'your_username';  // Update this
private $password = 'your_password';   // Update this
```

### Step 2: Configure WhatsApp

Update WhatsApp phone number in all HTML files:
- Replace `1234567890` with your actual WhatsApp number
- Format: Country code + number (e.g., 14155551234)

Search for: `wa.me/1234567890` and replace with your number

### Step 3: Deploy Files

1. Upload all files to your web server
2. Ensure proper permissions:
```bash
chmod 755 *.html
chmod 644 *.css *.js
chmod 755 api.php
```

3. Configure your web server to serve the files

### Step 4: Test the Website

1. Open your browser and navigate to your website URL
2. Test all pages:
   - Home page
   - Gallery (add items to cart)
   - Custom Order page
   - Gift Box page
   - Price Calculator

## 🔧 Configuration

### Email Configuration
Update email address in footer and contact sections:
- Current: `info@throughmypencil.com`
- Replace with your actual email

### Social Media Links
Update social media URLs in `index.html` footer:
```html
<a href="YOUR_FACEBOOK_URL" target="_blank">
<a href="YOUR_INSTAGRAM_URL" target="_blank">
<a href="YOUR_TWITTER_URL" target="_blank">
<a href="YOUR_PINTEREST_URL" target="_blank">
<a href="YOUR_TIKTOK_URL" target="_blank">
```

### Images
Replace placeholder images with your actual artwork:
- Hero background images
- Gallery artwork images
- Gift box images
- About section images

Current images use Unsplash placeholders - replace with your own.

## 💾 Database Schema

### Main Tables:
- **users**: Customer accounts
- **products**: Gallery items
- **gift_boxes**: Gift box options
- **custom_orders**: Custom portrait orders
- **cart**: Shopping carts
- **cart_items**: Items in cart
- **orders**: Completed orders
- **order_items**: Order details
- **reviews**: Customer reviews
- **contact_messages**: Contact form submissions

## 🔌 API Endpoints

### Authentication
- `POST /api.php?endpoint=register` - Register new user
- `POST /api.php?endpoint=login` - User login
- `GET /api.php?endpoint=get-user&user_id=ID` - Get user details

### Cart Management
- `POST /api.php?endpoint=add-to-cart` - Add item to cart
- `GET /api.php?endpoint=get-cart` - Get cart items
- `DELETE /api.php?endpoint=remove-from-cart` - Remove item

### Products
- `GET /api.php?endpoint=get-products` - Get all products
- `GET /api.php?endpoint=get-product&product_id=ID` - Get single product

### Orders
- `POST /api.php?endpoint=create-order` - Create new order
- `GET /api.php?endpoint=get-orders&user_id=ID` - Get user orders

### Contact
- `POST /api.php?endpoint=contact` - Submit contact message

## 🎯 Frontend Integration with Backend

### Example: Login
```javascript
async function login(email, password) {
    const response = await fetch('/api.php?endpoint=login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password })
    });
    const data = await response.json();
    if (data.success) {
        // Store user session
        localStorage.setItem('user', JSON.stringify(data.user));
    }
}
```

### Example: Add to Cart
```javascript
async function addToCart(productId, price) {
    const response = await fetch('/api.php?endpoint=add-to-cart', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1,
            price: price,
            session_id: getSessionId()
        })
    });
    const data = await response.json();
    return data;
}
```

## 🤖 Future RAG Chatbot Integration

The chat button is already implemented. To integrate your RAG chatbot:

1. Create chatbot interface
2. Update chat button click handler in `script.js`:
```javascript
chatButton.addEventListener('click', () => {
    // Open your chatbot modal/iframe
    openChatbot();
});
```

## 📱 Responsive Breakpoints

- **Desktop**: > 768px
- **Tablet**: 481px - 768px
- **Mobile**: < 480px

## 🎨 Color Scheme

```css
--primary-color: #007AFF (Blue)
--secondary-color: #5856D6 (Purple)
--text-dark: #1d1d1f
--text-light: #6e6e73
--bg-light: #f5f5f7
--gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%)
```

## 🔐 Security Recommendations

1. **Password Hashing**: Already implemented with bcrypt
2. **SQL Injection Prevention**: Using prepared statements
3. **XSS Protection**: Sanitize user inputs
4. **HTTPS**: Use SSL certificate in production
5. **Environment Variables**: Store database credentials in .env file

## 📊 Performance Optimization

1. **Image Optimization**: Compress all images
2. **CSS Minification**: Minify styles.css for production
3. **JavaScript Minification**: Minify script.js
4. **Lazy Loading**: Implement for images
5. **CDN**: Use CDN for Font Awesome and fonts

## 🌐 Browser Support

- Chrome/Edge (latest 2 versions)
- Firefox (latest 2 versions)
- Safari (latest 2 versions)
- Mobile browsers (iOS Safari, Chrome Mobile)

## 📞 Support

For support, email: support@throughmypencil.com

## 📝 License

This project is proprietary. All rights reserved.

## 🙏 Credits

- Design inspiration: Apple.com
- Icons: Font Awesome
- Fonts: Google Fonts (Inter)
- Images: Unsplash (replace with your own)

---

**Built with ❤️ for "Through My Pencil"**

## Quick Start Checklist

- [ ] Import database.sql
- [ ] Update database credentials in api.php
- [ ] Update WhatsApp number in all HTML files
- [ ] Update email addresses
- [ ] Add social media links
- [ ] Replace placeholder images
- [ ] Test login/register
- [ ] Test add to cart
- [ ] Test price calculator
- [ ] Configure web server
- [ ] Set up SSL certificate
- [ ] Test on mobile devices

## Customization Tips

### Change Brand Name
Search and replace "Through My Pencil" with your brand name in all files.

### Modify Pricing
Update pricing in:
- `price-calculator.html` (JavaScript pricing object)
- `database.sql` (product prices)
- `gallery.html` (gallery items)
- `giftbox.html` (gift box prices)

### Add More Products
1. Add to database using INSERT statements
2. Update gallery.html JavaScript array
3. Add product images to server

### Style Customization
Edit CSS variables in `styles.css`:
```css
:root {
    --primary-color: #YOUR_COLOR;
    --gradient: linear-gradient(...);
}
```

## Deployment

### Apache .htaccess (Optional)
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^api/(.*)$ api.php?endpoint=$1 [QSA,L]
```

This allows cleaner URLs like `/api/login` instead of `/api.php?endpoint=login`

## Maintenance

### Regular Tasks
- Backup database weekly
- Monitor server logs
- Update product images
- Review and respond to contact messages
- Update featured artwork
- Check and respond to reviews

### Database Maintenance
```sql
-- Regular cleanup
DELETE FROM cart WHERE updated_at < DATE_SUB(NOW(), INTERVAL 30 DAY);
DELETE FROM contact_messages WHERE is_read = TRUE AND created_at < DATE_SUB(NOW(), INTERVAL 90 DAY);
```

Good luck with your art business! 🎨✨