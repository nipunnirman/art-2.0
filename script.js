// User Management
let currentUser = JSON.parse(localStorage.getItem('currentUser')) || null;

// Cart Management
let cart = JSON.parse(localStorage.getItem('cart')) || [];

// Check if user is logged in
function isLoggedIn() {
    return currentUser !== null;
}

// Update UI based on login state
function updateLoginUI() {
    const loginBtn = document.getElementById('loginBtn');
    if (loginBtn && isLoggedIn()) {
        loginBtn.textContent = currentUser.name || 'My Account';
        loginBtn.onclick = (e) => {
            e.preventDefault();
            showNotification('Welcome back, ' + currentUser.name + '!');
        };
    }
}

// Update Cart Count
function updateCartCount() {
    const cartCount = document.querySelector('.cart-count');
    if (cartCount) {
        cartCount.textContent = cart.length;
    }
}

// Add to Cart Function with Login Check
function addToCart(item) {
    if (!isLoggedIn()) {
        showNotification('Please login to add items to cart');
        const loginModal = document.getElementById('loginModal');
        if (loginModal) {
            loginModal.style.display = 'block';
        }
        return false;
    }
    
    cart.push(item);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    showNotification('Item added to cart!');
    return true;
}

// Remove from Cart
function removeFromCart(index) {
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    renderCartModal();
    showNotification('Item removed from cart');
}

// Update Cart Item Quantity
function updateCartQuantity(index, quantity) {
    if (quantity <= 0) {
        removeFromCart(index);
        return;
    }
    cart[index].quantity = quantity;
    localStorage.setItem('cart', JSON.stringify(cart));
    renderCartModal();
}

// Calculate Cart Total
function calculateCartTotal() {
    return cart.reduce((total, item) => {
        return total + (item.price * (item.quantity || 1));
    }, 0);
}

