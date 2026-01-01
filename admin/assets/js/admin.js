// Admin Dashboard JavaScript

// Global variables
let currentSection = 'dashboard';
let subscribersData = [];
let notificationsDropdown = null;

// Initialize dashboard
document.addEventListener('DOMContentLoaded', function() {
    initializeDashboard();
    loadSubscribers();
    initializeCharts();
    updateDateTime();
    setInterval(updateDateTime, 1000);
    
    // Initialize notifications
    initializeNotifications();
    
    // Initialize date filter
    const dateFilter = document.getElementById('dateFilter');
    if (dateFilter) {
        dateFilter.addEventListener('change', function() {
            updateCharts();
        });
    }
});

// Initialize notifications
function initializeNotifications() {
    notificationsDropdown = document.getElementById('notificationsDropdown');
    
    // Only add event listeners if notifications dropdown exists
    if (notificationsDropdown) {
        // Close notifications when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.notification-btn') && !e.target.closest('.notifications-dropdown')) {
                closeNotifications();
            }
        });
    }
}

// Toggle notifications dropdown
function toggleNotifications() {
    if (!notificationsDropdown) return;
    
    if (notificationsDropdown.classList.contains('show')) {
        closeNotifications();
    } else {
        openNotifications();
    }
}

// Open notifications dropdown
function openNotifications() {
    if (!notificationsDropdown) return;
    
    notificationsDropdown.classList.add('show');
}

// Close notifications dropdown
function closeNotifications() {
    if (!notificationsDropdown) return;
    
    notificationsDropdown.classList.remove('show');
}

// Mark notification as read
function markNotificationAsRead(notificationId) {
    fetch('api/admin_api.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=mark_notification_read&notification_id=${notificationId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update UI
            const notificationItem = document.querySelector(`[data-id="${notificationId}"]`);
            if (notificationItem) {
                notificationItem.classList.remove('unread');
                notificationItem.classList.add('read');
            }
            
            // Update badge count
            updateNotificationBadge();
        }
    })
    .catch(error => console.error('Error marking notification as read:', error));
}

// Mark all notifications as read
function markAllNotificationsAsRead() {
    fetch('api/admin_api.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=mark_all_notifications_read'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update all notification items
            const unreadItems = document.querySelectorAll('.notification-item.unread');
            unreadItems.forEach(item => {
                item.classList.remove('unread');
                item.classList.add('read');
            });
            
            // Update badge count
            updateNotificationBadge();
        }
    })
    .catch(error => console.error('Error marking all notifications as read:', error));
}

// Remove notification
function removeNotification(notificationId) {
    fetch('api/admin_api.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=remove_notification&notification_id=${notificationId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove from UI
            const notificationItem = document.querySelector(`[data-id="${notificationId}"]`);
            if (notificationItem) {
                notificationItem.remove();
            }
            
            // Update badge count
            updateNotificationBadge();
        }
    })
    .catch(error => console.error('Error removing notification:', error));
}

// Update notification badge count
function updateNotificationBadge() {
    fetch('api/admin_api.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=get_unread_count'
    })
    .then(response => response.json())
    .then(data => {
        const badge = document.getElementById('notificationBadge');
        if (badge) {
            badge.textContent = data.count;
            badge.style.display = data.count > 0 ? 'block' : 'none';
        }
    })
    .catch(error => console.error('Error getting unread count:', error));
}

// Initialize dashboard
function initializeDashboard() {
    // Set up event listeners
    setupEventListeners();
    
    // Load initial data
    loadDashboardData();
}

// Setup event listeners
function setupEventListeners() {
    // Search functionality
    const searchInput = document.getElementById('subscriberSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            filterSubscribers(this.value);
        });
    }
    
    // Form submissions
    const editForm = document.getElementById('editForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            saveContentChanges();
        });
    }
    
    // Settings form
    const settingsForm = document.querySelector('.settings-form');
    if (settingsForm) {
        settingsForm.addEventListener('submit', function(e) {
            e.preventDefault();
            saveSettings();
        });
    }
}

// Load dashboard data
async function loadDashboardData() {
    try {
        // Simulate API calls for now
        console.log('Loading dashboard data...');
    } catch (error) {
        console.error('Error loading dashboard data:', error);
    }
}

// Section navigation
function showSection(sectionName) {
    // Hide all sections
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(section => {
        section.classList.remove('active');
    });
    
    // Show selected section
    const targetSection = document.getElementById(sectionName + '-section');
    if (targetSection) {
        targetSection.classList.add('active');
    }
    
    // Update navigation
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.classList.remove('active');
    });
    
    const activeLink = document.querySelector(`[href="#${sectionName}"]`);
    if (activeLink) {
        activeLink.classList.add('active');
    }
    
    // Update page title
    updatePageTitle(sectionName);
    
    currentSection = sectionName;
    
    // Load section-specific data
    loadSectionData(sectionName);
}

// Update page title
function updatePageTitle(section) {
    const titles = {
        'dashboard': 'Dashboard Overview',
        'content': 'Content Management',
        'newsletter': 'Newsletter Management',
        'ecosystem': 'Ecosystem Management',
        'analytics': 'Analytics & Reports',
        'settings': 'Admin Settings'
    };
    
    const pageTitle = document.querySelector('.page-title');
    if (pageTitle && titles[section]) {
        pageTitle.textContent = titles[section];
    }
}

// Load section-specific data
function loadSectionData(section) {
    switch(section) {
        case 'newsletter':
            loadSubscribers();
            break;
        case 'analytics':
            updateCharts();
            break;
        case 'content':
            loadContentData();
            break;
        case 'ecosystem':
            loadEcosystemItems();
            break;
    }
}

// Toggle sidebar
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    if (sidebar) {
        sidebar.classList.toggle('active');
    }
}

// Logout function
function logout() {
    if (confirm('Are you sure you want to logout?')) {
        window.location.href = 'login.php';
    }
}

// Update date and time
function updateDateTime() {
    const dateTimeElement = document.getElementById('dateTime');
    if (dateTimeElement) {
        const now = new Date();
        const options = { 
            weekday: 'short', 
            year: 'numeric', 
            month: 'short', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };
        dateTimeElement.textContent = now.toLocaleDateString('en-US', options);
    }
}

// Newsletter Management
async function loadSubscribers() {
    try {
        const response = await fetch('../api/admin.php?action=get_subscribers', {
            credentials: 'same-origin'
        });
        const data = await response.json();
        
        if (data.success) {
            subscribersData = data.data.subscribers;
            displaySubscribers(subscribersData);
        } else {
            console.error('Error loading subscribers:', data.message);
        }
    } catch (error) {
        console.error('Error loading subscribers:', error);
        // Fallback to mock data
        const mockData = [
            { id: 1, email: 'user1@example.com', status: 'active', created_at: '2024-01-15 10:30:00' },
            { id: 2, email: 'user2@example.com', status: 'active', created_at: '2024-01-14 15:45:00' },
            { id: 3, email: 'user3@example.com', status: 'inactive', created_at: '2024-01-13 09:20:00' },
            { id: 4, email: 'user4@example.com', status: 'active', created_at: '2024-01-12 14:10:00' },
            { id: 5, email: 'user5@example.com', status: 'active', created_at: '2024-01-11 11:25:00' }
        ];
        
        subscribersData = mockData;
        displaySubscribers(mockData);
    }
}