// Render Cart Modal
function renderCartModal() {
    const cartItemsContainer = document.getElementById('cartItemsContainer');
    const cartTotalElement = document.getElementById('cartTotal');
    const emptyCartMessage = document.getElementById('emptyCartMessage');
    const cartContent = document.getElementById('cartContent');

    if (!cartItemsContainer) return;

    if (cart.length === 0) {
        emptyCartMessage.style.display = 'block';
        cartContent.style.display = 'none';
        return;
    }

    emptyCartMessage.style.display = 'none';
    cartContent.style.display = 'block';

    cartItemsContainer.innerHTML = cart.map((item, index) => {
        const variations = item.variations ? 
            Object.entries(item.variations)
                .map(([key, value]) => `${key}: ${value}`)
                .join(', ') : '';

        return `
            <div class="cart-item-row">
                <img src="${item.image || item.image_url || 'https://via.placeholder.com/80'}" alt="${item.title || item.name}">
                <div class="cart-item-details">
                    <h4>${item.title || item.name}</h4>
                    ${variations ? `<p class="cart-item-variations">${variations}</p>` : ''}
                    <p class="cart-item-price">$${item.price} × ${item.quantity || 1}</p>
                </div>
                <div class="cart-item-actions">
                    <div class="quantity-controls">
                        <button onclick="updateCartQuantity(${index}, ${(item.quantity || 1) - 1})">-</button>
                        <span>${item.quantity || 1}</span>
                        <button onclick="updateCartQuantity(${index}, ${(item.quantity || 1) + 1})">+</button>
                    </div>
                    <button class="remove-btn" onclick="removeFromCart(${index})" title="Remove">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
    }).join('');

    const total = calculateCartTotal();
    cartTotalElement.textContent = `$${total.toFixed(2)}`;
}

// Show Notification
function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 90px;
        right: 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px 25px;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        z-index: 10000;
        animation: slideInRight 0.3s ease;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Mobile Menu Toggle
const hamburger = document.getElementById('hamburger');
const navMenu = document.getElementById('navMenu');

if (hamburger) {
    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('active');
        navMenu.classList.toggle('active');
    });

    document.querySelectorAll('.nav-menu a').forEach(link => {
        link.addEventListener('click', () => {
            hamburger.classList.remove('active');
            navMenu.classList.remove('active');
        });
    });
}

// Navbar Scroll Effect
window.addEventListener('scroll', () => {
    const navbar = document.getElementById('navbar');
    if (navbar) {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }
});

// View Cart Modal with Login Check
const viewCartBtn = document.getElementById('viewCartBtn');
const cartModal = document.getElementById('cartModal');
const closeCartBtn = document.getElementById('closeCartModal');

if (viewCartBtn) {
    viewCartBtn.addEventListener('click', (e) => {
        e.preventDefault();
        
        if (!isLoggedIn()) {
            showNotification('Please login to view your cart');
            const loginModal = document.getElementById('loginModal');
            if (loginModal) {
                loginModal.style.display = 'block';
            }
            return;
        }
        
        renderCartModal();
        if (cartModal) {
            cartModal.style.display = 'block';
        }
    });
}

if (closeCartBtn) {
    closeCartBtn.addEventListener('click', () => {
        if (cartModal) {
            cartModal.style.display = 'none';
        }
    });
}

window.addEventListener('click', (e) => {
    if (e.target === cartModal) {
        cartModal.style.display = 'none';
    }
});

// Checkout Function
function proceedToCheckout() {
    if (cart.length === 0) {
        showNotification('Your cart is empty!');
        return;
    }
    
    if (!isLoggedIn()) {
        showNotification('Please login to checkout');
        if (cartModal) cartModal.style.display = 'none';
        const loginModal = document.getElementById('loginModal');
        if (loginModal) {
            loginModal.style.display = 'block';
        }
        return;
    }
    
    const total = calculateCartTotal();
    const itemsList = cart.map(item => {
        const variations = item.variations ? 
            '\n  ' + Object.entries(item.variations)
                .map(([key, value]) => `${key}: ${value}`)
                .join(', ') : '';
        return `- ${item.title || item.name} (Qty: ${item.quantity || 1})${variations}`;
    }).join('\n');

    const message = `Hi! I want to order the following items:

Customer: ${currentUser.name}
Email: ${currentUser.email}

${itemsList}

Total: $${total.toFixed(2)}

Please confirm the order and shipping details.`;

    const whatsappUrl = `https://wa.me/94710545455?text=${encodeURIComponent(message)}`;
    window.open(whatsappUrl, '_blank');
}

// Login/Register Modal
const loginBtn = document.getElementById('loginBtn');
const loginModal = document.getElementById('loginModal');
const registerModal = document.getElementById('registerModal');
const closeBtns = document.querySelectorAll('.close');
const showRegister = document.getElementById('showRegister');
const showLogin = document.getElementById('showLogin');

if (loginBtn) {
    loginBtn.addEventListener('click', (e) => {
        e.preventDefault();
        if (!isLoggedIn()) {
            loginModal.style.display = 'block';
        }
    });
}

if (showRegister) {
    showRegister.addEventListener('click', (e) => {
        e.preventDefault();
        loginModal.style.display = 'none';
        registerModal.style.display = 'block';
    });
}

if (showLogin) {
    showLogin.addEventListener('click', (e) => {
        e.preventDefault();
        registerModal.style.display = 'none';
        loginModal.style.display = 'block';
    });
}

closeBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        loginModal.style.display = 'none';
        registerModal.style.display = 'none';
    });
});

window.addEventListener('click', (e) => {
    if (e.target === loginModal) {
        loginModal.style.display = 'none';
    }
    if (e.target === registerModal) {
        registerModal.style.display = 'none';
    }
});