// Display subscribers in table
function displaySubscribers(subscribers) {
    const tbody = document.getElementById('subscribersList');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    subscribers.forEach(subscriber => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${subscriber.id}</td>
            <td>${subscriber.email}</td>
            <td>
                <span class="status-badge ${subscriber.status}">
                    ${subscriber.status}
                </span>
            </td>
            <td>${formatDate(subscriber.created_at)}</td>
            <td>
                <div class="table-actions">
                    <button class="btn btn-sm btn-outline" onclick="editSubscriber(${subscriber.id})">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="deleteSubscriber(${subscriber.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>
        `;
        tbody.appendChild(row);
    });
}

// Filter subscribers
function filterSubscribers(searchTerm) {
    const filtered = subscribersData.filter(subscriber => 
        subscriber.email.toLowerCase().includes(searchTerm.toLowerCase())
    );
    displaySubscribers(filtered);
}

// Edit subscriber
function editSubscriber(id) {
    const subscriber = subscribersData.find(s => s.id === id);
    if (subscriber) {
        // Open modal for editing
        console.log('Editing subscriber:', subscriber);
    }
}

// Delete subscriber
async function deleteSubscriber(id) {
    if (confirm('Are you sure you want to delete this subscriber?')) {
        try {
            const response = await fetch(`../api/admin.php?action=delete_subscriber&id=${id}`, {
                method: 'DELETE',
                credentials: 'same-origin'
            });
            const data = await response.json();
            
            if (data.success) {
                subscribersData = subscribersData.filter(s => s.id !== id);
                displaySubscribers(subscribersData);
                showNotification('Subscriber deleted successfully', 'success');
            } else {
                showNotification('Error deleting subscriber: ' + data.message, 'error');
            }
        } catch (error) {
            console.error('Error deleting subscriber:', error);
            showNotification('Error deleting subscriber', 'error');
        }
    }
}

function exportSubscribers() {
    let csvContent = "ID,Email,Status,Created At\n";
    subscribersData.forEach(subscriber => {
        csvContent += `${subscriber.id},${subscriber.email},${subscriber.status},${subscriber.created_at}\n`;
    });
    
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'subscribers.csv';
    a.click();
    window.URL.revokeObjectURL(url);
    
    showNotification('Subscribers exported successfully', 'success');
}

// Content Management
function loadContentData() {
    console.log('Content data loaded');
}

function loadEcosystemItems() {
    console.log('Ecosystem items loaded');
}

function editWhoWeAre() {
    const title = document.getElementById('whoWeAreTitle').textContent;
    const content = document.getElementById('whoWeAreContent').textContent;
    
    document.getElementById('modalTitle').textContent = 'Edit Who We Are Section';
    document.getElementById('editType').value = 'who_we_are';
    document.getElementById('editId').value = '1';
    document.getElementById('editTitle').value = title;
    document.getElementById('editContent').value = content;
    document.getElementById('editStatus').value = 'active';
    hideAllFormFields();
    document.getElementById('whoWeAreFields').style.display = 'block';
    
    openModal();
}


function editHeartOfMission() {
    const title = document.getElementById('heartOfMissionTitle').textContent;
    const content = document.getElementById('heartOfMissionContent').textContent;
    
    document.getElementById('modalTitle').textContent = 'Edit Heart of Mission Section';
    document.getElementById('editType').value = 'heart_of_mission';
    document.getElementById('editId').value = '1';
    document.getElementById('editTitle').value = title;
    document.getElementById('editContent').value = content;
    document.getElementById('editStatus').value = 'active'; // Default to active
    
    // Show Heart of Mission fields
    hideAllFormFields();
    document.getElementById('heartOfMissionFields').style.display = 'block';
    
    openModal();
}

// Banner Management
function addBanner() {
    document.getElementById('modalTitle').textContent = 'Add New Banner';
    document.getElementById('editType').value = 'banner';
    document.getElementById('editId').value = '';
    document.getElementById('editTitle').value = '';
    document.getElementById('editContent').value = '';
    document.getElementById('editImage').value = '';
    document.getElementById('editPosition').value = '1';
    
    // Hide current image preview for new banners
    const currentImagePreview = document.getElementById('currentImagePreview');
    if (currentImagePreview) {
        currentImagePreview.style.display = 'none';
    }
    
    // Show Banner fields
    hideAllFormFields();
    // document.getElementById('bannerFields').style.display = 'block';
    
    openModal();
    setTimeout(() => initializeBannerDropzone(), 100);
}

function editBanner(id) {
    // Get banner data from the grid
    const bannerItems = document.querySelectorAll('.banner-item-admin');
    let bannerData = null;
    
    bannerItems.forEach(item => {
        const editBtn = item.querySelector('button[onclick*="editBanner"]');
        if (editBtn && editBtn.getAttribute('onclick').includes(id)) {
            const title = item.querySelector('h4').textContent;
            const content = item.querySelector('p').textContent;
            const imageSrc = item.querySelector('img').src;
            bannerData = { title, content, image_path: imageSrc.replace('../', '') };
        }
    });
    
    if (bannerData) {
        document.getElementById('modalTitle').textContent = 'Edit Banner';
        document.getElementById('editType').value = 'banner';
        document.getElementById('editId').value = id;
        document.getElementById('editTitle').value = bannerData.title;
        document.getElementById('editContent').value = bannerData.content;
        document.getElementById('editImage').value = bannerData.image_path;
        document.getElementById('editPosition').value = '1';
        
        // Show current image preview
        const currentImagePreview = document.getElementById('currentImagePreview');
        const currentImage = document.getElementById('currentImage');
        if (currentImagePreview && currentImage) {
            currentImage.src = '../' + bannerData.image_path;
            currentImagePreview.style.display = 'block';
        }
        
        // Show Banner fields
        hideAllFormFields();
        // document.getElementById('bannerFields').style.display = 'block';
        
        openModal();
        
        // Initialize dropzone after modal is open
        setTimeout(() => {
            initializeBannerDropzone();
        }, 200);
    }
}






async function deleteBanner(id) {
    if (confirm('Are you sure you want to delete this banner?')) {
        try {
            const response = await fetch(`../api/admin.php?action=delete_banner&id=${id}`, {
                method: 'DELETE',
                credentials: 'same-origin'
            });
            const data = await response.json();
            
            if (data.success) {
                showNotification('Banner deleted successfully', 'success');
                location.reload(); // Reload to update the banner grid
            } else {
                showNotification('Error deleting banner: ' + data.message, 'error');
            }
        } catch (error) {
            console.error('Error deleting banner:', error);
            showNotification('Error deleting banner', 'error');
        }
    }
}

// Initialize banner dropzone in modal
function initializeBannerDropzone() {
    // Remove existing dropzone instance if it exists
    if (window.bannerModalDropzone) {
        window.bannerModalDropzone.destroy();
    }
    
    // Initialize new dropzone
    window.bannerModalDropzone = new Dropzone('#bannerModalDropzone', {
        maxFilesize: 5, // MB
        acceptedFiles: 'image/*',
        addRemoveLinks: true,
        dictDefaultMessage: 'Drop new image here or click to upload (replaces current image)',
        dictRemoveFile: 'Remove file',
        maxFiles: 1,
        paramName: 'file',
        params: {
            action: 'upload_only'
        },
        init: function() {
            this.on('success', function(file, response) {
                try {
                    const data = typeof response === 'string' ? JSON.parse(response) : response;
                    document.getElementById('editImage').value = data.image_path;
                    
                    const currentImagePreview = document.getElementById('currentImagePreview');
                    if (currentImagePreview) {
                        currentImagePreview.style.display = 'none';
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                }
            });
            
            this.on('removedfile', function(file) {
                // Clear hidden input if file is removed
                if (this.files.length === 0) {
                    document.getElementById('editImage').value = '';
                    
                    // Show current image preview again if no new file
                    const currentImagePreview = document.getElementById('currentImagePreview');
                    if (currentImagePreview && document.getElementById('editId').value) {
                        currentImagePreview.style.display = 'block';
                    }
                }
            });
            
            this.on('error', function(file, response) {
                try {
                    const data = typeof response === 'string' ? JSON.parse(response) : response;
                    showNotification('Upload failed: ' + (data.message || response), 'error');
                } catch (e) {
                    showNotification('Upload failed: ' + response, 'error');
                }
            });
        }
    });
}

// Ecosystem Management
function addEcosystemItem() {
    document.getElementById('modalTitle').textContent = 'Add Ecosystem Item';
    document.getElementById('editType').value = 'ecosystem';
    document.getElementById('editId').value = '';
    document.getElementById('editTitle').value = '';
    document.getElementById('editContent').value = '';
    document.getElementById('editCategory').value = 'platform';
    document.getElementById('editIcon').value = 'fa-globe';
    
    // Show Ecosystem fields
    hideAllFormFields();
    document.getElementById('ecosystemFields').style.display = 'block';
    
    openModal();
}

function editEcosystemItem(id, name, description, icon, category) {
    document.getElementById('modalTitle').textContent = 'Edit Ecosystem Item';
    document.getElementById('editType').value = 'ecosystem';
    document.getElementById('editId').value = id;
    document.getElementById('editTitle').value = name;
    document.getElementById('editContent').value = description;
    document.getElementById('editCategory').value = category || 'platform';
    document.getElementById('editIcon').value = icon;
    
    // Show Ecosystem fields
    hideAllFormFields();
    document.getElementById('ecosystemFields').style.display = 'block';
    
    openModal();
}

async function deleteEcosystemItem(id) {
    if (confirm('Are you sure you want to delete this ecosystem item?')) {
        try {
            const response = await fetch(`../api/admin.php?action=delete_ecosystem&id=${id}`, {
                method: 'DELETE',
                credentials: 'same-origin'
            });
            const data = await response.json();
            
            if (data.success) {
                showNotification('Ecosystem item deleted successfully', 'success');
                location.reload(); // Reload to update the ecosystem grid
            } else {
                showNotification('Error deleting ecosystem item: ' + data.message, 'error');
            }
        } catch (error) {
            console.error('Error deleting ecosystem item:', error);
            showNotification('Error deleting ecosystem item', 'error');
        }
    }
}

// Helper function to hide all form fields
function hideAllFormFields() {
    const fields = ['whoWeAreFields', 'heartOfMissionFields', 'bannerFields', 'ecosystemFields'];
    fields.forEach(fieldId => {
        const element = document.getElementById(fieldId);
        if (element) {
            element.style.display = 'none';
        }
    });
}

// Change content type in modal
function changeContentType() {
    const contentType = document.getElementById('contentTypeSelect').value;
    hideAllFormFields();
    
    if (contentType) {
        document.getElementById('editType').value = contentType;
        const fieldId = contentType === 'who_we_are' ? 'whoWeAreFields' : 
                       contentType === 'heart_of_mission' ? 'heartOfMissionFields' : 
                       contentType === 'banner' ? 'bannerFields' : '';
        
        if (fieldId && document.getElementById(fieldId)) {
            document.getElementById(fieldId).style.display = 'block';
        }
    }
}

async function saveContentChanges() {
    const editType = document.getElementById('editType').value;
    const editId = document.getElementById('editId').value;
    const title = document.getElementById('editTitle').value;
    const content = document.getElementById('editContent').value;
    
    try {
        let url = '../api/admin.php?action=update_content';
        let body = {
            type: editType,
            id: editId,
            title: title,
            content: content
        };
        
        // Add type-specific fields
        if (editType === 'who_we_are' || editType === 'heart_of_mission') {
            const image_path = document.getElementById('editImage').value;
            const status = document.getElementById('editStatus').value;
            if (image_path) body.image_path = image_path;
            if (status) body.status = status;
        } else if (editType === 'banner') {
            const image_path = document.getElementById('editImage').value;
            const position = document.getElementById('editPosition').value;
            if (image_path) body.image_path = image_path;
            if (position) body.position = position;
        } else if (editType === 'ecosystem') {
            const icon = document.getElementById('editIcon').value;
            const category = document.getElementById('editCategory').value;
            if (icon) body.icon = icon;
            if (category) body.category = category;
        }
        
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            credentials: 'same-origin',
            body: JSON.stringify(body)
        });
        
        const data = await response.json();
        
        if (data.success) {
            closeModal();
            showNotification('Content updated successfully', 'success');
            location.reload(); // Reload to show updated content
        } else {
            showNotification('Error saving content: ' + data.message, 'error');
        }
    } catch (error) {
        console.error('Error saving content:', error);
        showNotification('Error saving content', 'error');
    }
}

// Charts
function initializeCharts() {
    // Subscriber Growth Chart
    const subscriberCtx = document.getElementById('subscriberChart');
    if (subscriberCtx) {
        new Chart(subscriberCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Subscribers',
                    data: [120, 150, 180, 200, 170, 220],
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4
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
                        beginAtZero: true
                    }
                }
            }
        });
    }
    
    // Newsletter Performance Chart
    const performanceCtx = document.getElementById('performanceChart');
    if (performanceCtx) {
        new Chart(performanceCtx, {
            type: 'doughnut',
            data: {
                labels: ['Opened', 'Clicked', 'Bounced'],
                datasets: [{
                    data: [68, 24, 8],
                    backgroundColor: [
                        '#10b981',
                        '#667eea',
                        '#ef4444'
                    ]
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
    }
}

function updateCharts() {
    // Update chart data based on current filters
    console.log('Updating charts...');
}

// Settings
function saveSettings() {
    showNotification('Settings saved successfully', 'success');
}

// Modal functions
function openModal() {
    const modal = document.getElementById('editModal');
    if (modal) {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
}

function closeModal() {
    const modal = document.getElementById('editModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        
        // Clean up dropzone instance
        if (window.bannerModalDropzone) {
            window.bannerModalDropzone.destroy();
            window.bannerModalDropzone = null;
        }
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('editModal');
    if (modal && event.target === modal) {
        closeModal();
    }
}

// Notifications
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <i class="fas fa-${getNotificationIcon(type)}"></i>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()">&times;</button>
    `;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

function getNotificationIcon(type) {
    const icons = {
        'success': 'check-circle',
        'error': 'exclamation-circle',
        'warning': 'exclamation-triangle',
        'info': 'info-circle'
    };
    return icons[type] || 'info-circle';
}

// Utility functions
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

const saveBanner=()=>{
    showNotification('Banner saved successfully', 'success');
}

// Add notification styles
const styleSheet = document.createElement('style');
if (!document.getElementById('notificationStyles')) {
    styleSheet.id = 'notificationStyles';
    styleSheet.type = 'text/css';
    document.head.appendChild(styleSheet);
    styleSheet.textContent = `
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            border-radius: 0.5rem;
            padding: 1rem 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            z-index: 3000;
            animation: slideInRight 0.3s ease;
            max-width: 400px;
        }
        
        .notification-success {
            border-left: 4px solid #10b981;
            color: #10b981;
        }
        
        .notification-error {
            border-left: 4px solid #ef4444;
            color: #ef4444;
        }
        
        .notification-warning {
            border-left: 4px solid #f59e0b;
            color: #f59e0b;
        }
        
        .notification-info {
            border-left: 4px solid #3b82f6;
            color: #3b82f6;
        }
        
        .notification button {
            background: none;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
            color: inherit;
            padding: 0;
            margin-left: auto;
        }
        
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .status-badge.active {
            background: #dcfce7;
            color: #16a34a;
        }
        
        .status-badge.inactive {
            background: #fef3c7;
            color: #d97706;
        }
        
        .status-badge.unsubscribed {
            background: #fee2e2;
            color: #dc2626;
        }
        
        .table-actions {
            display: flex;
            gap: 0.5rem;
        }
    `;
}