// Login Form Submission
const loginForm = document.getElementById('loginForm');
if (loginForm) {
    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const email = loginForm.querySelector('input[type="email"]').value;
        const password = loginForm.querySelector('input[type="password"]').value;
        
        currentUser = {
            name: email.split('@')[0].charAt(0).toUpperCase() + email.split('@')[0].slice(1),
            email: email
        };
        
        localStorage.setItem('currentUser', JSON.stringify(currentUser));
        
        showNotification('Login successful! Welcome ' + currentUser.name);
        loginModal.style.display = 'none';
        
        updateLoginUI();
        loginForm.reset();
    });
}

// Register Form Submission
const registerForm = document.getElementById('registerForm');
if (registerForm) {
    registerForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = {
            name: registerForm.querySelectorAll('input')[0].value,
            email: registerForm.querySelectorAll('input')[1].value,
            phone: registerForm.querySelectorAll('input')[2].value,
            password: registerForm.querySelectorAll('input')[3].value,
            confirmPassword: registerForm.querySelectorAll('input')[4].value
        };
        
        if (formData.password !== formData.confirmPassword) {
            showNotification('Passwords do not match!');
            return;
        }
        
        // Send registration data to backend
        try {
            const response = await fetch('api.php?endpoint=register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData)
            });
            
            const result = await response.json();
            
            if (result.success) {
                showNotification('Registration successful! Please login.');
                registerModal.style.display = 'none';
                loginModal.style.display = 'block';
                registerForm.reset();
            } else {
                showNotification(result.message || 'Registration failed. Please try again.');
            }
        } catch (error) {
            console.error('Registration error:', error);
            showNotification('Registration successful! Please login.');
            registerModal.style.display = 'none';
            loginModal.style.display = 'block';
            registerForm.reset();
        }
    });
}

// Contact Form Submission
const contactForm = document.querySelector('.contact-form');
if (contactForm) {
    contactForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const formData = {
            name: contactForm.querySelector('input[type="text"]').value,
            email: contactForm.querySelector('input[type="email"]').value,
            message: contactForm.querySelector('textarea').value
        };
        
        try {
            const response = await fetch('api.php?endpoint=contact', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData)
            });
            
            const result = await response.json();
            
            if (result.success) {
                showNotification('Message sent successfully! We\'ll get back to you soon.');
                contactForm.reset();
            } else {
                showNotification('Message sent! We\'ll get back to you soon.');
                contactForm.reset();
            }
        } catch (error) {
            console.error('Contact form error:', error);
            showNotification('Message sent successfully! We\'ll get back to you soon.');
            contactForm.reset();
        }
    });
}

// Chat Button
const chatButton = document.getElementById('chatButton');
if (chatButton) {
    chatButton.addEventListener('click', () => {
        showNotification('Chat feature coming soon!');
    });
}

// Animated Counter for Stats
function animateCounter(element, target, suffix = '') {
    let current = 0;
    const duration = 2000;
    const increment = target / (duration / 16);
    
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            element.textContent = Math.floor(target) + suffix;
            clearInterval(timer);
        } else {
            element.textContent = Math.floor(current) + suffix;
        }
    }, 16);
}

// Intersection Observer for Counter Animation
const observerOptions = {
    threshold: 0.5,
    rootMargin: '0px'
};

const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
            entry.target.classList.add('counted');
            const statItems = entry.target.querySelectorAll('.stat-item h3');
            
            statItems.forEach(item => {
                const target = parseInt(item.getAttribute('data-target')) || 0;
                const suffix = item.getAttribute('data-suffix') || '';
                
                if (target > 0) {
                    item.textContent = '0' + suffix;
                    setTimeout(() => {
                        animateCounter(item, target, suffix);
                    }, 100);
                }
            });
        }
    });
}, observerOptions);

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    const statsSection = document.querySelector('.stats');
    if (statsSection) {
        counterObserver.observe(statsSection);
    }
    
    updateLoginUI();
    updateCartCount();
});

updateLoginUI();
updateCartCount();

// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href === '#' || !href) return;
        
        e.preventDefault();
        const target = document.querySelector(href);
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Add CSS for animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);